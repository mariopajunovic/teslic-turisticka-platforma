<script setup>
import AppContainer from '@/components/layout/AppContainer.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

defineProps({
  variant: {
    type: String,
    default: 'slika-pozadina',
    validator: (v) => ['slika-pozadina', 'split'].includes(v),
  },
  title: { type: String, default: '' },
  subtitle: { type: String, default: '' },
  image: { type: String, default: '' },
  kicker: { type: String, default: '' },
  kickerClass: { type: String, default: '' },
})
</script>

<template>
  <!-- Varijanta: slika-panel (kontejnirano, kao Početna — ne full-bleed) -->
  <section v-if="variant === 'slika-pozadina'" class="bg-surface pt-8 md:pt-12">
    <AppContainer>
      <div
        class="relative min-h-[420px] overflow-hidden rounded-2xl"
        :class="!image ? 'bg-gradient-to-br from-primary to-primary-dark' : 'bg-primary-darker'"
      >
        <img
          v-if="image"
          :src="image"
          :alt="title"
          class="absolute inset-0 size-full object-cover"
        />
        <div class="absolute inset-0 bg-overlay" />
        <div class="relative max-w-[620px] px-8 py-16 md:px-14 md:py-24">
          <p
            v-if="kicker"
            class="mb-3 text-sm font-semibold uppercase tracking-wider"
            :class="kickerClass || 'text-secondary'"
          >
            {{ kicker }}
          </p>
          <h1 class="font-heading text-4xl font-bold text-white md:text-5xl">{{ title }}</h1>
          <p v-if="subtitle" class="mt-4 text-lg text-primary-tint">{{ subtitle }}</p>
          <div v-if="$slots.default" class="mt-8 flex flex-wrap gap-3"><slot /></div>
        </div>
      </div>
    </AppContainer>
  </section>

  <!-- Varijanta: split (tekst lijevo, slika desno) -->
  <section v-else class="bg-surface-alt">
    <AppContainer>
      <div class="grid items-center gap-8 py-12 md:grid-cols-2 md:gap-12 md:py-16">
        <div>
          <p
            v-if="kicker"
            class="mb-3 text-sm font-semibold uppercase tracking-wider"
            :class="kickerClass || 'text-accent-deep'"
          >
            {{ kicker }}
          </p>
          <h1 class="font-heading text-4xl font-bold text-heading md:text-5xl">{{ title }}</h1>
          <p v-if="subtitle" class="mt-4 text-lg text-text-muted">{{ subtitle }}</p>
          <div v-if="$slots.default" class="mt-8 flex flex-wrap gap-3"><slot /></div>
        </div>
        <div
          class="relative aspect-[4/3] overflow-hidden rounded-lg bg-primary-tint shadow-[var(--shadow-md)]"
        >
          <img
            v-if="image"
            :src="image"
            :alt="title"
            class="absolute inset-0 size-full object-cover"
          />
          <span
            v-else
            class="absolute inset-0 flex items-center justify-center text-primary"
          >
            <BaseIcon name="image" :size="48" />
          </span>
        </div>
      </div>
    </AppContainer>
  </section>
</template>
