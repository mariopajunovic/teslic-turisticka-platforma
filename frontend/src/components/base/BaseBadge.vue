<script setup>
import { computed } from 'vue'

// Tinted status badge: svijetla pozadina + tačkica + jak tekst (AA).
const props = defineProps({
  variant: {
    type: String,
    default: 'objavljeno',
    validator: (v) =>
      [
        'objavljeno',
        'na-odobrenju',
        'nacrt',
        'isteklo',
        'odbijeno',
        'preporuceno',
        'zavrseno',
      ].includes(v),
  },
  label: { type: String, default: '' },
})

const map = {
  objavljeno: { bg: 'bg-success-tint', text: 'text-success', dot: 'bg-success', def: 'Objavljeno' },
  'na-odobrenju': {
    bg: 'bg-warning-tint',
    text: 'text-warning',
    dot: 'bg-warning',
    def: 'Na odobrenju',
  },
  nacrt: {
    bg: 'bg-neutral-tint',
    text: 'text-neutral-badge',
    dot: 'bg-neutral-badge',
    def: 'Nacrt',
  },
  isteklo: {
    bg: 'bg-neutral-tint',
    text: 'text-neutral-badge',
    dot: 'bg-neutral-badge',
    def: 'Isteklo',
  },
  zavrseno: {
    bg: 'bg-neutral-tint',
    text: 'text-neutral-badge',
    dot: 'bg-neutral-badge',
    def: 'Završeno',
  },
  odbijeno: { bg: 'bg-error-tint', text: 'text-error', dot: 'bg-error', def: 'Odbijeno' },
  preporuceno: {
    bg: 'bg-accent-tint',
    text: 'text-accent-deep',
    dot: 'bg-accent',
    def: 'Preporučeno',
  },
}

const style = computed(() => map[props.variant])
const text = computed(() => props.label || style.value.def)
</script>

<template>
  <span
    class="inline-flex items-center gap-1.5 rounded-pill px-3 py-1 text-xs font-semibold"
    :class="[style.bg, style.text]"
  >
    <span class="size-1.5 rounded-full" :class="style.dot" />
    {{ text }}
  </span>
</template>
