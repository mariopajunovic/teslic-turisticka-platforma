<script setup>
import { computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'

import AppContainer from '@/components/layout/AppContainer.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import InfoPanel from '@/components/common/InfoPanel.vue'
import MiniMap from '@/components/common/MiniMap.vue'
import RelatedContent from '@/components/common/RelatedContent.vue'
import CTASection from '@/components/common/CTASection.vue'
import LinkCard from '@/components/cards/LinkCard.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseChip from '@/components/base/BaseChip.vue'
import BaseBadge from '@/components/base/BaseBadge.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import BusinessCard from '@/components/cards/BusinessCard.vue'
import FormField from '@/components/forms/FormField.vue'
import FormTextarea from '@/components/forms/FormTextarea.vue'

const props = defineProps({
  slug: { type: String, default: '' },
  povezani: { type: Array, default: () => [] },
  biznis: { type: Object, default: null },
  slicni: { type: Array, default: () => [] },
})

const { t } = useI18n()

const biznis = computed(() => props.biznis)
const slicni = computed(() => props.slicni)

const galerija = computed(() => {
  const g = (biznis.value?.galerija || []).map((m) => m.src).filter(Boolean)
  const naslovna = biznis.value?.slika
  const slike = [naslovna, ...g].filter(Boolean)
  return slike.slice(0, 3)
})

const infoItems = computed(() => {
  if (!biznis.value) return []
  const k = biznis.value.kontakt || {}
  const items = []
  if (k.adresa) items.push({ icon: 'map-pin', label: t('contact.address'), value: k.adresa })
  if (k.telefon)
    items.push({
      icon: 'phone',
      label: t('detail.phone'),
      value: k.telefon,
      href: `tel:${k.telefon.replace(/[^0-9+]/g, '')}`,
    })
  if (k.email)
    items.push({ icon: 'mail', label: t('detail.email'), value: k.email, href: `mailto:${k.email}` })
  if (k.radnoVrijeme)
    items.push({ icon: 'clock', label: t('detail.hours'), value: k.radnoVrijeme })
  if (k.web)
    items.push({
      icon: 'globe',
      label: t('detail.website'),
      value: k.web,
      href: k.web.startsWith('http') ? k.web : `https://${k.web}`,
    })
  return items
})

const page = usePage()
const upitForm = useForm({ ime: '', email: '', poruka: '' })

function posaljiUpit() {
  upitForm.post(`/domace-je-najbolje/${props.slug || biznis.value?.slug}/upit`, {
    preserveScroll: true,
    onSuccess: () => upitForm.reset(),
  })
}
</script>

<template>
  <AppContainer as="main" class="py-8">
    <EmptyState
      v-if="!biznis"
      :title="$t('biz.notFoundTitle')"
      :text="$t('biz.notFoundText')"
    >
      <BaseButton variant="secondary" icon="arrow-left" to="/domace-je-najbolje">
        {{ $t('biz.backToOffer') }}
      </BaseButton>
    </EmptyState>

    <template v-else>
      <Breadcrumb
        :items="[
          { label: $t('common.home'), to: '/' },
          { label: $t('local.breadcrumb'), to: '/domace-je-najbolje' },
          { label: biznis.naslov },
        ]"
      />

      <!-- Galerija: glavna + bočne -->
      <div class="mt-5 grid gap-3 md:h-[440px] md:grid-cols-3">
        <div
          class="relative overflow-hidden rounded-lg bg-primary-tint md:col-span-2 md:h-full"
        >
          <img
            v-if="galerija[0]"
            :src="galerija[0]"
            :alt="biznis.naslov"
            class="size-full object-cover"
          />
          <span v-else class="flex h-64 items-center justify-center text-primary md:h-full">
            <BaseIcon name="image" :size="48" />
          </span>
        </div>
        <div class="grid grid-cols-2 gap-3 md:grid-cols-1">
          <div
            v-for="n in 2"
            :key="n"
            class="relative overflow-hidden rounded-lg bg-primary-tint md:h-[214px]"
          >
            <img
              v-if="galerija[n]"
              :src="galerija[n]"
              :alt="biznis.naslov"
              class="size-full object-cover"
            />
            <span v-else class="flex h-32 items-center justify-center text-primary md:h-full">
              <BaseIcon name="image" :size="32" />
            </span>
          </div>
        </div>
      </div>

      <!-- Naslovni blok -->
      <div class="mt-7 flex flex-wrap items-start justify-between gap-4">
        <div>
          <BaseChip
            v-if="biznis.kategorija"
            variant="kategorija"
            :label="biznis.kategorija.label"
            :icon="biznis.kategorija.icon"
          />
          <h1 class="mt-3 font-heading text-3xl font-extrabold text-heading md:text-4xl">
            {{ biznis.naslov }}
          </h1>
          <div class="mt-2 flex items-center gap-1.5 text-text-muted">
            <BaseIcon name="map-pin" :size="16" />
            <span>{{ biznis.lokacija }}</span>
          </div>
        </div>
        <BaseBadge v-if="biznis.preporuceno" variant="preporuceno" />
      </div>

      <!-- Dvokolonski sadržaj -->
      <div class="mt-8 grid gap-10 lg:grid-cols-3">
        <div class="lg:col-span-2">
          <h2 class="mb-3 font-heading text-2xl font-bold text-heading">{{ $t('biz.about') }}</h2>
          <p class="whitespace-pre-line leading-relaxed text-text">
            {{ biznis.opisDug || biznis.opis }}
          </p>
        </div>

        <div class="space-y-4">
          <InfoPanel :title="$t('biz.contactInfo')" :items="infoItems" />
          <a
            href="#upit"
            class="flex w-full items-center justify-center gap-2 rounded-sm bg-primary px-5 py-3 font-heading text-sm font-bold text-white transition-colors hover:bg-primary-dark"
          >
            <BaseIcon name="send" :size="16" />
            {{ $t('biz.sendInquiry') }}
          </a>
          <MiniMap :label="biznis.lokacija" />
        </div>
      </div>

      <!-- Pošalji upit -->
      <div
        id="upit"
        class="mt-12 rounded-lg border border-border bg-surface p-6 shadow-[var(--shadow-sm)] md:p-8"
      >
        <h2 class="font-heading text-xl font-bold text-heading">{{ $t('biz.sendInquiryTitle') }}</h2>
        <form class="mt-5 space-y-4" @submit.prevent="posaljiUpit">
          <BaseAlert
            v-if="page.props.flash?.status"
            variant="uspjeh"
            :title="$t('biz.inquirySent')"
            :text="page.props.flash.status"
          />
          <BaseAlert
            v-if="upitForm.hasErrors"
            variant="greska"
            :title="$t('biz.checkFields')"
            :text="$t('biz.fixErrors')"
          />
          <div class="grid gap-4 sm:grid-cols-2">
            <FormField
              v-model="upitForm.ime"
              :label="$t('contact.name')"
              :placeholder="$t('contact.namePlaceholder')"
              required
              :error="upitForm.errors.ime"
            />
            <FormField
              v-model="upitForm.email"
              :label="$t('contact.email')"
              type="email"
              :placeholder="$t('contact.emailPlaceholder')"
              required
              :error="upitForm.errors.email"
            />
          </div>
          <FormTextarea
            v-model="upitForm.poruka"
            :label="$t('contact.message')"
            :maxlength="5000"
            :placeholder="$t('contact.messagePlaceholder')"
            required
            :error="upitForm.errors.poruka"
          />
          <BaseButton type="submit" variant="primary" icon="send" :loading="upitForm.processing">
            {{ $t('biz.sendInquiry') }}
          </BaseButton>
        </form>
      </div>

      <!-- Povezani sadržaj -->
      <RelatedContent
        v-if="povezani.length"
        :kicker="$t('common.related')"
        :title="$t('biz.relatedTitle')"
        back-to="/domace-je-najbolje"
        :back-label="$t('biz.backAll')"
      >
        <LinkCard v-for="p in povezani" :key="p.to" :item="p" />
      </RelatedContent>

      <RelatedContent v-if="slicni.length" :title="$t('biz.similar')">
        <BusinessCard v-for="b in slicni" :key="b.slug" :item="b" />
      </RelatedContent>

      <div class="mt-12">
        <CTASection
          :title="$t('local.ctaTitle')"
          :text="$t('local.ctaText')"
        >
          <BaseButton variant="sekundarna" to="/pridruzi-se/biznis">{{ $t('local.ctaButton') }}</BaseButton>
        </CTASection>
      </div>
    </template>
  </AppContainer>
</template>
