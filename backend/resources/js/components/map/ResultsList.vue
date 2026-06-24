<script setup>
// Kompaktna lista rezultata uz mapu — klik na red emituje `select`.
import { categoryByKey } from '@/constants/categories'
import { categoryColor } from './markerIcon'
import BaseChip from '@/components/base/BaseChip.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

defineProps({
  items: { type: Array, default: () => [] },
})

defineEmits(['select'])

function itemKey(item) {
  return item.id ?? item.slug
}

function category(item) {
  return categoryByKey[item.kategorija] || null
}
</script>

<template>
  <div class="rounded-md border border-border bg-surface">
    <h3 class="border-b border-border px-4 py-3 text-sm font-semibold text-heading">
      Rezultati ({{ items.length }})
    </h3>

    <ul class="max-h-[480px] divide-y divide-border overflow-y-auto">
      <li v-for="item in items" :key="itemKey(item)">
        <button
          type="button"
          class="flex w-full items-center gap-3 px-4 py-3 text-left transition-colors hover:bg-surface-alt"
          @click="$emit('select', item)"
        >
          <span class="size-12 shrink-0 overflow-hidden rounded-sm bg-primary-tint">
            <img
              v-if="item.slika"
              :src="item.slika"
              :alt="item.naslov"
              loading="lazy"
              class="size-full object-cover"
            />
            <span
              v-else
              class="flex size-full items-center justify-center"
              :class="item.kategorija === 'dogadjaj' ? 'text-heading' : 'text-white'"
              :style="{ backgroundColor: categoryColor(item.kategorija) }"
            >
              <BaseIcon v-if="category(item)" :name="category(item).icon" :size="20" />
            </span>
          </span>

          <span class="min-w-0 flex-1 space-y-1">
            <span class="block truncate font-semibold text-heading">{{ item.naslov }}</span>
            <span class="flex flex-wrap items-center gap-2">
              <BaseChip
                v-if="category(item)"
                variant="kategorija"
                :label="category(item).label"
                :icon="category(item).icon"
              />
            </span>
            <span
              v-if="item.lokacija"
              class="flex items-center gap-1 text-sm text-text-muted"
            >
              <BaseIcon name="map-pin" :size="14" />
              <span class="truncate">{{ item.lokacija }}</span>
            </span>
          </span>
        </button>
      </li>
    </ul>

    <p v-if="items.length === 0" class="px-4 py-8 text-center text-sm text-text-muted">
      Nema rezultata za prikaz.
    </p>
  </div>
</template>
