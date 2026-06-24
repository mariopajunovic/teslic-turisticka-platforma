<script setup>
import { computed, ref } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'

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
import BusinessCard from '@/components/cards/BusinessCard.vue'
import FormField from '@/components/forms/FormField.vue'
import FormTextarea from '@/components/forms/FormTextarea.vue'

const props = defineProps({
  slug: { type: String, default: '' },
  povezani: { type: Array, default: () => [] },
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

const page = usePage()

const upitForm = useForm({ ime: '', email: '', poruka: '' })

function posaljiUpit() {
  upitForm.post(`/domace-je-najbolje/${props.slug || biznis.value?.slug}/upit`, {
    preserveScroll: true,
    onSuccess: () => {
      upitForm.reset()
    },
  })
}
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
          <InfoPanel title="Kontakt" :items="infoItems" />
          <MiniMap :label="biznis.lokacija" />
        </div>
      </div>

      <div class="mt-10 rounded-lg border border-border bg-surface p-6 shadow-[var(--shadow-sm)]">
        <h2 class="font-heading text-xl font-semibold text-heading">Pošalji upit biznisu</h2>
        <form class="mt-5 space-y-4" @submit.prevent="posaljiUpit">
          <BaseAlert
            v-if="page.props.flash?.status"
            variant="uspjeh"
            title="Upit poslan"
            :text="page.props.flash.status"
          />
          <BaseAlert
            v-if="upitForm.hasErrors"
            variant="greska"
            title="Provjerite polja"
            text="Molimo ispravite greške u formi."
          />
          <FormField
            v-model="upitForm.ime"
            label="Ime i prezime"
            placeholder="npr. Marko Marković"
            required
            :error="upitForm.errors.ime"
          />
          <FormField
            v-model="upitForm.email"
            label="E-mail"
            type="email"
            placeholder="vasa@adresa.com"
            required
            :error="upitForm.errors.email"
          />
          <FormTextarea
            v-model="upitForm.poruka"
            label="Poruka"
            :maxlength="5000"
            placeholder="Vaša poruka…"
            required
            :error="upitForm.errors.poruka"
          />
          <BaseButton type="submit" variant="primary" icon="send" :loading="upitForm.processing">
            Pošalji upit
          </BaseButton>
        </form>
      </div>

      <RelatedContent v-if="povezani.length" title="Povezani sadržaj">
        <LinkCard v-for="p in povezani" :key="p.to" :item="p" />
      </RelatedContent>

      <RelatedContent v-if="slicni.length" title="Slično">
        <BusinessCard v-for="b in slicni" :key="b.slug" :item="b" />
      </RelatedContent>
    </template>
  </AppContainer>
</template>
