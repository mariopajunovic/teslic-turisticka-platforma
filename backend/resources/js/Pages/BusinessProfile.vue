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

const props = defineProps({
  slug: { type: String, default: '' },
  povezani: { type: Array, default: () => [] },
  biznis: { type: Object, default: null },
  slicni: { type: Array, default: () => [] },
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
const upitForm = useForm({ ime: '', email: '', poruka: '' })

function posaljiUpit() {
  upitForm.post(`${biznis.value?.url}/upit`, {
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
        <button
          v-if="preview[0]"
          type="button"
          class="group relative overflow-hidden rounded-lg bg-primary-tint md:col-span-2 md:h-full"
          @click="otvoriGaleriju(0)"
        >
          <img :src="preview[0].src" :alt="biznis.naslov" class="size-full object-cover transition-transform duration-300 group-hover:scale-[1.02]" />
        </button>
        <div v-else class="flex h-64 items-center justify-center rounded-lg bg-primary-tint text-primary md:col-span-2 md:h-full">
          <BaseIcon name="image" :size="48" />
        </div>

        <div class="grid grid-cols-2 gap-3 md:grid-cols-1">
          <template v-for="n in 2" :key="n">
            <button
              v-if="preview[n]"
              type="button"
              class="group relative overflow-hidden rounded-lg bg-primary-tint md:h-[214px]"
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
            <div v-else class="flex h-32 items-center justify-center rounded-lg bg-primary-tint text-primary md:h-[214px]">
              <BaseIcon name="image" :size="32" />
            </div>
          </template>
        </div>
      </div>

      <Lightbox v-model="lbOpen" :items="sveSlike" :start-index="lbIndex" />

      <!-- Naslovni blok -->
      <header class="mt-8 border-b border-border pb-7">
        <div class="flex flex-wrap items-center gap-2">
          <BaseChip
            v-if="biznis.kategorija"
            variant="kategorija"
            :label="biznis.kategorija.label"
            :icon="biznis.kategorija.icon"
          />
          <BaseBadge v-if="biznis.preporuceno" variant="preporuceno" />
        </div>

        <h1 class="mt-3.5 font-heading text-3xl font-extrabold leading-tight text-heading md:text-[2.5rem]">
          {{ biznis.naslov }}
        </h1>

        <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-[15px] text-text-muted">
          <span v-if="biznis.lokacija" class="flex items-center gap-1.5">
            <BaseIcon name="map-pin" :size="17" class="text-primary" />
            {{ biznis.lokacija }}
          </span>
          <span v-if="biznis.cijenaRaspon" class="font-semibold text-heading">{{ biznis.cijenaRaspon }}</span>
          <span v-if="biznis.godinaOsnivanja" class="flex items-center gap-1.5">
            <BaseIcon name="star" :size="15" class="text-primary" />
            {{ $t('detail.since') }} {{ biznis.godinaOsnivanja }}
          </span>
        </div>

        <p v-if="biznis.opis" class="mt-4 max-w-3xl text-lg leading-relaxed text-text">
          {{ biznis.opis }}
        </p>
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
            <h2 class="mb-3 flex items-center gap-2 font-heading text-xl font-bold text-heading">
              <BaseIcon name="clock" :size="20" class="text-primary" />
              {{ $t('detail.hours') }}
            </h2>
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

        <div class="space-y-4">
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
