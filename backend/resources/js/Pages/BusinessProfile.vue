<script setup>
import { computed, ref } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'

import AppContainer from '@/components/layout/AppContainer.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import DetailGallery from '@/components/common/DetailGallery.vue'
import DetailHero from '@/components/common/DetailHero.vue'
import InfoPanel from '@/components/common/InfoPanel.vue'
import MiniMap from '@/components/common/MiniMap.vue'
import RelatedContent from '@/components/common/RelatedContent.vue'
import CTASection from '@/components/common/CTASection.vue'
import LinkCard from '@/components/cards/LinkCard.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import BusinessCard from '@/components/cards/BusinessCard.vue'
import FormField from '@/components/forms/FormField.vue'
import FormTextarea from '@/components/forms/FormTextarea.vue'
import FormCaptcha from '@/components/forms/FormCaptcha.vue'

const props = defineProps({
  slug: { type: String, default: '' },
  povezani: { type: Array, default: () => [] },
  biznis: { type: Object, default: null },
  slicni: { type: Array, default: () => [] },
  nazad: { type: Object, default: () => ({ url: '/', label: '' }) },
  otvoreno: { type: Boolean, default: null },
})

const { t, tm, rt } = useI18n()

const dani = computed(() => tm('cal.daysFull').map(rt))
const radnoDani = computed(() => (Array.isArray(biznis.value?.radnoVrijeme) ? biznis.value.radnoVrijeme : []))
const usluge = computed(() => (Array.isArray(biznis.value?.usluge) ? biznis.value.usluge : []))
const SOCIAL_ICON = { facebook: 'facebook', instagram: 'instagram', youtube: 'youtube', tiktok: 'share' }
const socijalne = computed(() => {
  const d = biznis.value?.drustvene || {}
  return ['facebook', 'instagram', 'youtube', 'tiktok']
    .filter((k) => d[k])
    .map((k) => ({ mreza: k, url: d[k], icon: SOCIAL_ICON[k] }))
})
const PLACANJE_LABEL = { gotovina: 'Gotovina', kartica: 'Kartica', virman: 'Virman' }

const biznis = computed(() => props.biznis)
const slicni = computed(() => props.slicni)

const heroMeta = computed(() => {
  const b = biznis.value
  if (!b) return []
  const m = []
  if (b.lokacija) m.push({ icon: 'map-pin', text: b.lokacija })
  if (b.godinaOsnivanja) m.push({ icon: 'calendar', text: `${t('detail.since')} ${b.godinaOsnivanja}` })
  if (b.jib) m.push({ icon: 'file-text', text: `${t('detail.jib')} ${b.jib}` })
  return m
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
  if (k.viber)
    items.push({ icon: 'phone', label: 'Viber', value: k.viber, href: `viber://chat?number=${encodeURIComponent(k.viber)}` })
  if (k.whatsapp)
    items.push({ icon: 'phone', label: 'WhatsApp', value: k.whatsapp, href: `https://wa.me/${k.whatsapp.replace(/[^0-9]/g, '')}` })
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
const upitOpen = ref(false)
const upitForm = useForm({ ime: '', email: '', poruka: '', captcha: false, nadimak: '' })

function posaljiUpit() {
  upitForm.post(`${biznis.value?.url}/upit`, {
    preserveScroll: true,
    onSuccess: () => { upitForm.reset(); upitOpen.value = false },
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
      <BaseButton variant="secondary" icon="arrow-left" :to="nazad.url || '/'">
        {{ $t('biz.backToOffer') }}
      </BaseButton>
    </EmptyState>

    <template v-else>
      <Breadcrumb
        :items="[
          { label: $t('common.home'), to: '/' },
          { label: nazad.label || $t('local.breadcrumb'), to: nazad.url || '/' },
          { label: biznis.naslov },
        ]"
      />

      <DetailGallery
        class="mt-5"
        :slika="biznis.slika"
        :galerija="biznis.galerija"
        :naslov="biznis.naslov"
      />

      <DetailHero
        :kategorija="biznis.kategorija"
        :naslov="biznis.naslov"
        :opis="biznis.opis"
        :logo="biznis.logo"
        :meta="heroMeta"
      >
        <template #badges>
          <span v-if="biznis.preporuceno" class="inline-flex items-center gap-1.5 rounded-full bg-secondary px-3 py-1 text-[13px] font-bold text-primary-darker">
            <BaseIcon name="star" :size="13" />
            {{ $t('badge.preporuceno') }}
          </span>
          <span v-if="otvoreno !== null" class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1 text-[13px] font-semibold text-white ring-1 ring-inset ring-white/15">
            <span class="size-2 rounded-full" :class="otvoreno ? 'bg-green-400' : 'bg-red-400'"></span>
            {{ otvoreno ? $t('detail.open') : $t('detail.closed') }}
          </span>
        </template>
      </DetailHero>

      <!-- Dvokolonski sadržaj -->
      <div class="mt-8 grid gap-10 lg:grid-cols-3">
        <div class="lg:col-span-2">
          <template v-if="biznis.opisDug">
            <h2 class="mb-3 font-heading text-2xl font-bold text-heading">{{ $t('biz.about') }}</h2>
            <div class="rtf" v-html="biznis.opisDug" />
          </template>

          <section v-if="usluge.length" class="mt-8">
            <h2 class="mb-3 font-heading text-xl font-bold text-heading">{{ $t('detail.services') }}</h2>
            <ul class="grid gap-2 sm:grid-cols-2">
              <li v-for="(u, i) in usluge" :key="i" class="flex items-center gap-2 text-[15px] text-text">
                <BaseIcon name="circle-check" :size="18" class="shrink-0 text-primary" />
                {{ u }}
              </li>
            </ul>
          </section>

          <section v-if="radnoDani.length" class="mt-8">
            <h2 class="mb-3 font-heading text-xl font-bold text-heading">{{ $t('detail.hours') }}</h2>
            <ul class="divide-y divide-border rounded-md border border-border">
              <li
                v-for="(d, i) in radnoDani"
                :key="i"
                class="flex items-center justify-between px-4 py-2.5 text-[15px]"
              >
                <span class="font-medium text-heading">{{ dani[i] }}</span>
                <span v-if="d.zatvoreno" class="text-text-muted">{{ $t('detail.closed') }}</span>
                <span v-else class="tabular-nums text-text">{{ d.od }} - {{ d.do }}</span>
              </li>
            </ul>
          </section>
        </div>

        <div class="space-y-4 lg:sticky lg:top-6 lg:self-start lg:max-h-[calc(100vh-3rem)] lg:overflow-y-auto lg:pr-1 lg:[scrollbar-width:thin]">
          <InfoPanel :title="$t('biz.contactInfo')" :items="infoItems" />

          <div v-if="socijalne.length" class="flex flex-wrap gap-2">
            <a
              v-for="s in socijalne"
              :key="s.mreza"
              :href="s.url"
              target="_blank"
              rel="noopener"
              :aria-label="s.mreza"
              class="flex size-10 items-center justify-center rounded-full border border-border bg-surface text-text-muted transition-colors hover:border-primary hover:bg-primary-tint hover:text-primary"
            >
              <BaseIcon :name="s.icon" :size="18" />
            </a>
          </div>

          <div v-if="(biznis.nacinPlacanja || []).length" class="rounded-md border border-border bg-surface-alt p-4">
            <p class="mb-2 text-xs font-bold uppercase tracking-wide text-text-muted">{{ $t('detail.payment') }}</p>
            <div class="flex flex-wrap gap-2">
              <span v-for="p in biznis.nacinPlacanja" :key="p" class="rounded-full bg-surface px-3 py-1 text-[13px] font-medium text-text">
                {{ PLACANJE_LABEL[p] || p }}
              </span>
            </div>
          </div>
          <button
            type="button"
            class="flex w-full items-center justify-center gap-2 rounded-sm bg-primary px-5 py-3 font-heading text-sm font-bold text-white transition-colors hover:bg-primary-dark"
            @click="upitOpen = true"
          >
            <BaseIcon name="send" :size="16" />
            {{ $t('biz.sendInquiry') }}
          </button>
          <MiniMap :label="biznis.lokacija" :lat="biznis.lat" :lng="biznis.lng" :to="`/mapa?tacka=${encodeURIComponent(biznis.slug)}`" />
        </div>
      </div>

      <BaseAlert
        v-if="page.props.flash?.status"
        variant="uspjeh"
        class="mt-6"
        :title="$t('biz.inquirySent')"
        :text="page.props.flash.status"
      />

      <!-- Modal: Pošalji upit -->
      <Teleport to="body">
        <div v-if="upitOpen" class="fixed inset-0 z-[80] flex items-start justify-center overflow-y-auto p-4 sm:p-8">
          <div class="absolute inset-0 bg-overlay" @click="upitOpen = false"></div>
          <div class="relative my-auto w-full max-w-[520px] rounded-lg border border-border bg-surface shadow-[var(--shadow-lg)]">
            <div class="flex items-center justify-between border-b border-border px-6 py-4">
              <h2 class="font-heading text-lg font-bold text-heading">{{ $t('biz.sendInquiryTitle') }}</h2>
              <button type="button" class="text-text-muted hover:text-heading" :aria-label="$t('common.close') || 'Zatvori'" @click="upitOpen = false">
                <BaseIcon name="x" :size="20" />
              </button>
            </div>
            <form class="space-y-4 p-6" @submit.prevent="posaljiUpit">
              <p class="text-sm text-text-muted">{{ biznis.naslov }}</p>
              <BaseAlert
                v-if="upitForm.hasErrors"
                variant="greska"
                :title="$t('biz.checkFields')"
                :text="$t('biz.fixErrors')"
              />
              <div class="grid gap-4 sm:grid-cols-2">
                <FormField v-model="upitForm.ime" :label="$t('contact.name')" :placeholder="$t('contact.namePlaceholder')" required :error="upitForm.errors.ime" />
                <FormField v-model="upitForm.email" :label="$t('contact.email')" type="email" :placeholder="$t('contact.emailPlaceholder')" required :error="upitForm.errors.email" />
              </div>
              <FormTextarea v-model="upitForm.poruka" :label="$t('contact.message')" :maxlength="5000" :placeholder="$t('contact.messagePlaceholder')" required :error="upitForm.errors.poruka" />

              <!-- honeypot (skriveno; boti popune, ljudi ne) -->
              <input v-model="upitForm.nadimak" type="text" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true" />

              <FormCaptcha v-model="upitForm.captcha" />
              <p v-if="upitForm.errors.captcha" class="text-sm text-error">{{ upitForm.errors.captcha }}</p>

              <div class="flex justify-end gap-2.5 pt-1">
                <BaseButton type="button" variant="secondary" @click="upitOpen = false">Odustani</BaseButton>
                <BaseButton type="submit" variant="primary" icon="send" :loading="upitForm.processing">
                  {{ $t('biz.sendInquiry') }}
                </BaseButton>
              </div>
            </form>
          </div>
        </div>
      </Teleport>

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
