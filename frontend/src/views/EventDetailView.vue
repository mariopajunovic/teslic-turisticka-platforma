<script setup>
import { computed, ref } from 'vue'
import { useRoute } from 'vue-router'
import { useFetch } from '@/composables/useFetch'
import { api } from '@/services/api'

import AppContainer from '@/components/layout/AppContainer.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import Hero from '@/components/common/Hero.vue'
import Gallery from '@/components/common/Gallery.vue'
import InfoPanel from '@/components/common/InfoPanel.vue'
import MiniMap from '@/components/common/MiniMap.vue'
import RelatedContent from '@/components/common/RelatedContent.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseBadge from '@/components/base/BaseBadge.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import EventCard from '@/components/cards/EventCard.vue'

const route = useRoute()
const { data: dogadjaj, loading, error } = useFetch(() =>
  api.get('dogadjaji', route.params.slug),
)
const { data: sviDogadjaji } = useFetch(() => api.list('dogadjaji'))

const slicni = computed(() => {
  if (!dogadjaj.value || !sviDogadjaji.value) return []
  return sviDogadjaji.value
    .filter((d) => d.slug !== dogadjaj.value.slug)
    .slice(0, 3)
})

const infoItems = computed(() => {
  if (!dogadjaj.value) return []
  const d = dogadjaj.value
  const items = []
  if (d.datum) items.push({ icon: 'calendar', label: 'Datum', value: d.datum })
  if (d.vrijeme) items.push({ icon: 'clock', label: 'Vrijeme', value: d.vrijeme })
  if (d.lokacija) items.push({ icon: 'map-pin', label: 'Lokacija', value: d.lokacija })
  if (d.organizator)
    items.push({ icon: 'user', label: 'Organizator', value: d.organizator })
  return items
})

const dodatUKalendar = ref(false)
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
      v-else-if="!dogadjaj"
      title="Događaj nije pronađen"
      text="Traženi događaj ne postoji ili je uklonjen."
    >
      <BaseButton variant="secondary" icon="arrow-left" to="/dogadjaji">
        Nazad na događaje
      </BaseButton>
    </EmptyState>

    <template v-else>
      <Breadcrumb
        :items="[
          { label: 'Početna', to: '/' },
          { label: 'Događaji', to: '/dogadjaji' },
          { label: dogadjaj.naslov },
        ]"
      />

      <div class="mt-6 overflow-hidden rounded-lg">
        <Hero
          variant="slika-pozadina"
          :kicker="dogadjaj.datum"
          :title="dogadjaj.naslov"
          :subtitle="dogadjaj.vrijeme ? `${dogadjaj.vrijeme} · ${dogadjaj.lokacija}` : dogadjaj.lokacija"
          :image="dogadjaj.slika"
        />
      </div>

      <div v-if="dogadjaj.zavrseno" class="mt-6">
        <BaseBadge variant="zavrseno" />
      </div>

      <div class="mt-10 grid gap-8 lg:grid-cols-3">
        <div class="space-y-8 lg:col-span-2">
          <section v-if="dogadjaj.opisDug">
            <h2 class="mb-3 font-heading text-2xl font-bold text-heading">O događaju</h2>
            <p class="whitespace-pre-line leading-relaxed text-text">{{ dogadjaj.opisDug }}</p>
          </section>
          <section v-if="dogadjaj.galerija?.length">
            <h2 class="mb-4 font-heading text-2xl font-bold text-heading">Galerija</h2>
            <Gallery :items="dogadjaj.galerija" />
          </section>
        </div>

        <div class="space-y-6">
          <InfoPanel title="Informacije" :items="infoItems">
            <BaseButton
              variant="primary"
              icon="calendar-plus"
              block
              :disabled="dogadjaj.zavrseno"
              @click="dodatUKalendar = true"
            >
              Dodaj u kalendar
            </BaseButton>
            <BaseAlert
              v-if="dodatUKalendar"
              variant="uspjeh"
              class="mt-4"
              text="Termin događaja je zabilježen."
            />
          </InfoPanel>
          <MiniMap :label="dogadjaj.lokacija" />
        </div>
      </div>

      <RelatedContent v-if="slicni.length" title="Drugi događaji">
        <EventCard v-for="d in slicni" :key="d.slug" :item="d" />
      </RelatedContent>
    </template>
  </AppContainer>
</template>
