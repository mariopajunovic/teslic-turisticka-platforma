<script setup>
import { onMounted, onUnmounted, ref, watch, nextTick } from 'vue'
import { categoryByKey } from '@/constants/categories'
import { categoryIcon } from './markerIcon'

let L = null

const props = defineProps({
  items: { type: Array, default: () => [] },
  activeCategories: { type: Array, default: () => [] },
  center: { type: Array, default: () => [44.6078, 17.8569] },
  zoom: { type: Number, default: 13 },
  height: { type: String, default: '520px' },
})

const emit = defineEmits(['select'])

const mapEl = ref(null)
let map = null
let clusterGroup = null

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
    const marker = L.marker([item.lat, item.lng], {
      icon: categoryIcon(L, item.kategorija),
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
</style>
