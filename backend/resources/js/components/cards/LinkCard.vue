<script setup>
import { Link } from '@inertiajs/vue3'
import CardImage from '@/components/cards/CardImage.vue'

defineProps({
  item: { type: Object, required: true },
})
</script>

<template>
  <Link
    :href="item.to"
    class="group block overflow-hidden rounded-md border border-border bg-surface transition-shadow hover:shadow-[var(--shadow-md)]"
  >
    <CardImage :src="item.slika" :alt="item.naslov" />
    <div class="space-y-2 p-4">
      <span class="inline-block rounded-pill bg-primary-tint px-2.5 py-1 text-xs font-semibold text-primary">
        {{ item.tip }}
      </span>
      <h3 class="font-semibold leading-tight text-heading group-hover:text-primary">{{ item.naslov }}</h3>
    </div>
  </Link>
</template>
