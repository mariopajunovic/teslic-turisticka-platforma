<script setup>
import { useLocalePath } from '@/composables/useLocalePath'
const { localePath } = useLocalePath()
import { router } from '@inertiajs/vue3'
import AppContainer from '@/components/layout/AppContainer.vue'
import Hero from '@/components/common/Hero.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import CardGrid from '@/components/layout/CardGrid.vue'
import Pagination from '@/components/common/Pagination.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import NewsCard from '@/components/cards/NewsCard.vue'

const props = defineProps({
  vijesti: { type: Object, default: () => ({ data: [], meta: { current_page: 1, last_page: 1 } }) },
})

const HERO = 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=1600&q=80'

function goPage(page) {
  router.get('/vijesti', page > 1 ? { page } : {}, { preserveScroll: true, replace: true })
}
</script>

<template>
  <main class="pb-12 md:pb-16">
    <Hero kicker="Aktuelno" :title="$t('news.title')" :subtitle="$t('news.subtitle')" :image="HERO" />

    <AppContainer class="pt-6">
      <Breadcrumb :items="[{ label: $t('common.home'), to: localePath('/') }, { label: $t('news.title') }]" />
    </AppContainer>

    <AppContainer class="mt-8">
      <EmptyState v-if="!vijesti.data.length" :title="$t('news.emptyTitle')" :text="$t('news.emptyText')" />

      <template v-else>
        <CardGrid :cols="3">
          <NewsCard v-for="v in vijesti.data" :key="v.slug" :item="v" />
        </CardGrid>

        <div v-if="vijesti.meta && vijesti.meta.last_page > 1" class="mt-10 flex justify-center">
          <Pagination :model-value="vijesti.meta.current_page" :total="vijesti.meta.last_page" @update:model-value="goPage" />
        </div>
      </template>
    </AppContainer>
  </main>
</template>
