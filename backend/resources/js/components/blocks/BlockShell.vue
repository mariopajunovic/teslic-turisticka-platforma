<script setup>
import { computed } from 'vue'

const props = defineProps({
  settings: { type: Object, default: () => ({}) },
})

const bgClass = {
  transparent: '',
  surface: 'bg-surface',
  'surface-alt': 'bg-surface-alt',
  'primary-tint': 'bg-primary-tint',
  primary: 'bg-primary text-white',
}

const padClass = {
  none: '',
  sm: 'py-6',
  md: 'py-10 md:py-12',
  lg: 'py-14 md:py-20',
}

const sectionClass = computed(() => [
  bgClass[props.settings?.background] ?? '',
  padClass[props.settings?.padding] ?? '',
])

const narrow = computed(() => props.settings?.width === 'narrow')
</script>

<template>
  <section :class="sectionClass">
    <div v-if="narrow" class="mx-auto max-w-3xl px-4">
      <slot />
    </div>
    <slot v-else />
  </section>
</template>
