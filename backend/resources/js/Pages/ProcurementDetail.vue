<script setup>
import { computed } from 'vue'
import AppContainer from '@/components/layout/AppContainer.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import Hero from '@/components/common/Hero.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const props = defineProps({
  slug: { type: String, default: '' },
  nabavka: { type: Object, default: null },
  nazad: { type: Object, default: () => ({ url: '/javne-nabavke', label: 'Javne nabavke' }) },
})

const nabavka = computed(() => props.nabavka)
const podnaslov = computed(() => {
  const n = nabavka.value
  if (!n) return ''
  return [n.godina ? `Godina ${n.godina}` : '', n.datum].filter(Boolean).join(' · ')
})
</script>

<template>
  <AppContainer as="main" class="py-8">
    <EmptyState v-if="!nabavka" :title="$t('proc.notFoundTitle')" :text="$t('proc.notFoundText')">
      <BaseButton variant="secondary" icon="arrow-left" :to="nazad.url || '/javne-nabavke'">{{ $t('proc.back') }}</BaseButton>
    </EmptyState>

    <template v-else>
      <Breadcrumb
        :items="[
          { label: $t('common.home'), to: '/' },
          { label: nazad.label || $t('proc.title'), to: nazad.url || '/javne-nabavke' },
          { label: nabavka.naslov },
        ]"
      />

      <Hero
        variant="slika-pozadina"
        :contained="false"
        :kicker="nazad.label || $t('proc.title')"
        :title="nabavka.naslov"
        :subtitle="podnaslov"
        class="mt-6"
      />

      <div class="mt-10 grid gap-10 lg:grid-cols-3">
        <div class="lg:col-span-2">
          <div v-if="nabavka.opis" class="rtf" v-html="nabavka.opis" />
        </div>

        <div class="space-y-4 lg:sticky lg:top-6 lg:self-start">
          <div class="rounded-lg border border-border bg-surface p-5">
            <h2 class="mb-3 font-heading text-lg font-bold text-heading">{{ $t('proc.documents') }}</h2>
            <div v-if="nabavka.dokumenti.length" class="space-y-2">
              <a
                v-for="d in nabavka.dokumenti"
                :key="d.url"
                :href="d.url"
                target="_blank"
                rel="noopener"
                class="group flex items-center gap-3 rounded-md border border-border px-3 py-2.5 transition-colors hover:border-primary hover:bg-primary-tint"
              >
                <span class="flex size-9 shrink-0 items-center justify-center rounded-md bg-primary-tint text-primary group-hover:bg-white">
                  <BaseIcon name="file-text" :size="18" />
                </span>
                <span class="min-w-0 flex-1">
                  <span class="block truncate text-sm font-semibold text-heading">{{ d.naziv }}</span>
                  <span class="text-xs text-text-muted">{{ d.velicina }}</span>
                </span>
                <BaseIcon name="upload" :size="16" class="shrink-0 rotate-180 text-primary" />
              </a>
            </div>
            <p v-else class="text-sm text-text-muted">{{ $t('proc.noDocuments') }}</p>
          </div>
        </div>
      </div>
    </template>
  </AppContainer>
</template>
