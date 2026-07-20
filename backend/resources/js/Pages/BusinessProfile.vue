<script setup>
import { computed, ref } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import Lightbox from '@/components/common/Lightbox.vue'

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

const sveSlike = computed(() => {
  const g = (biznis.value?.galerija || [])
    .map((m) => ({ src: m.src, alt: m.alt || biznis.value?.naslov }))
    .filter((x) => x.src)
  const naslovna = biznis.value?.slika
  return [...(naslovna ? [{ src: naslovna, alt: biznis.value?.naslov }] : []), ...g]
})
const preview = computed(() => sveSlike.value.slice(0, 3))
const preostalo = computed(() => Math.max(0, sveSlike.value.length - 3))

const lbOpen = ref(false)
const lbIndex = ref(0)
const otvoriGaleriju = (i) => {
  lbIndex.value = i
  lbOpen.value = true
}

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

      <!-- Galerija: glavna + bočne -->
      <div class="mt-5 grid gap-3 md:h-[440px] md:grid-cols-3">
        <button
          v-if="preview[0]"
          type="button"
          class="group relative aspect-[16/10] overflow-hidden rounded-lg bg-primary-tint md:aspect-auto md:h-full"
          :class="preview.length > 1 ? 'md:col-span-2' : 'md:col-span-3'"
          @click="otvoriGaleriju(0)"
        >
          <img :src="preview[0].src" :alt="biznis.naslov" class="size-full object-cover transition-transform duration-300 group-hover:scale-[1.02]" />
        </button>
        <div v-else class="flex aspect-[16/10] items-center justify-center rounded-lg bg-primary-tint text-primary md:col-span-3 md:aspect-auto md:h-full">
          <BaseIcon name="image" :size="48" />
        </div>

        <div v-if="preview.length > 1" class="grid grid-cols-2 gap-3 md:grid-cols-1">
          <button
            v-for="n in (preview.length - 1)"
            :key="n"
            type="button"
            class="group relative aspect-square overflow-hidden rounded-lg bg-primary-tint md:aspect-auto md:h-[214px]"
            @click="otvoriGaleriju(n)"
          >
            <img :src="preview[n].src" :alt="biznis.naslov" class="size-full object-cover transition-transform duration-300 group-hover:scale-[1.02]" />
            <span
              v-if="n === 2 && preostalo > 0"
              class="absolute inset-0 flex items-center justify-center bg-heading/60 text-white transition-colors group-hover:bg-heading/70"
            >
              <span class="font-heading text-2xl font-bold">+{{ preostalo }}</span>
            </span>
          </button>
        </div>
      </div>

      <Lightbox v-model="lbOpen" :items="sveSlike" :start-index="lbIndex" />

      <!-- Naslovni blok -->
      <header class="mt-8 overflow-hidden rounded-2xl bg-primary-darker text-primary-tint">
        <div class="relative flex flex-col gap-6 p-6 md:flex-row md:items-start md:justify-between md:gap-9 md:p-9">
          <div class="pointer-events-none absolute -right-20 -top-24 hidden size-72 rounded-full bg-primary/40 blur-3xl md:block"></div>
          <div class="pointer-events-none absolute -bottom-24 right-24 hidden size-56 rounded-full bg-secondary/20 blur-3xl md:block"></div>

          <div class="relative flex min-w-0 flex-1 items-start gap-4 md:gap-5">
            <div v-if="biznis.logo" class="shrink-0">
              <div class="flex size-16 items-center justify-center overflow-hidden rounded-2xl bg-white p-2 shadow-[var(--shadow-lg)] ring-1 ring-black/5 sm:size-20 md:size-28 md:p-2.5">
                <img :src="biznis.logo" :alt="biznis.naslov" class="max-h-full max-w-full object-contain" />
              </div>
            </div>

            <div class="min-w-0">
              <div class="flex flex-wrap items-center gap-2">
                <span v-if="biznis.kategorija" class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1 text-[13px] font-semibold text-white ring-1 ring-inset ring-white/15">
                  <BaseIcon v-if="biznis.kategorija.icon" :name="biznis.kategorija.icon" :size="14" />
                  {{ biznis.kategorija.label }}
                </span>
                <span v-if="biznis.preporuceno" class="inline-flex items-center gap-1.5 rounded-full bg-secondary px-3 py-1 text-[13px] font-bold text-primary-darker">
                  <BaseIcon name="star" :size="13" />
                  {{ $t('badge.preporuceno') }}
                </span>
                <span v-if="otvoreno !== null" class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1 text-[13px] font-semibold text-white ring-1 ring-inset ring-white/15">
                  <span class="size-2 rounded-full" :class="otvoreno ? 'bg-green-400' : 'bg-red-400'"></span>
                  {{ otvoreno ? $t('detail.open') : $t('detail.closed') }}
                </span>
              </div>

              <h1 class="mt-3 font-heading text-2xl font-extrabold leading-tight text-white sm:text-3xl md:text-[2.6rem]">
                {{ biznis.naslov }}
              </h1>

              <p v-if="biznis.opis" class="mt-3 max-w-2xl text-[15px] leading-relaxed text-primary-tint/80">
                {{ biznis.opis }}
              </p>
            </div>
          </div>

          <div
            v-if="biznis.lokacija || biznis.godinaOsnivanja || biznis.jib"
            class="relative flex shrink-0 flex-col gap-2 text-[15px] md:gap-2.5 md:items-end md:text-right"
          >
            <span v-if="biznis.lokacija" class="flex items-center gap-1.5 text-primary-tint/90">
              <BaseIcon name="map-pin" :size="17" class="text-secondary" />
              {{ biznis.lokacija }}
            </span>
            <span v-if="biznis.godinaOsnivanja" class="flex items-center gap-1.5 text-primary-tint/90">
              <BaseIcon name="calendar" :size="15" class="text-secondary" />
              {{ $t('detail.since') }} {{ biznis.godinaOsnivanja }}
            </span>
            <span v-if="biznis.jib" class="flex items-center gap-1.5 text-primary-tint/90">
              <BaseIcon name="file-text" :size="15" class="text-secondary" />
              {{ $t('detail.jib') }} {{ biznis.jib }}
            </span>
          </div>
        </div>
      </header>

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
