<script setup>
import { RouterLink } from 'vue-router'
import CardImage from './CardImage.vue'
import BaseChip from '@/components/base/BaseChip.vue'
import BaseBadge from '@/components/base/BaseBadge.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

// item: { slug, naslov, opis, kategorija:{label,icon}, lokacija, slika, preporuceno }
defineProps({
  item: { type: Object, required: true },
  to: { type: [String, Object], default: null },
})
</script>

<template>
  <RouterLink
    :to="to || `/domace-je-najbolje/${item.slug}`"
    class="group flex flex-col overflow-hidden rounded-md border border-border bg-surface shadow-[var(--shadow-sm)] transition-shadow hover:shadow-[var(--shadow-md)]"
  >
    <CardImage :src="item.slika" :alt="item.naslov">
      <BaseBadge
        v-if="item.preporuceno"
        variant="preporuceno"
        class="absolute left-3 top-3 shadow-[var(--shadow-sm)]"
      />
    </CardImage>
    <div class="flex flex-col gap-2 p-4">
      <div>
        <BaseChip variant="kategorija" :label="item.kategorija.label" :icon="item.kategorija.icon" />
      </div>
      <h3 class="line-clamp-2 text-lg font-semibold leading-snug text-heading">{{ item.naslov }}</h3>
      <p class="line-clamp-2 text-sm text-text-muted">{{ item.opis }}</p>
      <div class="mt-auto flex items-center gap-1.5 pt-1 text-[13px] text-text-muted">
        <BaseIcon name="map-pin" :size="15" />
        <span>{{ item.lokacija }}</span>
      </div>
    </div>
  </RouterLink>
</template>
