<script setup>
import { RouterLink } from 'vue-router'
import BaseChip from '@/components/base/BaseChip.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

// item: { slug, naslov, kategorija:{label,icon}, autor, datum, izvod, slika }
defineProps({
  item: { type: Object, required: true },
})
</script>

<template>
  <RouterLink
    :to="`/price/${item.slug}`"
    class="group grid overflow-hidden rounded-md border border-border bg-surface shadow-[var(--shadow-md)] transition-shadow hover:shadow-[var(--shadow-lg)] sm:grid-cols-[280px_1fr]"
  >
    <div class="relative aspect-[16/10] overflow-hidden bg-primary-tint sm:aspect-auto sm:min-h-56">
      <img
        v-if="item.slika"
        :src="item.slika"
        :alt="item.naslov"
        loading="lazy"
        class="size-full object-cover transition-transform duration-300 group-hover:scale-105"
      />
      <div v-else class="flex size-full items-center justify-center text-primary-tint-2">
        <BaseIcon name="image" :size="44" />
      </div>
    </div>
    <div class="flex flex-col justify-center gap-3 p-6">
      <div>
        <BaseChip variant="kategorija" :label="item.kategorija.label" :icon="item.kategorija.icon" />
      </div>
      <h3 class="text-2xl font-bold leading-tight text-heading">{{ item.naslov }}</h3>
      <div class="flex items-center gap-2">
        <span class="flex size-6 items-center justify-center rounded-full bg-primary-tint-2 text-primary">
          <BaseIcon name="user" :size="14" />
        </span>
        <span class="text-[13px] text-text-muted">{{ item.autor }} · {{ item.datum }}</span>
      </div>
      <p class="text-text">{{ item.izvod }}</p>
    </div>
  </RouterLink>
</template>
