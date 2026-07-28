<script setup>
import { useLocalePath } from '@/composables/useLocalePath'
const { localePath } = useLocalePath()
import { computed, ref } from 'vue'
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
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import EventCard from '@/components/cards/EventCard.vue'

const props = defineProps({
  slug: { type: String, default: '' },
  povezani: { type: Array, default: () => [] },
  dogadjaj: { type: Object, default: null },
  slicni: { type: Array, default: () => [] },
})

const { t } = useI18n()

const dogadjaj = computed(() => props.dogadjaj)
const slicni = computed(() => props.slicni)

const heroMeta = computed(() => {
  if (!dogadjaj.value) return []
  const d = dogadjaj.value
  const m = []
  if (d.vrijeme) m.push({ icon: 'clock', text: d.vrijeme })
  if (d.lokacija) m.push({ icon: 'map-pin', text: d.lokacija })
  if (d.organizator) m.push({ icon: 'user', text: d.organizator })
  return m
})

const infoItems = computed(() => {
  if (!dogadjaj.value) return []
  const d = dogadjaj.value
  const items = []
  if (d.datum) items.push({ icon: 'calendar', label: t('detail.date'), value: d.datum })
  if (d.vrijeme) items.push({ icon: 'clock', label: t('detail.time'), value: d.vrijeme })
  if (d.lokacija) items.push({ icon: 'map-pin', label: t('detail.location'), value: d.lokacija })
  if (d.organizator) items.push({ icon: 'user', label: t('detail.organizer'), value: d.organizator })
  return items
})

const dodatUKalendar = ref(false)
</script>

<template>
  <AppContainer as="main" class="py-8">
    <EmptyState
      v-if="!dogadjaj"
      :title="$t('ev.notFoundTitle')"
      :text="$t('ev.notFoundText')"
    >
      <BaseButton variant="secondary" icon="arrow-left" :to="localePath('/dogadjaji')">
        {{ $t('ev.backToEvents') }}
      </BaseButton>
    </EmptyState>

    <template v-else>
      <Breadcrumb
        :items="[
          { label: $t('common.home'), to: localePath('/') },
          { label: $t('events.breadcrumb'), to: localePath('/dogadjaji') },
          { label: dogadjaj.naslov },
        ]"
      />

      <DetailGallery
        class="mt-5"
        :slika="dogadjaj.slika"
        :galerija="dogadjaj.galerija"
        :naslov="dogadjaj.naslov"
      />

      <DetailHero
        :kategorija="dogadjaj.kategorija"
        :naslov="dogadjaj.naslov"
        :meta="heroMeta"
      >
        <template #badges>
          <span v-if="dogadjaj.datum" class="inline-flex items-center gap-1.5 rounded-full bg-secondary px-3 py-1 text-[13px] font-bold text-primary-darker">
            <BaseIcon name="calendar" :size="13" />
            {{ dogadjaj.datum }}
          </span>
          <span v-if="dogadjaj.zavrseno" class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1 text-[13px] font-semibold text-white ring-1 ring-inset ring-white/15">
            <span class="size-2 rounded-full bg-red-400"></span>
            {{ $t('badge.zavrseno') }}
          </span>
        </template>
      </DetailHero>

      <div class="mt-8 grid gap-10 lg:grid-cols-3">
        <div class="space-y-8 lg:col-span-2">
          <section v-if="dogadjaj.opisDug">
            <h2 class="mb-3 font-heading text-2xl font-bold text-heading">{{ $t('ev.about') }}</h2>
            <div class="rtf" v-html="dogadjaj.opisDug" />
          </section>
        </div>

        <div class="space-y-4 lg:sticky lg:top-6 lg:self-start lg:max-h-[calc(100vh-3rem)] lg:overflow-y-auto lg:pr-1 lg:[scrollbar-width:thin]">
          <InfoPanel :title="$t('detail.information')" :items="infoItems">
            <BaseButton
              variant="primary"
              icon="calendar-plus"
              block
              :disabled="dogadjaj.zavrseno"
              @click="dodatUKalendar = true"
            >
              {{ $t('ev.addToCalendar') }}
            </BaseButton>
            <BaseAlert
              v-if="dodatUKalendar"
              variant="uspjeh"
              class="mt-4"
              :text="$t('ev.addedToCalendar')"
            />
          </InfoPanel>
          <MiniMap
            :label="dogadjaj.lokacija"
            :lat="dogadjaj.lat"
            :lng="dogadjaj.lng"
            :to="`/mapa?tacka=${encodeURIComponent(dogadjaj.slug)}`"
          />
        </div>
      </div>

      <RelatedContent v-if="povezani.length" :title="$t('detail.related')">
        <LinkCard v-for="p in povezani" :key="p.to" :item="p" />
      </RelatedContent>

      <RelatedContent v-if="slicni.length" :title="$t('ev.otherEvents')">
        <EventCard v-for="d in slicni" :key="d.slug" :item="d" />
      </RelatedContent>
    </template>
  </AppContainer>
</template>
