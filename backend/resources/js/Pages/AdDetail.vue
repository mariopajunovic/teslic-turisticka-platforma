<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

import AppContainer from '@/components/layout/AppContainer.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import DetailHero from '@/components/common/DetailHero.vue'
import InfoPanel from '@/components/common/InfoPanel.vue'
import RelatedContent from '@/components/common/RelatedContent.vue'
import LinkCard from '@/components/cards/LinkCard.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import AdCard from '@/components/cards/AdCard.vue'

const props = defineProps({
  slug: { type: String, default: '' },
  povezani: { type: Array, default: () => [] },
  oglas: { type: Object, default: null },
  slicni: { type: Array, default: () => [] },
})

const { t } = useI18n()

const oglas = computed(() => props.oglas)
const slicni = computed(() => props.slicni)

const heroMeta = computed(() => {
  if (!oglas.value) return []
  const o = oglas.value
  const m = []
  if (o.izdavac) m.push({ icon: 'building-2', text: o.izdavac })
  if (o.lokacija) m.push({ icon: 'map-pin', text: o.lokacija })
  if (o.rok) m.push({ icon: 'calendar', text: `${t('detail.deadline')}: ${o.rok}` })
  return m
})

const infoItems = computed(() => {
  if (!oglas.value) return []
  const k = oglas.value.kontakt || {}
  const items = []
  if (k.osoba) items.push({ icon: 'user', label: t('adDetail.contactPerson'), value: k.osoba })
  if (k.telefon)
    items.push({
      icon: 'phone',
      label: t('detail.phone'),
      value: k.telefon,
      href: `tel:${k.telefon.replace(/[^0-9+]/g, '')}`,
    })
  if (k.email)
    items.push({ icon: 'mail', label: t('detail.email'), value: k.email, href: `mailto:${k.email}` })
  return items
})
</script>

<template>
  <AppContainer as="main" class="py-8">
    <EmptyState
      v-if="!oglas"
      :title="$t('adDetail.notFoundTitle')"
      :text="$t('adDetail.notFoundText')"
    >
      <BaseButton variant="secondary" icon="arrow-left" to="/oglasi">
        {{ $t('adDetail.backToAds') }}
      </BaseButton>
    </EmptyState>

    <template v-else>
      <Breadcrumb
        :items="[
          { label: $t('common.home'), to: '/' },
          { label: $t('adDetail.breadcrumb'), to: '/oglasi' },
          { label: oglas.naslov },
        ]"
      />

      <DetailHero
        :kategorija="oglas.vrsta"
        :naslov="oglas.naslov"
        :meta="heroMeta"
      >
        <template #badges>
          <span v-if="oglas.isteklo" class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1 text-[13px] font-semibold text-white ring-1 ring-inset ring-white/15">
            <span class="size-2 rounded-full bg-red-400"></span>
            {{ $t('badge.isteklo') }}
          </span>
        </template>
      </DetailHero>

      <div class="mt-8 grid gap-10 lg:grid-cols-3">
        <div class="lg:col-span-2">
          <h2 class="mb-3 font-heading text-2xl font-bold text-heading">{{ $t('adDetail.description') }}</h2>
          <div class="rtf" v-html="oglas.opisDug" />
        </div>

        <div class="space-y-4 lg:sticky lg:top-6 lg:self-start">
          <InfoPanel v-if="infoItems.length" :title="$t('adDetail.details')" :items="infoItems" />
        </div>
      </div>

      <RelatedContent v-if="povezani.length" :title="$t('detail.related')">
        <LinkCard v-for="p in povezani" :key="p.to" :item="p" />
      </RelatedContent>

      <RelatedContent v-if="slicni.length" :title="$t('adDetail.similar')">
        <AdCard v-for="o in slicni" :key="o.slug" :item="o" />
      </RelatedContent>
    </template>
  </AppContainer>
</template>
