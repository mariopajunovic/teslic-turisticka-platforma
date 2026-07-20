<script setup>
import BaseIcon from '@/components/base/BaseIcon.vue'

defineProps({
  kategorija: { type: Object, default: null },
  naslov: { type: String, default: '' },
  opis: { type: String, default: '' },
  logo: { type: String, default: '' },
  meta: { type: Array, default: () => [] },
})
</script>

<template>
  <header class="mt-8 overflow-hidden rounded-2xl bg-primary-darker text-primary-tint">
    <div class="relative flex flex-col gap-6 p-6 md:flex-row md:items-start md:justify-between md:gap-9 md:p-9">
      <div class="pointer-events-none absolute -right-20 -top-24 hidden size-72 rounded-full bg-primary/40 blur-3xl md:block"></div>
      <div class="pointer-events-none absolute -bottom-24 right-24 hidden size-56 rounded-full bg-secondary/20 blur-3xl md:block"></div>

      <div class="relative flex min-w-0 flex-1 items-start gap-4 md:gap-5">
        <div v-if="logo" class="shrink-0">
          <div class="flex size-16 items-center justify-center overflow-hidden rounded-2xl bg-white p-2 shadow-[var(--shadow-lg)] ring-1 ring-black/5 sm:size-20 md:size-28 md:p-2.5">
            <img :src="logo" :alt="naslov" class="max-h-full max-w-full object-contain" />
          </div>
        </div>

        <div class="min-w-0">
          <div class="flex flex-wrap items-center gap-2">
            <span v-if="kategorija" class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1 text-[13px] font-semibold text-white ring-1 ring-inset ring-white/15">
              <BaseIcon v-if="kategorija.icon" :name="kategorija.icon" :size="14" />
              {{ kategorija.label }}
            </span>
            <slot name="badges" />
          </div>

          <h1 class="mt-3 font-heading text-2xl font-extrabold leading-tight text-white sm:text-3xl md:text-[2.6rem]">
            {{ naslov }}
          </h1>

          <p v-if="opis" class="mt-3 max-w-2xl text-[15px] leading-relaxed text-primary-tint/80">
            {{ opis }}
          </p>
        </div>
      </div>

      <div
        v-if="meta.length"
        class="relative flex shrink-0 flex-col gap-2 text-[15px] md:gap-2.5 md:items-end md:text-right"
      >
        <span v-for="(m, i) in meta" :key="i" class="flex items-center gap-1.5 text-primary-tint/90">
          <BaseIcon :name="m.icon" :size="16" class="text-secondary" />
          {{ m.text }}
        </span>
      </div>
    </div>
  </header>
</template>
