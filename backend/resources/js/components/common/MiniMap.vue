<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import BaseButton from '@/components/base/BaseButton.vue'

const props = defineProps({
  label: { type: String, default: '' },
  to: { type: [String, Object], default: '/mapa' },
  lat: { type: [Number, String], default: null },
  lng: { type: [Number, String], default: null },
  zoom: { type: Number, default: 14 },
})

const num = (v) => {
  const n = parseFloat(v)
  return Number.isFinite(n) ? n : null
}

const hasGeo = computed(() => num(props.lat) != null && num(props.lng) != null)

const googleUrl = computed(() =>
  hasGeo.value
    ? `https://www.google.com/maps/dir/?api=1&destination=${num(props.lat)},${num(props.lng)}`
    : null,
)

const mapEl = ref(null)
let L = null
let map = null
let ro = null

const pin = () => L.divIcon({
  className: 'to-pin',
  html: '<span style="display:block;width:20px;height:20px;background:#0E8275;border:2px solid #fff;border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 1px 4px rgba(15,23,42,.35)"></span>',
  iconSize: [20, 20],
  iconAnchor: [10, 20],
})

onMounted(async () => {
  if (!hasGeo.value || !mapEl.value) return

  L = (await import('leaflet')).default
  await import('leaflet/dist/leaflet.css')

  const lat = num(props.lat)
  const lng = num(props.lng)

  map = L.map(mapEl.value, {
    center: [lat, lng],
    zoom: props.zoom,
    scrollWheelZoom: false,
    dragging: true,
    tap: true,
  })

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap',
    maxZoom: 19,
  }).addTo(map)

  L.marker([lat, lng], { icon: pin() }).addTo(map)

  ro = new ResizeObserver(() => map && map.invalidateSize())
  ro.observe(mapEl.value)
  setTimeout(() => map && map.invalidateSize(), 200)
})

onBeforeUnmount(() => {
  if (ro) ro.disconnect()
  if (map) {
    map.remove()
    map = null
  }
})
</script>

<template>
  <div class="overflow-hidden rounded-md border border-border bg-surface shadow-[var(--shadow-sm)]">
    <div
      v-if="hasGeo"
      ref="mapEl"
      class="h-[200px] w-full"
      :aria-label="label ? `Mapa: ${label}` : 'Mapa'"
    />
    <div
      v-else
      class="relative flex h-[180px] items-center justify-center bg-primary-tint"
      role="img"
      :aria-label="label ? `Mapa: ${label}` : 'Mapa'"
    >
      <span
        class="pointer-events-none absolute inset-0 opacity-40"
        style="
          background-image:
            linear-gradient(var(--color-primary-tint-2) 1px, transparent 1px),
            linear-gradient(90deg, var(--color-primary-tint-2) 1px, transparent 1px);
          background-size: 28px 28px;
        "
        aria-hidden="true"
      />
      <span class="relative text-primary">
        <BaseIcon name="map-pin" :size="48" />
      </span>
    </div>

    <div class="flex flex-col gap-3 p-4">
      <div v-if="label" class="flex items-center gap-2 text-text">
        <span class="shrink-0 text-primary"><BaseIcon name="map-pin" :size="18" /></span>
        <span class="font-medium">{{ label }}</span>
      </div>
      <BaseButton variant="secondary" size="sm" icon="map" :to="to" block>
        Prikaži na mapi
      </BaseButton>
      <a
        v-if="googleUrl"
        :href="googleUrl"
        target="_blank"
        rel="noopener"
        class="flex items-center justify-center gap-1.5 rounded-sm border border-border px-3 py-2 text-[13px] font-semibold text-text transition-colors hover:border-primary hover:text-primary"
      >
        <BaseIcon name="compass" :size="16" />
        {{ $t('detail.directions') }}
      </a>
    </div>
  </div>
</template>
