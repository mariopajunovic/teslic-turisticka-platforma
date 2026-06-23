<script setup>
// 1:1 prema 12_Prijava.pen → „Registracija – Preusmjeravanje" (izbor tipa naloga).
import AppContainer from '@/components/layout/AppContainer.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const opcije = [
  {
    icon: 'store',
    naslov: 'Registruj biznis',
    opis: 'Predstavite svoju ponudu, proizvode ili usluge posjetiocima Teslića.',
    cta: 'Registruj biznis',
    to: '/pridruzi-se/biznis',
  },
  {
    icon: 'pen-tool',
    naslov: 'Postani autor',
    opis: 'Pišite priče i objavljujte sadržaj o turizmu i životu u Tesliću.',
    cta: 'Postani autor',
    to: '/pridruzi-se/autor',
  },
]
</script>

<template>
  <section class="bg-surface-alt">
    <AppContainer class="flex min-h-[600px] flex-col items-center justify-center gap-8 py-16">
      <div class="max-w-[680px] space-y-2.5 text-center">
        <h1 class="font-heading text-3xl font-bold text-heading md:text-[32px]">Napravi nalog</h1>
        <p class="text-base text-text-muted">Odaberite tip naloga koji želite kreirati na platformi.</p>
      </div>

      <div class="flex flex-col gap-6 sm:flex-row">
        <div
          v-for="o in opcije"
          :key="o.naslov"
          class="flex w-full flex-col gap-4 rounded-2xl border border-border bg-surface p-7 sm:w-80"
        >
          <span class="flex size-14 items-center justify-center rounded-md bg-primary-tint text-primary">
            <BaseIcon :name="o.icon" :size="26" />
          </span>
          <h2 class="font-heading text-xl font-bold text-heading">{{ o.naslov }}</h2>
          <p class="text-sm leading-relaxed text-text-muted">{{ o.opis }}</p>
          <BaseButton :to="o.to" variant="primary" block>{{ o.cta }}</BaseButton>
        </div>
      </div>

      <div class="flex items-center gap-2 rounded-md bg-info-tint px-4 py-3">
        <BaseIcon name="info" :size="18" class="text-info" />
        <span class="text-sm text-text">Nakon prijave, nalog ide na pregled administratora.</span>
      </div>
    </AppContainer>
  </section>
</template>
