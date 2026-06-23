<script setup>
import { RouterLink } from 'vue-router'
import BaseIcon from '@/components/base/BaseIcon.vue'

// Bočna navigacija naloga (desktop). items: [{ label, icon, to }]
defineProps({
  heading: { type: String, default: 'MOJ NALOG' },
  items: { type: Array, required: true },
})
</script>

<template>
  <nav class="w-60 shrink-0 rounded-md border border-border bg-surface p-3">
    <p class="px-3 pb-2 pt-1 text-xs font-bold uppercase tracking-wider text-text-muted">
      {{ heading }}
    </p>
    <RouterLink v-for="it in items" :key="it.to" v-slot="{ isActive, href, navigate }" :to="it.to" custom>
      <a
        :href="href"
        class="flex items-center gap-3 rounded-md px-3 py-2.5 text-[15px] transition-colors"
        :class="
          isActive
            ? 'bg-primary-tint font-semibold text-primary'
            : 'text-text hover:bg-surface-alt'
        "
        @click="navigate"
      >
        <BaseIcon :name="it.icon" :size="18" :class="isActive ? 'text-primary' : 'text-text-muted'" />
        {{ it.label }}
      </a>
    </RouterLink>
  </nav>
</template>
