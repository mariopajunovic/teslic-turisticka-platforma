<script setup>
import { computed } from 'vue'
import AppContainer from '@/components/layout/AppContainer.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import DetailGallery from '@/components/common/DetailGallery.vue'
import DetailHero from '@/components/common/DetailHero.vue'
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
const heroMeta = computed(() => (vijest.value?.datum ? [{ icon: 'calendar', text: vijest.value.datum }] : []))
</script>

<template>
  <AppContainer as="main" class="py-8">
    <EmptyState v-if="!vijest" :title="$t('news.notFoundTitle')" :text="$t('news.notFoundText')">
      <BaseButton variant="secondary" icon="arrow-left" :to="nazad.url || '/vijesti'">{{ $t('news.back') }}</BaseButton>
    </EmptyState>

    <template v-else>
      <Breadcrumb
        :items="[
          { label: $t('common.home'), to: '/' },
          { label: nazad.label || $t('news.title'), to: nazad.url || '/vijesti' },
          { label: vijest.naslov },
        ]"
      />

      <DetailGallery class="mt-5" :slika="vijest.slika" :galerija="vijest.galerija" :naslov="vijest.naslov" />

      <DetailHero :naslov="vijest.naslov" :opis="vijest.izvod" :meta="heroMeta" />

      <div class="mt-8 max-w-3xl">
        <div class="rtf" v-html="vijest.sadrzaj" />
      </div>

      <RelatedContent v-if="slicne.length" :title="$t('news.related')">
        <NewsCard v-for="v in slicne" :key="v.slug" :item="v" />
      </RelatedContent>
    </template>
  </AppContainer>
</template>
