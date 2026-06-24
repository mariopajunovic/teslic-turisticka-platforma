<script setup>
// Vizuelni stub WYSIWYG editora (toolbar + polje). Pravi editor se ubacuje kasnije.
import BaseIcon from '@/components/base/BaseIcon.vue'

defineProps({
  title: { type: String, default: 'Naslov priče' },
  placeholder: {
    type: String,
    default:
      'Počnite pisati svoju priču ovdje… Dodajte podnaslove, slike, citate i povežite je s biznisom, lokacijom ili događajem iz Teslića.',
  },
})

const alati = ['bold', 'italic', 'heading', 'list', 'link', 'image', 'quote']
</script>

<template>
  <div class="overflow-hidden rounded-md border border-border bg-surface">
    <div class="flex gap-0.5 border-b border-border bg-surface-alt px-3 py-2">
      <button
        v-for="a in alati"
        :key="a"
        type="button"
        class="grid size-8 place-items-center rounded-md text-text-muted hover:bg-surface hover:text-heading"
        :aria-label="a"
      >
        <BaseIcon :name="a" :size="17" />
      </button>
    </div>
    <div class="flex flex-col gap-2.5 px-4 pb-10 pt-4">
      <p class="text-[22px] font-bold text-heading">{{ title }}</p>
      <p class="leading-relaxed text-text-muted">{{ placeholder }}</p>
    </div>
  </div>
</template>
