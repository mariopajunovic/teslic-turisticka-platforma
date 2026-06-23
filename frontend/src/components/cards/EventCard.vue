<script setup>
import { RouterLink } from 'vue-router'
import CardImage from './CardImage.vue'
import BaseBadge from '@/components/base/BaseBadge.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

// item: { slug, naslov, dan, mjesec, vrijeme, lokacija, slika, zavrseno }
defineProps({
  item: { type: Object, required: true },
})
</script>

<template>
  <RouterLink
    :to="`/dogadjaji/${item.slug}`"
    class="group flex flex-col overflow-hidden rounded-md border border-border bg-surface shadow-[var(--shadow-sm)] transition-shadow hover:shadow-[var(--shadow-md)]"
    :class="item.zavrseno ? 'opacity-70' : ''"
  >
    <CardImage :src="item.slika" :alt="item.naslov">
      <div
        class="absolute left-3 top-3 flex flex-col items-center rounded-sm bg-surface px-2.5 py-1.5 shadow-[var(--shadow-md)]"
      >
        <span class="text-xl font-bold leading-none text-primary">{{ item.dan }}</span>
        <span class="mt-0.5 text-[11px] font-semibold uppercase tracking-wide text-text-muted">
          {{ item.mjesec }}
        </span>
      </div>
      <BaseBadge v-if="item.zavrseno" variant="zavrseno" class="absolute right-3 top-3" />
    </CardImage>
    <div class="flex flex-col gap-2 p-4">
      <h3 class="line-clamp-2 text-lg font-semibold leading-snug text-heading">{{ item.naslov }}</h3>
      <div class="flex items-center gap-1.5 text-[13px] text-text-muted">
        <BaseIcon name="clock" :size="15" />
        <span>{{ item.vrijeme }}</span>
      </div>
      <div class="flex items-center gap-1.5 text-[13px] text-text-muted">
        <BaseIcon name="map-pin" :size="15" />
        <span>{{ item.lokacija }}</span>
      </div>
    </div>
  </RouterLink>
</template>
