<script setup>
import { computed } from 'vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const current = defineModel({ type: Number, default: 1 })
const props = defineProps({
  total: { type: Number, default: 1 }, // ukupan broj stranica
})

// Prozor stranica s elipsom (1 … c-1 c c+1 … N).
const pages = computed(() => {
  const t = props.total
  const c = current.value
  if (t <= 7) return Array.from({ length: t }, (_, i) => i + 1)
  const out = [1]
  if (c > 3) out.push('…')
  const start = Math.max(2, c - 1)
  const end = Math.min(t - 1, c + 1)
  for (let i = start; i <= end; i++) out.push(i)
  if (c < t - 2) out.push('…')
  out.push(t)
  return out
})

function go(p) {
  if (typeof p === 'number' && p >= 1 && p <= props.total) current.value = p
}
</script>

<template>
  <nav class="flex items-center gap-2" aria-label="Stranice">
    <button
      type="button"
      class="grid size-10 place-items-center rounded-sm border border-border text-text transition-colors hover:bg-surface-alt disabled:opacity-40"
      :disabled="current <= 1"
      aria-label="Prethodna stranica"
      @click="go(current - 1)"
    >
      <BaseIcon name="chevron-left" :size="18" />
    </button>

    <template v-for="(p, i) in pages" :key="i">
      <span v-if="p === '…'" class="grid size-10 place-items-center text-text-muted">…</span>
      <button
        v-else
        type="button"
        class="grid size-10 place-items-center rounded-sm border text-sm font-medium transition-colors"
        :class="
          p === current
            ? 'border-primary bg-primary text-white'
            : 'border-border text-text hover:bg-surface-alt'
        "
        :aria-current="p === current ? 'page' : undefined"
        @click="go(p)"
      >
        {{ p }}
      </button>
    </template>

    <button
      type="button"
      class="grid size-10 place-items-center rounded-sm border border-border text-text transition-colors hover:bg-surface-alt disabled:opacity-40"
      :disabled="current >= total"
      aria-label="Sljedeća stranica"
      @click="go(current + 1)"
    >
      <BaseIcon name="chevron-right" :size="18" />
    </button>
  </nav>
</template>
