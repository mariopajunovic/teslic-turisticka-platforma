<script setup>
// Panel slojeva/filtera za mapu. v-model = niz aktivnih key-eva kategorija.
import { ref } from 'vue'
import { useCategories } from '@/composables/useCategories'
import { categoryColor } from './markerIcon'
import SearchInput from '@/components/common/SearchInput.vue'
import FormCheckbox from '@/components/forms/FormCheckbox.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const { categories } = useCategories()

const model = defineModel({ type: Array, default: () => [] })

const emit = defineEmits(['search'])

const query = ref('')

function onSearch(value) {
  emit('search', value)
}

function isChecked(key) {
  return model.value.includes(key)
}

function toggle(key, checked) {
  if (checked) {
    if (!model.value.includes(key)) model.value = [...model.value, key]
  } else {
    model.value = model.value.filter((k) => k !== key)
  }
}
</script>

<template>
  <div class="space-y-5 rounded-md border border-border bg-surface p-4">
    <SearchInput
      v-model="query"
      placeholder="Pretraži ponudu…"
      @submit="onSearch"
    />

    <div class="space-y-3">
      <h3 class="text-sm font-semibold text-heading">Slojevi</h3>
      <ul class="space-y-2.5">
        <li v-for="cat in categories" :key="cat.key">
          <FormCheckbox
            :model-value="isChecked(cat.key)"
            :label="cat.label"
            @update:model-value="(v) => toggle(cat.key, v)"
          />
        </li>
      </ul>
    </div>

    <div class="space-y-2.5 border-t border-border pt-4">
      <h3 class="text-sm font-semibold text-heading">Legenda</h3>
      <ul class="grid grid-cols-2 gap-x-3 gap-y-2">
        <li
          v-for="cat in categories"
          :key="cat.key"
          class="flex items-center gap-2 text-sm text-text"
        >
          <span
            class="inline-flex size-6 shrink-0 items-center justify-center rounded-full"
            :class="cat.key === 'dogadjaj' ? 'text-heading' : 'text-white'"
            :style="{ backgroundColor: categoryColor(cat.key) }"
          >
            <BaseIcon :name="cat.icon" :size="14" />
          </span>
          <span class="truncate">{{ cat.label }}</span>
        </li>
      </ul>
    </div>
  </div>
</template>
