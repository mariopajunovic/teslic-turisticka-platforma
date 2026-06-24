<script setup>
import { computed } from 'vue'
import { icons } from '@/constants/icons'

const props = defineProps({
  name: { type: String, required: true },
  size: { type: [Number, String], default: 20 },
})

const component = computed(() => {
  const icon = icons[props.name]
  if (!icon && import.meta.env.DEV) {
    console.warn(`[BaseIcon] Nepoznata ikona: "${props.name}". Dodaj je u src/constants/icons.js`)
  }
  return icon || null
})
</script>

<template>
  <component
    :is="component"
    v-if="component"
    :size="Number(size)"
    :stroke-width="1.75"
    aria-hidden="true"
  />
</template>
