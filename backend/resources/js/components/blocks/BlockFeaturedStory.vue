<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppContainer from '@/components/layout/AppContainer.vue'
import SectionHeader from '@/components/common/SectionHeader.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const props = defineProps({
  data: { type: Object, default: () => ({}) },
})

const prica = computed(() => props.data.item || null)
</script>

<template>
  <AppContainer class="space-y-6">
    <SectionHeader v-if="data.naslov" :title="data.naslov" />
    <Link
      v-if="prica"
      :href="`/price/${prica.slug}`"
      class="group grid overflow-hidden rounded-2xl border border-border bg-surface md:grid-cols-2"
    >
      <div class="relative min-h-[240px] bg-primary-darker">
        <img
          v-if="prica.slika"
          :src="prica.slika"
          :alt="prica.naslov"
          class="absolute inset-0 size-full object-cover"
        />
      </div>
      <div class="flex flex-col justify-center gap-3 p-6 md:p-10">
        <span
          v-if="prica.kategorija"
          class="inline-flex w-fit items-center gap-1.5 rounded-full bg-primary-tint px-3 py-1 text-xs font-semibold text-primary"
        >
          <BaseIcon :name="prica.kategorija.icon || 'book-open'" :size="14" />
          {{ prica.kategorija.label }}
        </span>
        <h3 class="font-heading text-2xl font-bold text-heading group-hover:text-primary md:text-3xl">
          {{ prica.naslov }}
        </h3>
        <p v-if="prica.izvod" class="text-text-muted">{{ prica.izvod }}</p>
        <p v-if="prica.autor" class="text-sm font-medium text-text-muted">
          {{ prica.autor }} · {{ prica.datum }}
        </p>
      </div>
    </Link>
    <EmptyState v-else title="Nema izdvojene priče" text="Trenutno nema priče za prikaz." />
  </AppContainer>
</template>
