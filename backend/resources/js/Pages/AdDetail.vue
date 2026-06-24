<script setup>
import { computed } from 'vue'

import AppContainer from '@/components/layout/AppContainer.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import InfoPanel from '@/components/common/InfoPanel.vue'
import RelatedContent from '@/components/common/RelatedContent.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseChip from '@/components/base/BaseChip.vue'
import BaseBadge from '@/components/base/BaseBadge.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import AdCard from '@/components/cards/AdCard.vue'

const props = defineProps({
  slug: { type: String, default: '' },
  oglas: { type: Object, default: null },
  slicni: { type: Array, default: () => [] },
})

const oglas = computed(() => props.oglas)
const loading = false
const error = null
const slicni = computed(() => props.slicni)

const infoItems = computed(() => {
  if (!oglas.value) return []
  const o = oglas.value
  const k = o.kontakt || {}
  const items = []
  if (o.izdavac) items.push({ icon: 'building-2', label: 'Izdavač', value: o.izdavac })
  if (o.lokacija) items.push({ icon: 'map-pin', label: 'Lokacija', value: o.lokacija })
  if (o.rok) items.push({ icon: 'calendar', label: 'Rok', value: o.rok })
  if (k.osoba) items.push({ icon: 'user', label: 'Kontakt osoba', value: k.osoba })
  if (k.telefon)
    items.push({
      icon: 'phone',
      label: 'Telefon',
      value: k.telefon,
      href: `tel:${k.telefon.replace(/[^0-9+]/g, '')}`,
    })
  if (k.email)
    items.push({ icon: 'mail', label: 'E-mail', value: k.email, href: `mailto:${k.email}` })
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
      <div class="mt-6 h-8 w-2/3 animate-pulse rounded bg-neutral-tint" />
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
      v-else-if="!oglas"
      title="Oglas nije pronađen"
      text="Traženi oglas ne postoji ili je uklonjen."
    >
      <BaseButton variant="secondary" icon="arrow-left" to="/oglasi">
        Nazad na oglase
      </BaseButton>
    </EmptyState>

    <template v-else>
      <Breadcrumb
        :items="[
          { label: 'Početna', to: '/' },
          { label: 'Poslovne prilike i oglasi', to: '/oglasi' },
          { label: oglas.naslov },
        ]"
      />

      <div :class="oglas.isteklo ? 'opacity-70' : ''">
        <header class="mt-6">
          <div class="flex flex-wrap items-center gap-3">
            <BaseChip
              v-if="oglas.vrsta"
              variant="kategorija"
              :label="oglas.vrsta.label"
              :icon="oglas.vrsta.icon"
            />
            <BaseBadge v-if="oglas.isteklo" variant="isteklo" />
          </div>
          <h1 class="mt-3 font-heading text-3xl font-bold text-heading md:text-4xl">
            {{ oglas.naslov }}
          </h1>
        </header>

        <div class="mt-8 grid gap-8 lg:grid-cols-3">
          <div class="lg:col-span-2">
            <h2 class="mb-3 font-heading text-2xl font-bold text-heading">Opis oglasa</h2>
            <p class="whitespace-pre-line leading-relaxed text-text">{{ oglas.opisDug }}</p>
          </div>

          <div>
            <InfoPanel title="Detalji" :items="infoItems" />
          </div>
        </div>
      </div>

      <RelatedContent v-if="slicni.length" title="Slični oglasi">
        <AdCard v-for="o in slicni" :key="o.slug" :item="o" />
      </RelatedContent>
    </template>
  </AppContainer>
</template>
