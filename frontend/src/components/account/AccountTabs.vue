<script setup>
// Pill-tabovi naloga (mobilni). tabs: [{ value, label }]
const model = defineModel({ type: String, default: '' })
defineProps({
  tabs: { type: Array, required: true },
})
</script>

<template>
  <div class="flex gap-2 overflow-x-auto rounded-md border border-border bg-surface px-4 py-3">
    <button
      v-for="t in tabs"
      :key="t.value"
      type="button"
      class="shrink-0 rounded-pill px-3.5 py-2 text-[13px] font-medium transition-colors"
      :class="model === t.value ? 'bg-primary text-white' : 'bg-surface-alt text-text-muted'"
      @click="model = t.value"
    >
      {{ t.label }}
    </button>
  </div>
</template>
