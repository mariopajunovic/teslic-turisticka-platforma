<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import BaseIcon from '@/components/base/BaseIcon.vue'

defineProps({
  heading: { type: String, default: 'MOJ NALOG' },
  items: { type: Array, required: true },
})

const page = usePage()
</script>

<template>
  <nav class="w-60 shrink-0 rounded-md border border-border bg-surface p-3">
    <p class="px-3 pb-2 pt-1 text-xs font-bold uppercase tracking-wider text-text-muted">
      {{ heading }}
    </p>
    <Link
      v-for="it in items"
      :key="it.to"
      :href="it.to"
      class="flex items-center gap-3 rounded-md px-3 py-2.5 text-[15px] transition-colors"
      :class="
        page.url === it.to
          ? 'bg-primary-tint font-semibold text-primary'
          : 'text-text hover:bg-surface-alt'
      "
    >
      <BaseIcon :name="it.icon" :size="18" :class="page.url === it.to ? 'text-primary' : 'text-text-muted'" />
      {{ it.label }}
    </Link>
  </nav>
</template>
