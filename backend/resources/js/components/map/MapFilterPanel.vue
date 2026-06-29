<script setup>
// Legenda = filter: jedna lista kategorija (klik = uključi/isključi sloj).
// Boja i ikona se povlače iz baze (Category.color / Category.icon).
import { ref } from 'vue'
import { useCategories } from '@/composables/useCategories'
import { categoryColor, isLightColor } from './markerIcon'
import SearchInput from '@/components/common/SearchInput.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const { categories } = useCategories()

const model = defineModel({ type: Array, default: () => [] })
const naselje = defineModel('naselje', { type: String, default: '' })
const props = defineProps({
  naselja: { type: Array, default: () => [] },
})
const emit = defineEmits(['search'])

const query = ref('')
const open = ref(false)

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

    <div class="relative">
      <button
        type="button"
        class="flex w-full items-center justify-between gap-2 rounded-sm border border-border bg-surface px-3 py-2.5 text-sm transition-colors hover:bg-surface-alt"
        :aria-expanded="open"
        @click="open = !open"
      >
        <span class="flex items-center gap-2">
          <BaseIcon name="sliders-horizontal" :size="16" class="text-text-muted" />
          <span class="font-medium text-heading">Kategorije</span>
          <span
            v-if="model.length"
            class="inline-flex min-w-5 items-center justify-center rounded-full bg-primary px-1.5 text-xs font-semibold text-white"
          >
            {{ model.length }}
          </span>
        </span>
        <BaseIcon
          name="chevron-down"
          :size="16"
          class="shrink-0 text-text-muted transition-transform"
          :class="open ? 'rotate-180' : ''"
        />
      </button>

      <div v-if="open">
        <button
          type="button"
          class="fixed inset-0 z-10 cursor-default"
          aria-hidden="true"
          tabindex="-1"
          @click="open = false"
        />
        <div
          class="absolute inset-x-0 z-20 mt-2 rounded-md border border-border bg-surface p-2 shadow-[var(--shadow-lg)]"
        >
          <div class="flex items-center justify-between px-1 pb-2">
            <span class="text-xs font-semibold uppercase tracking-wide text-text-muted">
              Filtriraj po kategoriji
            </span>
            <button
              v-if="model.length"
              type="button"
              class="text-xs font-medium text-primary hover:underline"
              @click="reset"
            >
              Poništi
            </button>
          </div>
          <ul class="max-h-72 space-y-1 overflow-y-auto">
            <li v-for="cat in categories" :key="cat.key">
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
        </div>
      </div>
    </div>

    <p class="text-xs text-text-muted">
      Odaberite kategorije za filtriranje mape. Bez odabira — prikazane su sve.
    </p>
  </div>
</template>
