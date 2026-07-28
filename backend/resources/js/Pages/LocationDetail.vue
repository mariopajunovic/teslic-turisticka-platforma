<script setup>
import { useLocalePath } from '@/composables/useLocalePath'
const { localePath } = useLocalePath()
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

import AppContainer from '@/components/layout/AppContainer.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import DetailGallery from '@/components/common/DetailGallery.vue'
import DetailHero from '@/components/common/DetailHero.vue'
import InfoPanel from '@/components/common/InfoPanel.vue'
import MiniMap from '@/components/common/MiniMap.vue'
import RelatedContent from '@/components/common/RelatedContent.vue'
import LinkCard from '@/components/cards/LinkCard.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
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
const slicni = computed(() => props.slicni)

const heroMeta = computed(() => {
  const l = lokalitet.value
  if (!l) return []
  const m = []
  if (l.lokacija) m.push({ icon: 'map-pin', text: l.lokacija })
  if (l.sezona) m.push({ icon: 'calendar', text: l.sezona })
  return m
})

const infoItems = computed(() => {
  if (!lokalitet.value) return []
  const l = lokalitet.value
  const items = []
  if (l.kategorija?.label)
    items.push({ icon: l.kategorija.icon || 'tag', label: t('detail.type'), value: l.kategorija.label })
  if (l.radnoVrijeme) items.push({ icon: 'clock', label: t('detail.hours'), value: l.radnoVrijeme })
  if (l.ulaznice) items.push({ icon: 'ticket', label: t('detail.tickets'), value: l.ulaznice })
  return items
})
</script>

<template>
  <AppContainer as="main" class="py-8">
    <EmptyState
      v-if="!lokalitet"
      :title="$t('loc.notFoundTitle')"
      :text="$t('loc.notFoundText')"
    >
      <BaseButton variant="secondary" icon="arrow-left" :to="localePath('/turizam')">
        {{ $t('loc.backToTourism') }}
      </BaseButton>
    </EmptyState>

    <template v-else>
      <Breadcrumb
        :items="[
          { label: $t('common.home'), to: localePath('/') },
          { label: $t('tourism.breadcrumb'), to: localePath('/turizam') },
          { label: lokalitet.naslov },
        ]"
      />

      <DetailGallery
        class="mt-5"
        :slika="lokalitet.slika"
        :galerija="lokalitet.galerija"
        :naslov="lokalitet.naslov"
      />

      <DetailHero
        :kategorija="lokalitet.kategorija"
        :naslov="lokalitet.naslov"
        :opis="lokalitet.opis"
        :meta="heroMeta"
      >
        <template #badges>
          <span v-if="lokalitet.preporuceno" class="inline-flex items-center gap-1.5 rounded-full bg-secondary px-3 py-1 text-[13px] font-bold text-primary-darker">
            <BaseIcon name="star" :size="13" />
            {{ $t('badge.preporuceno') }}
          </span>
        </template>
      </DetailHero>

      <div class="mt-8 grid gap-10 lg:grid-cols-3">
        <div class="space-y-8 lg:col-span-2">
          <section v-if="lokalitet.opisDug">
            <h2 class="mb-3 font-heading text-2xl font-bold text-heading">{{ $t('loc.about') }}</h2>
            <div class="rtf" v-html="lokalitet.opisDug" />
          </section>
          <section v-if="lokalitet.kakoDoci">
            <h2 class="mb-3 font-heading text-xl font-bold text-heading">{{ $t('loc.howTo') }}</h2>
            <p class="whitespace-pre-line leading-relaxed text-text">{{ lokalitet.kakoDoci }}</p>
          </section>
          <section v-if="lokalitet.savjeti">
            <h2 class="mb-3 font-heading text-xl font-bold text-heading">{{ $t('loc.tips') }}</h2>
            <p class="whitespace-pre-line leading-relaxed text-text">{{ lokalitet.savjeti }}</p>
          </section>
        </div>

        <div class="space-y-4 lg:sticky lg:top-6 lg:self-start lg:max-h-[calc(100vh-3rem)] lg:overflow-y-auto lg:pr-1 lg:[scrollbar-width:thin]">
          <InfoPanel :title="$t('detail.information')" :items="infoItems" />
          <MiniMap
            :label="lokalitet.lokacija"
            :lat="lokalitet.lat"
            :lng="lokalitet.lng"
            :to="`/mapa?tacka=${encodeURIComponent(lokalitet.slug)}`"
          />
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
