<script setup>
import { useLocalePath } from '@/composables/useLocalePath'
const { localePath } = useLocalePath()
import { computed } from 'vue'
import AppContainer from '@/components/layout/AppContainer.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import Hero from '@/components/common/Hero.vue'
import Gallery from '@/components/common/Gallery.vue'
import RelatedContent from '@/components/common/RelatedContent.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import NewsCard from '@/components/cards/NewsCard.vue'

const props = defineProps({
  slug: { type: String, default: '' },
  vijest: { type: Object, default: null },
  slicne: { type: Array, default: () => [] },
  nazad: { type: Object, default: () => ({ url: '/vijesti', label: 'Vijesti' }) },
})

const vijest = computed(() => props.vijest)
const slicne = computed(() => props.slicne)
</script>

<template>
  <AppContainer as="main" class="py-8">
    <EmptyState v-if="!vijest" :title="$t('news.notFoundTitle')" :text="$t('news.notFoundText')">
      <BaseButton variant="secondary" icon="arrow-left" :to="nazad.url || '/vijesti'">{{ $t('news.back') }}</BaseButton>
    </EmptyState>

    <template v-else>
      <Breadcrumb
        :items="[
          { label: $t('common.home'), to: localePath('/') },
          { label: nazad.label || $t('news.title'), to: nazad.url || '/vijesti' },
          { label: vijest.naslov },
        ]"
      />

      <Hero
        variant="slika-pozadina"
        :contained="false"
        :kicker="vijest.datum"
        :title="vijest.naslov"
        :image="vijest.slika"
        class="mt-6"
      />

      <article class="mx-auto mt-10 max-w-2xl">
        <p v-if="vijest.izvod" class="mb-6 font-heading text-xl font-medium leading-relaxed text-heading">
          {{ vijest.izvod }}
        </p>
        <div class="rtf" v-html="vijest.sadrzaj" />
      </article>

      <section v-if="vijest.galerija?.length" class="mx-auto mt-10 max-w-2xl">
        <h2 class="mb-4 font-heading text-2xl font-bold text-heading">{{ $t('detail.gallery') }}</h2>
        <Gallery :items="vijest.galerija" />
      </section>

      <RelatedContent v-if="slicne.length" :title="$t('news.related')">
        <NewsCard v-for="v in slicne" :key="v.slug" :item="v" />
      </RelatedContent>
    </template>
  </AppContainer>
</template>
