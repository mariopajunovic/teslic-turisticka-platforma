<script setup>
import { computed, ref } from 'vue'

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
import BusinessCard from '@/components/cards/BusinessCard.vue'

const props = defineProps({
  slug: { type: String, default: '' },
  biznis: { type: Object, default: null },
  slicni: { type: Array, default: () => [] },
})

const biznis = computed(() => props.biznis)
const loading = false
const error = null
const slicni = computed(() => props.slicni)

const infoItems = computed(() => {
  if (!biznis.value) return []
  const k = biznis.value.kontakt || {}
  const items = []
  if (k.telefon)
    items.push({
      icon: 'phone',
      label: 'Telefon',
      value: k.telefon,
      href: `tel:${k.telefon.replace(/[^0-9+]/g, '')}`,
    })
  if (k.email)
    items.push({ icon: 'mail', label: 'E-mail', value: k.email, href: `mailto:${k.email}` })
  if (k.web)
    items.push({
      icon: 'globe',
      label: 'Web',
      value: k.web,
      href: k.web.startsWith('http') ? k.web : `https://${k.web}`,
    })
  if (k.radnoVrijeme)
    items.push({ icon: 'clock', label: 'Radno vrijeme', value: k.radnoVrijeme })
  if (k.adresa) items.push({ icon: 'map-pin', label: 'Adresa', value: k.adresa })
  return items
})

const upitPoslan = ref(false)
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
      v-else-if="!biznis"
      title="Biznis nije pronađen"
      text="Traženi biznis ne postoji ili je uklonjen."
    >
      <BaseButton variant="secondary" icon="arrow-left" to="/domace-je-najbolje">
        Nazad na ponudu
      </BaseButton>
    </EmptyState>

    <template v-else>
      <Breadcrumb
        :items="[
          { label: 'Početna', to: '/' },
          { label: 'Domaće je najbolje', to: '/domace-je-najbolje' },
          { label: biznis.naslov },
        ]"
      />

      <div class="mt-6 overflow-hidden rounded-lg">
        <Hero
          variant="slika-pozadina"
          :kicker="biznis.kategorija?.label"
          :title="biznis.naslov"
          :subtitle="biznis.opis"
          :image="biznis.slika"
        />
      </div>

      <section v-if="biznis.galerija?.length" class="mt-10">
        <h2 class="mb-4 font-heading text-2xl font-bold text-heading">Galerija</h2>
        <Gallery :items="biznis.galerija" />
      </section>

      <div class="mt-10 grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2">
          <h2 class="mb-4 font-heading text-2xl font-bold text-heading">O ponudi</h2>
          <p class="whitespace-pre-line leading-relaxed text-text">{{ biznis.opisDug }}</p>
        </div>

        <div class="space-y-6">
          <InfoPanel title="Kontakt" :items="infoItems">
            <BaseButton variant="primary" icon="send" block @click="upitPoslan = true">
              Pošalji upit
            </BaseButton>
            <BaseAlert
              v-if="upitPoslan"
              variant="info"
              class="mt-4"
              text="Kontaktirajte ponuđača direktno putem navedenih podataka."
            />
          </InfoPanel>
          <MiniMap :label="biznis.lokacija" />
        </div>
      </div>

      <RelatedContent v-if="slicni.length" title="Slično">
        <BusinessCard v-for="b in slicni" :key="b.slug" :item="b" />
      </RelatedContent>
    </template>
  </AppContainer>
</template>
