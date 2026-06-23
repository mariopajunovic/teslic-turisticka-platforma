<script setup>
// Bogata kartica za odabrani marker — koristi se kad parent uhvati `select`
// (npr. plutajuća kartica ili bottom-sheet na mobilnom).
import { computed } from 'vue'
import { categoryByKey } from '@/constants/categories'
import BaseChip from '@/components/base/BaseChip.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import CardImage from '@/components/cards/CardImage.vue'

const props = defineProps({
  item: { type: Object, required: true },
})

defineEmits(['close'])

const category = computed(() => categoryByKey[props.item.kategorija] || null)
</script>

<template>
  <div class="relative w-[280px] overflow-hidden rounded-md bg-surface shadow-[var(--shadow-lg)]">
    <button
      type="button"
      class="absolute right-2 top-2 z-10 inline-flex size-8 items-center justify-center rounded-full bg-surface/90 text-heading shadow-[var(--shadow-sm)] transition-colors hover:bg-surface-alt"
      aria-label="Zatvori"
      @click="$emit('close')"
    >
      <BaseIcon name="x" :size="18" />
    </button>

    <CardImage :src="item.slika" :alt="item.naslov" />

    <div class="space-y-2.5 p-4">
      <h3 class="font-semibold text-heading">{{ item.naslov }}</h3>

      <BaseChip
        v-if="category"
        variant="kategorija"
        :label="category.label"
        :icon="category.icon"
      />

      <p v-if="item.lokacija" class="flex items-center gap-1.5 text-sm text-text-muted">
        <BaseIcon name="map-pin" :size="16" />
        <span>{{ item.lokacija }}</span>
      </p>

      <BaseButton
        v-if="item.to"
        variant="ghost"
        size="sm"
        icon="arrow-right"
        icon-position="right"
        :to="item.to"
      >
        Detalji
      </BaseButton>
    </div>
  </div>
</template>
