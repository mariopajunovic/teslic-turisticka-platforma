<script setup>
import { computed } from 'vue'

import AppContainer from '@/components/layout/AppContainer.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import Hero from '@/components/common/Hero.vue'
import Gallery from '@/components/common/Gallery.vue'
import AuthorBlock from '@/components/common/AuthorBlock.vue'
import RelatedContent from '@/components/common/RelatedContent.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import StoryCard from '@/components/cards/StoryCard.vue'

const props = defineProps({
  slug: { type: String, default: '' },
  prica: { type: Object, default: null },
  slicne: { type: Array, default: () => [] },
})

const prica = computed(() => props.prica)
const loading = false
const error = null
const slicne = computed(() => props.slicne)

const autor = computed(() => ({
  ime: prica.value?.autor,
  bio: prica.value?.autorBio,
}))
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
      <div class="mx-auto mt-8 max-w-2xl space-y-3">
        <div class="h-4 w-full animate-pulse rounded bg-neutral-tint" />
        <div class="h-4 w-full animate-pulse rounded bg-neutral-tint" />
        <div class="h-4 w-2/3 animate-pulse rounded bg-neutral-tint" />
      </div>
    </template>

    <EmptyState
      v-else-if="!prica"
      title="Priča nije pronađena"
      text="Tražena priča ne postoji ili je uklonjena."
    >
      <BaseButton variant="secondary" icon="arrow-left" to="/price">
        Nazad na priče
      </BaseButton>
    </EmptyState>

    <template v-else>
      <Breadcrumb
        :items="[
          { label: 'Početna', to: '/' },
          { label: 'Priče iz Teslića', to: '/price' },
          { label: prica.naslov },
        ]"
      />

      <div class="mt-6 overflow-hidden rounded-lg">
        <Hero
          variant="slika-pozadina"
          :kicker="prica.kategorija?.label"
          :title="prica.naslov"
          :subtitle="`${prica.autor} · ${prica.datum}`"
          :image="prica.slika"
        />
      </div>

      <article class="mx-auto mt-10 max-w-2xl">
        <p
          v-if="prica.izvod"
          class="mb-6 font-heading text-xl font-medium leading-relaxed text-heading"
        >
          {{ prica.izvod }}
        </p>
        <div class="space-y-4 whitespace-pre-line text-lg leading-relaxed text-text">
          {{ prica.sadrzaj }}
        </div>
      </article>

      <section v-if="prica.galerija?.length" class="mx-auto mt-10 max-w-2xl">
        <h2 class="mb-4 font-heading text-2xl font-bold text-heading">Galerija</h2>
        <Gallery :items="prica.galerija" />
      </section>

      <div class="mx-auto mt-10 max-w-2xl">
        <AuthorBlock :author="autor" to="/price" />
      </div>

      <RelatedContent v-if="slicne.length" title="Druge priče">
        <StoryCard v-for="p in slicne" :key="p.slug" :item="p" />
      </RelatedContent>
    </template>
  </AppContainer>
</template>
