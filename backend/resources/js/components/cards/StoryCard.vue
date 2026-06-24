<script setup>
import { Link } from '@inertiajs/vue3'
import CardImage from './CardImage.vue'
import BaseChip from '@/components/base/BaseChip.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

// item: { slug, naslov, kategorija:{label,icon}, autor, datum, izvod, slika }
defineProps({
  item: { type: Object, required: true },
})
</script>

<template>
  <Link
    :href="`/price/${item.slug}`"
    class="group flex flex-col overflow-hidden rounded-md border border-border bg-surface shadow-[var(--shadow-sm)] transition-shadow hover:shadow-[var(--shadow-md)]"
  >
    <CardImage :src="item.slika" :alt="item.naslov" />
    <div class="flex flex-col gap-2 p-4">
      <div>
        <BaseChip variant="kategorija" :label="item.kategorija.label" :icon="item.kategorija.icon" />
      </div>
      <h3 class="line-clamp-2 text-lg font-semibold leading-snug text-heading">{{ item.naslov }}</h3>
      <div class="flex items-center gap-2">
        <span class="flex size-6 items-center justify-center rounded-full bg-primary-tint-2 text-primary">
          <BaseIcon name="user" :size="14" />
        </span>
        <span class="text-[13px] text-text-muted">{{ item.autor }} · {{ item.datum }}</span>
      </div>
      <p class="line-clamp-2 text-sm text-text-muted">{{ item.izvod }}</p>
    </div>
  </Link>
</template>
