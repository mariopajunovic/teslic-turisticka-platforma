<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';

const props = defineProps({
    lat: { type: [Number, String], default: null },
    lng: { type: [Number, String], default: null },
    center: { type: Array, default: () => [44.6089, 17.8608] },
    zoom: { type: Number, default: 13 },
});

const emit = defineEmits(['update:lat', 'update:lng']);

const mapEl = ref(null);
let L = null;
let map = null;
let marker = null;
let ro = null;

const num = (v) => {
    const n = parseFloat(v);
    return Number.isFinite(n) ? n : null;
};

const pin = () => L.divIcon({
    className: 'to-pin',
    html: '<span style="display:block;width:20px;height:20px;background:#0E8275;border:2px solid #fff;border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 1px 4px rgba(15,23,42,.35)"></span>',
    iconSize: [20, 20],
    iconAnchor: [10, 20],
});

const emitLatLng = (lat, lng) => {
    emit('update:lat', Number(lat.toFixed(6)));
    emit('update:lng', Number(lng.toFixed(6)));
};

const place = (lat, lng) => {
    if (!map) return;
    if (marker) {
        marker.setLatLng([lat, lng]);
    } else {
        marker = L.marker([lat, lng], { draggable: true, icon: pin() }).addTo(map);
        marker.on('dragend', () => {
            const p = marker.getLatLng();
            emitLatLng(p.lat, p.lng);
        });
    }
};

onMounted(async () => {
    L = (await import('leaflet')).default;
    await import('leaflet/dist/leaflet.css');

    const lat = num(props.lat);
    const lng = num(props.lng);
    const start = (lat != null && lng != null) ? [lat, lng] : props.center;

    map = L.map(mapEl.value, {
        center: start,
        zoom: props.zoom,
        scrollWheelZoom: true,
        dragging: true,
        tap: true,
    });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap',
        maxZoom: 19,
    }).addTo(map);

    if (lat != null && lng != null) {
        place(lat, lng);
    }

    map.on('click', (e) => emitLatLng(e.latlng.lat, e.latlng.lng));

    map.invalidateSize();
    setTimeout(() => map && map.invalidateSize(), 200);

    if (typeof ResizeObserver !== 'undefined') {
        ro = new ResizeObserver(() => map && map.invalidateSize());
        ro.observe(mapEl.value);
    }
});

watch(() => [props.lat, props.lng], ([la, ln]) => {
    const lat = num(la);
    const lng = num(ln);
    if (map && lat != null && lng != null) {
        place(lat, lng);
        map.setView([lat, lng]);
    }
});

onBeforeUnmount(() => {
    if (ro) {
        ro.disconnect();
        ro = null;
    }
    if (map) {
        map.remove();
        map = null;
        marker = null;
    }
});
</script>

<template>
    <div ref="mapEl" class="relative z-0 h-60 w-full overflow-hidden rounded-md border border-line bg-surface-alt"></div>
</template>
