<script setup>
import { Link } from '@inertiajs/vue3'
import BaseChip from '@/components/base/BaseChip.vue'
import BaseBadge from '@/components/base/BaseBadge.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

// item: { slug, naslov, vrsta:{label,icon}, izdavac, lokacija, rok, isteklo }
defineProps({
  item: { type: Object, required: true },
})
</script>

<template>
  <Link
    :href="`/oglasi/${item.slug}`"
    class="group flex flex-col gap-2.5 rounded-md border border-border bg-surface p-4 shadow-[var(--shadow-sm)] transition-shadow hover:shadow-[var(--shadow-md)]"
    :class="item.isteklo ? 'opacity-70' : ''"
  >
    <div class="flex items-center justify-between gap-2">
      <BaseChip variant="kategorija" :label="item.vrsta.label" :icon="item.vrsta.icon" />
      <BaseBadge v-if="item.isteklo" variant="isteklo" />
    </div>
    <h3 class="line-clamp-2 text-[17px] font-semibold leading-snug text-heading">
      {{ item.naslov }}
    </h3>
    <div class="flex flex-col gap-1.5 text-[13px] text-text-muted">
      <div class="flex items-center gap-1.5">
        <BaseIcon name="building-2" :size="15" />
        <span>{{ item.izdavac }}</span>
      </div>
      <div class="flex items-center gap-1.5">
        <BaseIcon name="map-pin" :size="15" />
        <span>{{ item.lokacija }}</span>
      </div>
      <div class="flex items-center gap-1.5">
        <BaseIcon name="calendar" :size="15" />
        <span>Rok: {{ item.rok }}</span>
      </div>
    </div>
  </Link>
</template>
