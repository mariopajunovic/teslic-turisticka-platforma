<script setup>
import { onMounted, onUnmounted, ref, watch, nextTick } from 'vue'
import { useCategories } from '@/composables/useCategories'
import { categoryIcon } from './markerIcon'

const { categoryByKey } = useCategories()

let L = null

const props = defineProps({
  items: { type: Array, default: () => [] },
  activeCategories: { type: Array, default: () => [] },
  center: { type: Array, default: () => [44.6078, 17.8569] },
  zoom: { type: Number, default: 13 },
  height: { type: String, default: '520px' },
  boundaryUrl: { type: String, default: '/geo/teslic_naselja.geojson' },
  fitToBoundary: { type: Boolean, default: true },
  maskOutside: { type: Boolean, default: true },
  maskColor: { type: String, default: '#06443D' },
  maskOpacity: { type: Number, default: 0.2 },
  lockToBoundary: { type: Boolean, default: true },
  selectedNaselje: { type: String, default: '' },
})

const emit = defineEmits(['select', 'naselja'])

const mapEl = ref(null)
let map = null
let clusterGroup = null

const naseljaLayers = {}
let opstinaBounds = null
let naseljeLabel = null

const naseljeFaintStyle = { color: '#B45309', weight: 1, fill: false, opacity: 0.7 }
const naseljeActiveStyle = {
  color: '#B45309',
  weight: 2.5,
  fill: true,
  fillColor: '#F59E0B',
  fillOpacity: 0.2,
  opacity: 1,
}

function pointInRing(x, y, ring) {
  let inside = false
  for (let i = 0, j = ring.length - 1; i < ring.length; j = i++) {
    const xi = ring[i][0]
    const yi = ring[i][1]
    const xj = ring[j][0]
    const yj = ring[j][1]
    if (yi > y !== yj > y && x < ((xj - xi) * (y - yi)) / (yj - yi) + xi) inside = !inside
  }
  return inside
}

function applyNaselje(name) {
  if (!map || !L) return
  Object.values(naseljaLayers).forEach((l) => l.setStyle(naseljeFaintStyle))
  if (naseljeLabel) {
    map.removeLayer(naseljeLabel)
    naseljeLabel = null
  }

  const layer = name && naseljaLayers[name]
  if (!layer) {
    if (opstinaBounds && opstinaBounds.isValid()) map.fitBounds(opstinaBounds, { padding: [20, 20] })
    return
  }

  layer.setStyle(naseljeActiveStyle)
  layer.bringToFront()
  const b = layer.getBounds()
  map.fitBounds(b, { padding: [40, 40], maxZoom: 14 })
  naseljeLabel = L.marker(b.getCenter(), {
    interactive: false,
    icon: L.divIcon({ className: 'map-naselje-label', html: escapeHtml(name) }),
  }).addTo(map)
}

function escapeHtml(value) {
  return String(value ?? '').replace(
    /[&<>"']/g,
    (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[c],
  )
}

function isVisible(item) {
  if (!props.activeCategories || props.activeCategories.length === 0) return true
  return props.activeCategories.includes(item.kategorija)
}

function popupHtml(item) {
  const cat = categoryByKey[item.kategorija]
  const naziv = escapeHtml(item.naslov)
  const kategorija = escapeHtml(cat?.label || item.kategorija)
  return `
    <div class="map-popup-basic">
      <strong>${naziv}</strong>
      <span>${kategorija}</span>
    </div>
  `
}

function drawMarkers() {
  if (!clusterGroup || !L) return
  clusterGroup.clearLayers()

  props.items.filter(isVisible).forEach((item) => {
    if (item.lat == null || item.lng == null) return
    const cat = categoryByKey[item.kategorija] || {}
    const marker = L.marker([item.lat, item.lng], {
      icon: categoryIcon(L, { color: cat.color, icon: cat.icon || item.kategorija }),
      title: item.naslov,
    })
    marker.bindPopup(popupHtml(item))
    marker.on('click', () => emit('select', item))
    clusterGroup.addLayer(marker)
  })
}

onMounted(async () => {
  L = (await import('leaflet')).default
  await import('leaflet.markercluster')
  await import('leaflet/dist/leaflet.css')
  await import('leaflet.markercluster/dist/MarkerCluster.css')
  await import('leaflet.markercluster/dist/MarkerCluster.Default.css')

  map = L.map(mapEl.value, {
    center: props.center,
    zoom: props.zoom,
    scrollWheelZoom: true,
  })

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap',
    maxZoom: 19,
  }).addTo(map)

  // Granica općine + naselja: maska van granice + obris + nazivi (sve iz naselja GeoJSON-a).
  try {
    const res = await fetch(props.boundaryUrl)
    if (res.ok) {
      const geo = await res.json()
      const isOpstina = (f) => f.properties?.layer === 'Granica_opstine'
      const isUnutarnji = (f) => f.properties?.layer === 'Granica_naselj_mjesta'

      // Vanjska granica općine: skupi prstenove (lat/lng) — bez dodavanja na mapu.
      const parsed = L.geoJSON(geo, { filter: isOpstina })
      const rings = []
      const collect = (ll) => {
        if (!Array.isArray(ll)) return
        if (ll.length && ll[0] && typeof ll[0].lat === 'number') rings.push(ll)
        else ll.forEach(collect)
      }
      parsed.eachLayer((l) => collect(l.getLatLngs()))

      if (rings.length) {
        // Maska: cijeli svijet kao vanjski prsten, granica kao "rupe" → sve van Teslića prekriveno.
        if (props.maskOutside) {
          const world = [
            L.latLng(-89.9, -179.9),
            L.latLng(89.9, -179.9),
            L.latLng(89.9, 179.9),
            L.latLng(-89.9, 179.9),
          ]
          L.polygon([world, ...rings], {
            stroke: false,
            fillColor: props.maskColor,
            fillOpacity: props.maskOpacity,
            interactive: false,
          }).addTo(map)
        }

        // Nazivi naselja (MTEXT točke) — koriste se za uparivanje poligona i imena.
        const texts = geo.features
          .filter((f) => f.geometry?.type === 'Point' && f.properties?.text)
          .map((f) => ({
            name: String(f.properties.text).replace(/\s+/g, ' ').trim(),
            lng: f.geometry.coordinates[0],
            lat: f.geometry.coordinates[1],
          }))

        // Granice naselja: blagi obris + naziv (preko point-in-polygon) za filter.
        L.geoJSON(geo, {
          filter: isUnutarnji,
          style: naseljeFaintStyle,
          interactive: false,
          onEachFeature: (feature, layer) => {
            const ring = feature.geometry?.coordinates?.[0]
            if (!ring) return
            const t = texts.find((tp) => pointInRing(tp.lng, tp.lat, ring))
            if (t && !naseljaLayers[t.name]) naseljaLayers[t.name] = layer
          },
        }).addTo(map)

        emit('naselja', Object.keys(naseljaLayers).sort((a, b) => a.localeCompare(b)))

        // Obris vanjske granice općine (na vrhu maske).
        L.geoJSON(geo, {
          filter: isOpstina,
          style: { color: '#0E8275', weight: 2.5, fill: false },
          interactive: false,
        }).addTo(map)

        const b = parsed.getBounds()
        if (b.isValid()) {
          opstinaBounds = b
          if (props.fitToBoundary) map.fitBounds(b, { padding: [20, 20] })
          if (props.lockToBoundary) {
            map.setMaxBounds(b.pad(0.4))
            map.options.maxBoundsViscosity = 0.8
            map.setMinZoom(Math.max(0, Math.floor(map.getBoundsZoom(b)) - 1))
          }
        }

        if (props.selectedNaselje) applyNaselje(props.selectedNaselje)
      }
    }
  } catch {
    // granica nije kritična — tiho preskoči
  }

  clusterGroup = L.markerClusterGroup({ showCoverageOnHover: false })
  map.addLayer(clusterGroup)

  drawMarkers()

  // Mapa zna biti u skrivenom/animiranom kontejneru pri mountu.
  nextTick(() => map && map.invalidateSize())
})

onUnmounted(() => {
  if (map) {
    map.remove()
    map = null
    clusterGroup = null
  }
})

watch(() => props.items, drawMarkers, { deep: true })
watch(() => props.activeCategories, drawMarkers, { deep: true })
watch(() => props.selectedNaselje, (name) => applyNaselje(name))
</script>

<template>
  <div
    ref="mapEl"
    class="z-0 w-full overflow-hidden rounded-md"
    :style="{ height }"
    role="application"
    aria-label="Interaktivna mapa ponude"
  />
</template>

<style scoped>
:deep(.map-pin-divicon) {
  background: transparent;
  border: 0;
}
:deep(.map-pin-marker) {
  display: block;
  filter: drop-shadow(0 4px 6px rgb(0 0 0 / 0.3));
}
:deep(.map-popup-basic) {
  display: flex;
  flex-direction: column;
  gap: 2px;
}
:deep(.map-popup-basic strong) {
  color: var(--color-heading);
  font-weight: 600;
}
:deep(.map-popup-basic span) {
  color: var(--color-text-muted);
  font-size: 13px;
}
:deep(.map-naselje-label) {
  width: auto !important;
  height: auto !important;
  white-space: nowrap;
  font-size: 11px;
  font-weight: 600;
  color: #92400e;
  text-shadow:
    0 0 2px #fff,
    0 0 2px #fff,
    0 0 3px #fff;
}
</style>
