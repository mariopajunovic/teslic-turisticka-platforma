<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
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

const { t } = useI18n()

const ciljevi = computed(() => [
  { icon: 'compass', title: t('about.g1t'), text: t('about.g1x') },
  { icon: 'store', title: t('about.g2t'), text: t('about.g2x') },
  { icon: 'book-open', title: t('about.g3t'), text: t('about.g3x') },
  { icon: 'calendar', title: t('about.g4t'), text: t('about.g4x') },
  { icon: 'map', title: t('about.g5t'), text: t('about.g5x') },
  { icon: 'users', title: t('about.g6t'), text: t('about.g6x') },
])

const publika = computed(() => [
  { icon: 'users', title: t('about.a1t'), text: t('about.a1x'), cta: t('about.a1c'), to: '/turizam', accent: false },
  { icon: 'store', title: t('about.a2t'), text: t('about.a2x'), cta: t('about.a2c'), to: '/domace-je-najbolje', accent: false },
  { icon: 'pen', title: t('about.a3t'), text: t('about.a3x'), cta: t('about.a3c'), to: '/price', accent: true },
])

const partneri = computed(() => [
  t('about.p1'),
  t('about.p2'),
  t('about.p3'),
  t('about.p4'),
  t('about.p5'),
])
</script>

<template>
  <main class="pb-12 md:pb-16">
    <Hero
      :kicker="$t('about.heroKicker')"
      kicker-class="text-primary-tint-2"
      :title="$t('about.heroTitle')"
      :subtitle="$t('about.heroSubtitle')"
      image="https://images.unsplash.com/photo-1652552888460-334e60915994?auto=format&fit=crop&w=1600&q=80"
    />

    <AppContainer class="pt-6">
      <Breadcrumb :items="[{ label: $t('common.home'), to: '/' }, { label: $t('about.breadcrumb') }]" />
    </AppContainer>

    <!-- Misija -->
    <section class="py-12 md:py-16">
      <AppContainer>
        <p class="text-sm font-bold uppercase tracking-wider text-accent-deep">{{ $t('about.missionKicker') }}</p>
        <h2 class="mt-3 max-w-3xl font-heading text-3xl font-extrabold text-heading md:text-4xl">
          {{ $t('about.missionTitle') }}
        </h2>
        <p class="mt-4 max-w-3xl text-lg leading-relaxed text-text-muted">
          {{ $t('about.missionText') }}
        </p>
      </AppContainer>
    </section>

    <!-- Ciljevi -->
    <section class="py-4 pb-12 md:pb-16">
      <AppContainer>
        <h2 class="font-heading text-2xl font-bold text-heading">{{ $t('about.goalsTitle') }}</h2>
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
        <h2 class="font-heading text-2xl font-bold text-heading">{{ $t('about.audienceTitle') }}</h2>
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
        <h2 class="font-heading text-2xl font-bold text-heading">{{ $t('about.partnersTitle') }}</h2>
        <p class="mt-3 max-w-3xl text-text-muted">
          {{ $t('about.partnersText') }}
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
          :kicker="$t('common.related')"
          :title="$t('about.relatedTitle')"
          back-to="/"
          :back-label="$t('about.backHome')"
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
        :title="$t('about.ctaTitle')"
        :text="$t('about.ctaText')"
      >
        <BaseButton variant="sekundarna" to="/pridruzi-se">{{ $t('action.join') }}</BaseButton>
      </CTASection>
    </AppContainer>
  </main>
</template>
