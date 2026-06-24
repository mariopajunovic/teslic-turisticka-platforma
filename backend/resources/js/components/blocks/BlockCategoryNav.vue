<script setup>
import { Link } from '@inertiajs/vue3'
import AppContainer from '@/components/layout/AppContainer.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

defineProps({
  data: { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppContainer class="mt-10">
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
      <Link
        v-for="k in data.items || []"
        :key="k.label"
        :href="k.to || '#'"
        class="flex flex-col items-center gap-3 rounded-md border border-border bg-surface px-3 py-5 text-center transition-shadow hover:shadow-[var(--shadow-md)]"
      >
        <span class="flex size-12 items-center justify-center rounded-full bg-primary-tint text-primary">
          <BaseIcon :name="k.icon || 'tag'" :size="22" />
        </span>
        <span class="text-sm font-semibold leading-tight text-heading">{{ k.label }}</span>
      </Link>
    </div>
  </AppContainer>
</template>
