<script setup>
import { computed } from 'vue'

import AppContainer from '@/components/layout/AppContainer.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import Hero from '@/components/common/Hero.vue'
import Gallery from '@/components/common/Gallery.vue'
import InfoPanel from '@/components/common/InfoPanel.vue'
import MiniMap from '@/components/common/MiniMap.vue'
import RelatedContent from '@/components/common/RelatedContent.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import LocationCard from '@/components/cards/LocationCard.vue'

const props = defineProps({
  slug: { type: String, default: '' },
  lokalitet: { type: Object, default: null },
  slicni: { type: Array, default: () => [] },
})

const lokalitet = computed(() => props.lokalitet)
const loading = false
const error = null
const slicni = computed(() => props.slicni)

const infoItems = computed(() => {
  if (!lokalitet.value) return []
  const l = lokalitet.value
  const items = []
  if (l.kategorija?.label)
    items.push({ icon: l.kategorija.icon || 'tag', label: 'Tip', value: l.kategorija.label })
  if (l.sezona) items.push({ icon: 'calendar', label: 'Sezona', value: l.sezona })
  if (l.radnoVrijeme)
    items.push({ icon: 'clock', label: 'Radno vrijeme', value: l.radnoVrijeme })
  if (l.ulaznice) items.push({ icon: 'ticket', label: 'Ulaznice', value: l.ulaznice })
  if (l.lokacija) items.push({ icon: 'map-pin', label: 'Lokacija', value: l.lokacija })
  return items
})
</script>

<template>
  <AppContainer as="main" class="py-8">
    <BaseAlert
      v-if="error"
      variant="greska"
      title="Greška pri učitavanju"
      text="Nije moguće učitati podatke. Pokušajte ponovo kasnije."
    />

    <template v-else-if="loading">
      <div class="h-5 w-64 animate-pulse rounded bg-neutral-tint" />
      <div class="mt-6 h-72 animate-pulse rounded-lg bg-neutral-tint" />
      <div class="mt-6 grid gap-8 lg:grid-cols-3">
        <div class="space-y-3 lg:col-span-2">
          <div class="h-4 w-full animate-pulse rounded bg-neutral-tint" />
          <div class="h-4 w-full animate-pulse rounded bg-neutral-tint" />
          <div class="h-4 w-2/3 animate-pulse rounded bg-neutral-tint" />
        </div>
        <div class="h-64 animate-pulse rounded-md bg-neutral-tint" />
      </div>
    </template>

    <EmptyState
      v-else-if="!lokalitet"
      title="Lokalitet nije pronađen"
      text="Traženi lokalitet ne postoji ili je uklonjen."
    >
      <BaseButton variant="secondary" icon="arrow-left" to="/turizam">
        Nazad na turizam
      </BaseButton>
    </EmptyState>

    <template v-else>
      <Breadcrumb
        :items="[
          { label: 'Početna', to: '/' },
          { label: 'Turizam u Tesliću', to: '/turizam' },
          { label: lokalitet.naslov },
        ]"
      />

      <div class="mt-6 overflow-hidden rounded-lg">
        <Hero
          variant="slika-pozadina"
          :kicker="lokalitet.kategorija?.label"
          :title="lokalitet.naslov"
          :subtitle="lokalitet.opis"
          :image="lokalitet.slika"
        />
      </div>

      <section v-if="lokalitet.galerija?.length" class="mt-10">
        <h2 class="mb-4 font-heading text-2xl font-bold text-heading">Galerija</h2>
        <Gallery :items="lokalitet.galerija" />
      </section>

      <div class="mt-10 grid gap-8 lg:grid-cols-3">
        <div class="space-y-8 lg:col-span-2">
          <section v-if="lokalitet.opisDug">
            <h2 class="mb-3 font-heading text-2xl font-bold text-heading">O lokaciji</h2>
            <p class="whitespace-pre-line leading-relaxed text-text">{{ lokalitet.opisDug }}</p>
          </section>
          <section v-if="lokalitet.kakoDoci">
            <h2 class="mb-3 font-heading text-2xl font-bold text-heading">Kako doći</h2>
            <p class="whitespace-pre-line leading-relaxed text-text">{{ lokalitet.kakoDoci }}</p>
          </section>
          <section v-if="lokalitet.savjeti">
            <h2 class="mb-3 font-heading text-2xl font-bold text-heading">Savjeti</h2>
            <p class="whitespace-pre-line leading-relaxed text-text">{{ lokalitet.savjeti }}</p>
          </section>
        </div>

        <div class="space-y-6">
          <InfoPanel title="Informacije" :items="infoItems" />
          <MiniMap :label="lokalitet.lokacija" />
        </div>
      </div>

      <RelatedContent v-if="slicni.length" title="Slični lokaliteti">
        <LocationCard v-for="l in slicni" :key="l.slug" :item="l" />
      </RelatedContent>
    </template>
  </AppContainer>
</template>
