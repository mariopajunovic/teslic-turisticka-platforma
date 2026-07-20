<script setup>
import { Link } from '@inertiajs/vue3'
import BaseIcon from '@/components/base/BaseIcon.vue'

defineProps({ item: { type: Object, required: true } })
</script>

<template>
  <Link
    :href="item.url"
    class="group flex flex-col overflow-hidden rounded-lg border border-border bg-surface transition-shadow hover:shadow-[var(--shadow-md)]"
  >
    <div class="aspect-[16/10] overflow-hidden bg-primary-tint">
      <img v-if="item.slika" :src="item.slika" :alt="item.naslov" class="size-full object-cover transition-transform duration-300 group-hover:scale-[1.03]" />
      <div v-else class="flex size-full items-center justify-center text-primary">
        <BaseIcon name="file-text" :size="40" />
      </div>
    </div>
    <div class="flex flex-1 flex-col p-5">
      <p v-if="item.datum" class="flex items-center gap-1.5 text-xs font-medium text-text-muted">
        <BaseIcon name="calendar" :size="14" /> {{ item.datum }}
      </p>
      <h3 class="mt-1.5 font-heading text-lg font-bold leading-snug text-heading group-hover:text-primary">{{ item.naslov }}</h3>
      <p v-if="item.izvod" class="mt-2 line-clamp-3 text-sm leading-relaxed text-text-muted">{{ item.izvod }}</p>
    </div>
  </Link>
</template>
