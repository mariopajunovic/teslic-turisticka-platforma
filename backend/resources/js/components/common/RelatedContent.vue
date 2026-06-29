<script setup>
import { Link } from '@inertiajs/vue3'
import CardGrid from '@/components/layout/CardGrid.vue'

defineProps({
  title: { type: String, default: 'Povezano' },
  kicker: { type: String, default: '' },
  cols: { type: Number, default: 3 },
  backTo: { type: String, default: '' },
  backLabel: { type: String, default: '' },
})
</script>

<template>
  <section class="mt-12">
    <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
      <div>
        <p
          v-if="kicker"
          class="mb-1.5 text-sm font-semibold uppercase tracking-wider text-accent-deep"
        >
          {{ kicker }}
        </p>
        <h2 class="font-heading text-2xl font-bold text-heading">{{ title }}</h2>
      </div>
      <Link
        v-if="backTo"
        :href="backTo"
        class="font-heading text-sm font-bold text-primary hover:text-primary-dark"
      >
        {{ backLabel || '← Nazad na Početnu' }}
      </Link>
    </div>
    <CardGrid :cols="cols">
      <slot />
    </CardGrid>
  </section>
</template>
