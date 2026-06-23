<script setup>
import { RouterLink } from 'vue-router'
import BaseIcon from '@/components/base/BaseIcon.vue'

// items: [{ icon, label, value, href? }]
// href: string ('/...' → RouterLink, 'http…'/'tel:'/'mailto:' → <a>)
defineProps({
  title: { type: String, default: '' },
  items: { type: Array, default: () => [] },
})

const isInternal = (href) => typeof href === 'string' && href.startsWith('/')
</script>

<template>
  <aside class="rounded-md border border-border bg-surface p-5 shadow-[var(--shadow-sm)] md:p-6">
    <h2 v-if="title" class="mb-4 font-heading text-lg font-semibold text-heading">{{ title }}</h2>

    <ul class="flex flex-col gap-4">
      <li v-for="(item, i) in items" :key="i" class="flex items-start gap-3">
        <span class="mt-0.5 shrink-0 text-primary">
          <BaseIcon :name="item.icon" :size="20" />
        </span>
        <div class="min-w-0">
          <p class="text-xs uppercase tracking-wide text-text-muted">{{ item.label }}</p>
          <RouterLink
            v-if="item.href && isInternal(item.href)"
            :to="item.href"
            class="break-words font-medium text-primary hover:underline"
          >
            {{ item.value }}
          </RouterLink>
          <a
            v-else-if="item.href"
            :href="item.href"
            class="break-words font-medium text-primary hover:underline"
          >
            {{ item.value }}
          </a>
          <p v-else class="break-words text-text">{{ item.value }}</p>
        </div>
      </li>
    </ul>

    <div v-if="$slots.default" class="mt-5 border-t border-border pt-5">
      <slot />
    </div>
  </aside>
</template>
