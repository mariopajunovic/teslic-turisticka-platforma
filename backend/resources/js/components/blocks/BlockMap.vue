<script setup>
import { computed } from 'vue'
import AppContainer from '@/components/layout/AppContainer.vue'
import SectionHeader from '@/components/common/SectionHeader.vue'
import MapInteractive from '@/components/map/MapInteractive.vue'
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
</script>

<template>
  <AppContainer class="mt-12 space-y-5">
    <SectionHeader
      :title="data.naslov || 'Mapa ponude'"
      :link-text="data.linkText || 'Otvori mapu'"
      :to="data.to || '/mapa'"
    />

    <div class="overflow-hidden rounded-2xl border border-border shadow-[var(--shadow-sm)]">
      <MapInteractive :items="data.items || []" :height="data.height || '440px'" />

      <!-- Legenda ispod mape (iz stvarnih kategorija na mapi) -->
      <div
        v-if="legenda.length"
        class="flex flex-wrap items-center justify-center gap-x-6 gap-y-3 border-t border-border bg-surface px-4 py-4"
      >
        <span
          v-for="c in legenda"
          :key="c.key"
          class="flex items-center gap-2 text-sm font-medium text-text"
        >
          <span
            class="flex size-5 shrink-0 items-center justify-center rounded-full"
            :class="isLightColor(colorOf(c)) ? 'text-heading' : 'text-white'"
            :style="{ backgroundColor: colorOf(c) }"
          >
            <BaseIcon :name="c.icon" :size="12" />
          </span>
          {{ c.label }}
        </span>
      </div>
    </div>
  </AppContainer>
</template>
