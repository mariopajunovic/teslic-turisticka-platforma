<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

import AppContainer from '@/components/layout/AppContainer.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import Hero from '@/components/common/Hero.vue'
import Gallery from '@/components/common/Gallery.vue'
import InfoPanel from '@/components/common/InfoPanel.vue'
import MiniMap from '@/components/common/MiniMap.vue'
import RelatedContent from '@/components/common/RelatedContent.vue'
import LinkCard from '@/components/cards/LinkCard.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import LocationCard from '@/components/cards/LocationCard.vue'

const props = defineProps({
  slug: { type: String, default: '' },
  povezani: { type: Array, default: () => [] },
  lokalitet: { type: Object, default: null },
  slicni: { type: Array, default: () => [] },
})

const { t } = useI18n()

const lokalitet = computed(() => props.lokalitet)
const loading = false
const error = null
const slicni = computed(() => props.slicni)

const infoItems = computed(() => {
  if (!lokalitet.value) return []
  const l = lokalitet.value
  const items = []
  if (l.kategorija?.label)
    items.push({ icon: l.kategorija.icon || 'tag', label: t('detail.type'), value: l.kategorija.label })
  if (l.sezona) items.push({ icon: 'calendar', label: t('detail.season'), value: l.sezona })
  if (l.radnoVrijeme)
    items.push({ icon: 'clock', label: t('detail.hours'), value: l.radnoVrijeme })
  if (l.ulaznice) items.push({ icon: 'ticket', label: t('detail.tickets'), value: l.ulaznice })
  if (l.lokacija) items.push({ icon: 'map-pin', label: t('detail.location'), value: l.lokacija })
  return items
})
</script>

<template>
  <AppContainer as="main" class="py-8">
    <BaseAlert
      v-if="error"
      variant="greska"
      :title="$t('detail.loadErrorTitle')"
      :text="$t('detail.loadErrorText')"
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
      :title="$t('loc.notFoundTitle')"
      :text="$t('loc.notFoundText')"
    >
      <BaseButton variant="secondary" icon="arrow-left" to="/turizam">
        {{ $t('loc.backToTourism') }}
      </BaseButton>
    </EmptyState>

    <template v-else>
      <Breadcrumb
        :items="[
          { label: $t('common.home'), to: '/' },
          { label: $t('tourism.breadcrumb'), to: '/turizam' },
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
        <h2 class="mb-4 font-heading text-2xl font-bold text-heading">{{ $t('detail.gallery') }}</h2>
        <Gallery :items="lokalitet.galerija" />
      </section>

      <div class="mt-10 grid gap-8 lg:grid-cols-3">
        <div class="space-y-8 lg:col-span-2">
          <section v-if="lokalitet.opisDug">
            <h2 class="mb-3 font-heading text-2xl font-bold text-heading">{{ $t('loc.about') }}</h2>
            <p class="whitespace-pre-line leading-relaxed text-text">{{ lokalitet.opisDug }}</p>
          </section>
          <section v-if="lokalitet.kakoDoci">
            <h2 class="mb-3 font-heading text-2xl font-bold text-heading">{{ $t('loc.howTo') }}</h2>
            <p class="whitespace-pre-line leading-relaxed text-text">{{ lokalitet.kakoDoci }}</p>
          </section>
          <section v-if="lokalitet.savjeti">
            <h2 class="mb-3 font-heading text-2xl font-bold text-heading">{{ $t('loc.tips') }}</h2>
            <p class="whitespace-pre-line leading-relaxed text-text">{{ lokalitet.savjeti }}</p>
          </section>
        </div>

        <div class="space-y-6">
          <InfoPanel :title="$t('detail.information')" :items="infoItems" />
          <MiniMap :label="lokalitet.lokacija" />
        </div>
      </div>

      <RelatedContent v-if="povezani.length" :title="$t('detail.related')">
        <LinkCard v-for="p in povezani" :key="p.to" :item="p" />
      </RelatedContent>

      <RelatedContent v-if="slicni.length" :title="$t('loc.similar')">
        <LocationCard v-for="l in slicni" :key="l.slug" :item="l" />
      </RelatedContent>
    </template>
  </AppContainer>
</template>
