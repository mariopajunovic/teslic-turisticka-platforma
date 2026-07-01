<script setup>
// Legenda = filter: jedna lista kategorija (klik = uključi/isključi sloj).
// Boja i ikona se povlače iz baze (Category.color / Category.icon).
import { computed, ref } from 'vue'
import { useCategories } from '@/composables/useCategories'
import { categoryColor, isLightColor } from './markerIcon'
import SearchInput from '@/components/common/SearchInput.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const { categories } = useCategories()

const model = defineModel({ type: Array, default: () => [] })
const naselje = defineModel('naselje', { type: String, default: '' })
const props = defineProps({
  naselja: { type: Array, default: () => [] },
  availableKeys: { type: Array, default: null },
})
const emit = defineEmits(['search'])

const vidljiveKategorije = computed(() =>
  props.availableKeys
    ? categories.filter((c) => props.availableKeys.includes(c.key))
    : categories,
)

const query = ref('')

function onSearch(value) {
  emit('search', value)
}

function isActive(key) {
  return model.value.includes(key)
}

function toggle(key) {
  model.value = isActive(key) ? model.value.filter((k) => k !== key) : [...model.value, key]
}

function reset() {
  model.value = []
}

const colorOf = (cat) => cat.color || categoryColor(cat.key)
const swatchText = (cat) => (isLightColor(colorOf(cat)) ? 'text-heading' : 'text-white')
</script>

<template>
  <div class="space-y-4 rounded-md border border-border bg-surface p-4">
    <SearchInput v-model="query" placeholder="Pretraži ponudu…" @submit="onSearch" />

    <div v-if="naselja.length" class="space-y-1.5">
      <h3 class="text-sm font-semibold text-heading">Naselje</h3>
      <select
        v-model="naselje"
        class="w-full rounded-sm border border-border bg-surface px-2.5 py-2 text-sm text-text"
      >
        <option value="">Sva naselja</option>
        <option v-for="n in naselja" :key="n" :value="n">{{ n }}</option>
      </select>
    </div>

    <div class="flex items-center justify-between">
      <h3 class="text-sm font-semibold text-heading">Kategorije</h3>
      <button
        v-if="model.length"
        type="button"
        class="text-xs font-medium text-primary hover:underline"
        @click="reset"
      >
        Poništi ({{ model.length }})
      </button>
    </div>

    <ul class="space-y-1.5">
      <li v-for="cat in vidljiveKategorije" :key="cat.key">
        <button
          type="button"
          class="flex w-full items-center gap-2.5 rounded-sm border px-2.5 py-2 text-left text-sm transition-colors"
          :class="
            isActive(cat.key)
              ? 'border-primary bg-primary-tint text-heading'
              : 'border-border text-text hover:bg-surface-alt'
          "
          :aria-pressed="isActive(cat.key)"
          @click="toggle(cat.key)"
        >
          <span
            class="inline-flex size-6 shrink-0 items-center justify-center rounded-full"
            :class="swatchText(cat)"
            :style="{ backgroundColor: colorOf(cat) }"
          >
            <BaseIcon :name="cat.icon" :size="14" />
          </span>
          <span class="flex-1 truncate">{{ cat.label }}</span>
          <BaseIcon
            v-if="isActive(cat.key)"
            name="check"
            :size="16"
            class="shrink-0 text-primary"
          />
        </button>
      </li>
    </ul>

    <p class="text-xs text-text-muted">
      Klik na kategoriju filtrira mapu. Bez odabira — prikazane su sve.
    </p>
  </div>
</template>
