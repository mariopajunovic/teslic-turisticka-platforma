<script setup>
import { computed, ref } from 'vue'
import AppContainer from '@/components/layout/AppContainer.vue'
import SectionHeader from '@/components/common/SectionHeader.vue'
import MapInteractive from '@/components/map/MapInteractive.vue'
import MapPopup from '@/components/map/MapPopup.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import { useCategories } from '@/composables/useCategories'
import { categoryColor, isLightColor } from '@/components/map/markerIcon'

const props = defineProps({
  data: { type: Object, default: () => ({}) },
})

const { categoryByKey } = useCategories()

const legenda = computed(() => {
  const keys = [...new Set((props.data.items || []).map((i) => i.kategorija).filter(Boolean))]
  return keys
    .map((k) => categoryByKey[k])
    .filter(Boolean)
    .sort((a, b) => (a.sort ?? 0) - (b.sort ?? 0))
})

const colorOf = (c) => c.color || categoryColor(c.key)

const odabrana = ref(null)

const aktivne = ref([])
const isActive = (key) => aktivne.value.includes(key)
const toggle = (key) => {
  const i = aktivne.value.indexOf(key)
  if (i === -1) aktivne.value.push(key)
  else aktivne.value.splice(i, 1)
}
const filtriraneTacke = computed(() => {
  const items = props.data.items || []
  if (!aktivne.value.length) return items
  return items.filter((t) => aktivne.value.includes(t.kategorija))
})
</script>

<template>
  <AppContainer class="mt-12 space-y-5">
    <SectionHeader
      :title="data.naslov || 'Mapa ponude'"
      :link-text="data.linkText || 'Otvori mapu'"
      :to="data.to || '/mapa'"
    />

    <div class="overflow-hidden rounded-2xl border border-border shadow-[var(--shadow-sm)]">
      <div class="relative">
        <MapInteractive :items="filtriraneTacke" :height="data.height || '440px'" @select="odabrana = $event" />
        <div v-if="odabrana" class="absolute right-4 top-4 z-30">
          <MapPopup :item="odabrana" @close="odabrana = null" />
        </div>
      </div>

      <!-- Legenda = filter (klik na kategoriju filtrira mapu), max 5 u red -->
      <div v-if="legenda.length" class="border-t border-border bg-surface p-4">
        <div class="grid grid-cols-2 gap-2 sm:grid-cols-3 lg:grid-cols-5">
          <button
            v-for="c in legenda"
            :key="c.key"
            type="button"
            class="flex items-center gap-2 rounded-sm border px-2.5 py-2 text-left text-sm transition-colors"
            :class="
              isActive(c.key)
                ? 'border-primary bg-primary-tint text-heading'
                : 'border-border text-text hover:bg-surface-alt'
            "
            :aria-pressed="isActive(c.key)"
            @click="toggle(c.key)"
          >
            <span
              class="inline-flex size-6 shrink-0 items-center justify-center rounded-full"
              :class="isLightColor(colorOf(c)) ? 'text-heading' : 'text-white'"
              :style="{ backgroundColor: colorOf(c) }"
            >
              <BaseIcon :name="c.icon" :size="14" />
            </span>
            <span class="flex-1 truncate">{{ c.label }}</span>
            <BaseIcon v-if="isActive(c.key)" name="check" :size="16" class="shrink-0 text-primary" />
          </button>
        </div>
      </div>
    </div>
  </AppContainer>
</template>
