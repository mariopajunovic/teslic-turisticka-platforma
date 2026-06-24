<script setup>
const model = defineModel({ type: Boolean, default: false })
defineProps({
  label: { type: String, default: '' },
})
</script>

<template>
  <button
    type="button"
    role="switch"
    :aria-checked="model"
    :aria-label="label || undefined"
    class="relative h-6 w-11 shrink-0 rounded-full transition-colors"
    :class="model ? 'bg-primary' : 'bg-border'"
    @click="model = !model"
  >
    <span
      class="absolute top-0.5 size-[18px] rounded-full bg-white shadow-[var(--shadow-sm)] transition-all"
      :class="model ? 'left-[23px]' : 'left-0.5'"
    />
  </button>
</template>
