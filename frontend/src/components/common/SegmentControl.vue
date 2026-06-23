<script setup>
import BaseIcon from '@/components/base/BaseIcon.vue'

const model = defineModel()

defineProps({
  // options: niz { value, label, icon? }
  options: { type: Array, default: () => [] },
})
</script>

<template>
  <div class="inline-flex rounded-sm bg-surface-alt p-1" role="tablist">
    <button
      v-for="opt in options"
      :key="opt.value"
      type="button"
      role="tab"
      :aria-selected="model === opt.value"
      class="inline-flex h-9 items-center justify-center gap-1.5 rounded-sm px-4 text-sm font-semibold transition-colors"
      :class="
        model === opt.value
          ? 'bg-primary text-white shadow-[var(--shadow-sm)]'
          : 'text-text hover:text-primary'
      "
      @click="model = opt.value"
    >
      <BaseIcon v-if="opt.icon" :name="opt.icon" :size="16" />
      <span>{{ opt.label }}</span>
    </button>
  </div>
</template>
