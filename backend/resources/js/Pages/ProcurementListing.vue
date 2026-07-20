<script setup>
import { Link } from '@inertiajs/vue3'
import AppContainer from '@/components/layout/AppContainer.vue'
import Hero from '@/components/common/Hero.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const props = defineProps({
  godine: { type: Array, default: () => [] },
})

const HERO = 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1600&q=80'

const snippet = (html) => String(html || '').replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim().slice(0, 140)
</script>

<template>
  <main class="pb-12 md:pb-16">
    <Hero kicker="Transparentnost" :title="$t('proc.title')" :subtitle="$t('proc.subtitle')" :image="HERO" />

    <AppContainer class="pt-6">
      <Breadcrumb :items="[{ label: $t('common.home'), to: '/' }, { label: $t('proc.title') }]" />
    </AppContainer>

    <AppContainer class="mt-8">
      <EmptyState v-if="!godine.length" :title="$t('proc.emptyTitle')" :text="$t('proc.emptyText')" />

      <div v-else class="space-y-10">
        <section v-for="g in godine" :key="g.godina">
          <h2 class="mb-4 flex items-center gap-3 font-heading text-2xl font-bold text-heading">
            <span class="inline-flex items-center rounded-md bg-primary px-3 py-1 text-lg text-white">{{ g.godina || $t('proc.otherYear') }}</span>
          </h2>

          <div class="divide-y divide-border overflow-hidden rounded-lg border border-border">
            <Link
              v-for="n in g.stavke"
              :key="n.slug"
              :href="n.url"
              class="group flex items-center gap-4 px-5 py-4 transition-colors hover:bg-surface-alt"
            >
              <span class="flex size-10 shrink-0 items-center justify-center rounded-md bg-primary-tint text-primary">
                <BaseIcon name="file-text" :size="20" />
              </span>
              <div class="min-w-0 flex-1">
                <h3 class="truncate font-semibold text-heading group-hover:text-primary">{{ n.naslov }}</h3>
                <p v-if="snippet(n.opis)" class="mt-0.5 truncate text-sm text-text-muted">{{ snippet(n.opis) }}</p>
              </div>
              <span class="hidden shrink-0 items-center gap-1.5 text-xs font-medium text-text-muted sm:flex">
                <BaseIcon name="file-text" :size="14" /> {{ n.dokumenti.length }}
              </span>
              <BaseIcon name="chevron-right" :size="18" class="shrink-0 text-text-muted group-hover:text-primary" />
            </Link>
          </div>
        </section>
      </div>
    </AppContainer>
  </main>
</template>
