<script setup>
import { RouterLink } from 'vue-router'
import BaseIcon from '@/components/base/BaseIcon.vue'

// Zaglavlje sekcije: H2 (28px) lijevo + opcioni „Vidi sve →" link desno.
defineProps({
  title: { type: String, required: true },
  linkText: { type: String, default: '' },
  to: { type: [String, Object], default: null },
})
</script>

<template>
  <div class="flex items-center justify-between gap-4">
    <h2 class="font-heading text-[22px] font-bold text-heading md:text-[28px]">{{ title }}</h2>
    <RouterLink
      v-if="linkText && to"
      :to="to"
      class="flex shrink-0 items-center gap-1 text-[15px] font-semibold text-primary hover:underline"
    >
      {{ linkText }}
      <BaseIcon name="chevron-right" :size="16" />
    </RouterLink>
  </div>
</template>
