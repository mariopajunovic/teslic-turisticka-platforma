<script setup>
import AppContainer from '@/components/layout/AppContainer.vue'
import Hero from '@/components/common/Hero.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import CTASection from '@/components/common/CTASection.vue'
import RelatedContent from '@/components/common/RelatedContent.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import BusinessCard from '@/components/cards/BusinessCard.vue'
import EventCard from '@/components/cards/EventCard.vue'
import StoryCard from '@/components/cards/StoryCard.vue'

defineProps({
  related: {
    type: Object,
    default: () => ({ biznis: null, dogadjaj: null, prica: null }),
  },
})

const ciljevi = [
  { icon: 'compass', title: 'Otkrivanje', text: 'Posjetiocu olakšati da na jednom mjestu otkrije sve što Teslić nudi.' },
  { icon: 'store', title: 'Vidljivost', text: 'Lokalnim biznisima dati moderan izlog i direktan kontakt s publikom.' },
  { icon: 'book-open', title: 'Priče', text: 'Dati prostor autorima i domaćinima da ispričaju autentične priče.' },
  { icon: 'calendar', title: 'Događaji', text: 'Na jednom mjestu objediniti sve aktuelne i nadolazeće događaje.' },
  { icon: 'map', title: 'Orijentacija', text: 'Interaktivnom mapom povezati ponudu s tačnom lokacijom.' },
  { icon: 'users', title: 'Zajednica', text: 'Povezati posjetioce, domaćine i lokalnu zajednicu Teslića.' },
]

const publika = [
  {
    icon: 'users',
    title: 'Posjetiocima',
    text: 'Otkrijte domaću ponudu, atrakcije, događaje i priče Teslića — sve na jednom mjestu.',
    cta: 'Istraži turizam',
    to: '/turizam',
    accent: false,
  },
  {
    icon: 'store',
    title: 'Biznisima i domaćinima',
    text: 'Predstavite proizvode i usluge modernim izlogom i dođite do novih gostiju.',
    cta: 'Domaće je najbolje',
    to: '/domace-je-najbolje',
    accent: false,
  },
  {
    icon: 'pen',
    title: 'Autorima',
    text: 'Pišite priče o ljudima, mjestima i običajima i povežite ih sa stvarnim mjestima.',
    cta: 'Priče iz Teslića',
    to: '/price',
    accent: true,
  },
]

const partneri = [
  'Turistička organizacija Teslić',
  'Opština Teslić',
  'Banja Vrućica',
  'Privredna komora',
  'Lokalni proizvođači',
]
</script>

<template>
  <main class="pb-12 md:pb-16">
    <Hero
      kicker="O projektu"
      kicker-class="text-primary-tint-2"
      title="Platforma koja povezuje Teslić"
      subtitle="Jedno mjesto za domaću ponudu, turizam, događaje i priče — i otvoren poziv svima da budu dio njega."
      image="https://images.unsplash.com/photo-1652552888460-334e60915994?auto=format&fit=crop&w=1600&q=80"
    />

    <AppContainer class="pt-6">
      <Breadcrumb :items="[{ label: 'Početna', to: '/' }, { label: 'O projektu' }]" />
    </AppContainer>

    <!-- Misija -->
    <section class="py-12 md:py-16">
      <AppContainer>
        <p class="text-sm font-bold uppercase tracking-wider text-accent-deep">Misija</p>
        <h2 class="mt-3 max-w-3xl font-heading text-3xl font-extrabold text-heading md:text-4xl">
          Jedno digitalno mjesto za cijeli Teslić
        </h2>
        <p class="mt-4 max-w-3xl text-lg leading-relaxed text-text-muted">
          Platforma okuplja domaću ponudu, turističke atrakcije, događaje i priče na jednom mjestu —
          da posjetilac u jednom scroll-u upozna Teslić, a domaćini, biznisi i autori dobiju
          vidljivost i direktnu vezu s publikom. Ista priča koju otvara Početna nastavlja se kroz
          svaku stranicu.
        </p>
      </AppContainer>
    </section>

    <!-- Ciljevi -->
    <section class="py-4 pb-12 md:pb-16">
      <AppContainer>
        <h2 class="font-heading text-2xl font-bold text-heading">Ciljevi platforme</h2>
        <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
          <div
            v-for="cilj in ciljevi"
            :key="cilj.title"
            class="rounded-md bg-surface-alt p-6"
          >
            <BaseIcon :name="cilj.icon" :size="26" class="text-primary" />
            <h3 class="mt-3 font-heading text-lg font-bold text-heading">{{ cilj.title }}</h3>
            <p class="mt-2 text-sm leading-relaxed text-text-muted">{{ cilj.text }}</p>
          </div>
        </div>
      </AppContainer>
    </section>

    <!-- Kome je namijenjena -->
    <section class="pb-12 md:pb-16">
      <AppContainer>
        <h2 class="font-heading text-2xl font-bold text-heading">Kome je platforma namijenjena</h2>
        <div class="mt-6 grid gap-5 md:grid-cols-3">
          <div
            v-for="grupa in publika"
            :key="grupa.title"
            class="flex flex-col rounded-lg border border-border bg-surface p-7"
          >
            <span
              class="flex size-13 items-center justify-center rounded-md"
              :class="grupa.accent ? 'bg-accent-tint text-accent-dark' : 'bg-primary-tint text-primary'"
            >
              <BaseIcon :name="grupa.icon" :size="26" />
            </span>
            <h3 class="mt-4 font-heading text-xl font-bold text-heading">{{ grupa.title }}</h3>
            <p class="mt-2 flex-1 leading-relaxed text-text-muted">{{ grupa.text }}</p>
            <BaseButton
              variant="ghost"
              size="sm"
              icon="arrow-right"
              icon-position="right"
              :to="grupa.to"
              class="mt-4 self-start px-0"
              :class="grupa.accent ? 'text-accent-dark' : 'text-primary'"
            >
              {{ grupa.cta }}
            </BaseButton>
          </div>
        </div>
      </AppContainer>
    </section>

    <!-- Partneri -->
    <section class="bg-surface-alt py-12 md:py-14">
      <AppContainer>
        <h2 class="font-heading text-2xl font-bold text-heading">Nosilac i partneri projekta</h2>
        <p class="mt-3 max-w-3xl text-text-muted">
          Projekat vodi Turistička organizacija Teslić u saradnji s lokalnim partnerima.
        </p>
        <div class="mt-6 flex flex-wrap gap-4">
          <div
            v-for="p in partneri"
            :key="p"
            class="flex h-16 min-w-[180px] flex-1 items-center justify-center rounded-sm border border-border bg-surface px-6 text-center text-sm font-bold text-text-muted"
          >
            {{ p }}
          </div>
        </div>
      </AppContainer>
    </section>

    <!-- Povezani sadržaj -->
    <section class="py-12 md:py-16">
      <AppContainer>
        <RelatedContent
          kicker="Povezano"
          title="Istraži Teslić iz svih uglova"
          back-to="/"
          back-label="← Nazad na Početnu"
        >
          <BusinessCard v-if="related.biznis" :item="related.biznis" />
          <EventCard v-if="related.dogadjaj" :item="related.dogadjaj" />
          <StoryCard v-if="related.prica" :item="related.prica" />
        </RelatedContent>
      </AppContainer>
    </section>

    <!-- CTA -->
    <AppContainer>
      <CTASection
        title="Imate biznis ili priču iz Teslića?"
        text="Pridružite se platformi i predstavite svoju ponudu, proizvode ili priču posjetiocima Teslića."
      >
        <BaseButton variant="sekundarna" to="/pridruzi-se">Pridruži se</BaseButton>
      </CTASection>
    </AppContainer>
  </main>
</template>
