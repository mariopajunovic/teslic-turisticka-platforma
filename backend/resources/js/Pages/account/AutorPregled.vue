<script setup>
import { useLocalePath } from '@/composables/useLocalePath'
const { localePath } = useLocalePath()
import { Link } from '@inertiajs/vue3'
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { autorNav } from '@/constants/account'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const props = defineProps({
  korisnik: { type: String, default: '' },
  stats: { type: Object, default: () => ({}) },
  odbijeni: { type: Array, default: () => [] },
})

const kartice = [
  { key: 'objavljeno', labelKey: 'acc.statPublished', icon: 'circle-check', color: 'text-primary' },
  { key: 'naCekanju', labelKey: 'acc.statPending', icon: 'hourglass', color: 'text-[#8C5810]' },
  { key: 'nacrt', labelKey: 'acc.statDraft', icon: 'pen', color: 'text-text-muted' },
  { key: 'odbijeno', labelKey: 'acc.statRejected', icon: 'circle-alert', color: 'text-[#C62828]' },
]
</script>

<template>
  <AccountLayout :items="autorNav">
    <div class="space-y-6">
      <div>
        <h1 class="font-heading text-[28px] font-bold text-heading">
          {{ $t('acc.overviewGreeting', { ime: korisnik }) }}
        </h1>
        <p class="mt-1 text-[15px] text-text-muted">{{ $t('acc.overviewDesc') }}</p>
      </div>

      <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <div v-for="k in kartice" :key="k.key" class="rounded-md border border-border bg-surface p-5">
          <div class="flex items-center gap-2">
            <BaseIcon :name="k.icon" :size="18" :class="k.color" />
            <span class="text-[13px] font-medium text-text-muted">{{ $t(k.labelKey) }}</span>
          </div>
          <div class="mt-2 font-heading text-[32px] font-bold leading-none text-heading">
            {{ stats[k.key] ?? 0 }}
          </div>
        </div>
      </div>

      <div v-if="odbijeni.length" class="space-y-3 rounded-md border border-[#C62828]/30 bg-[#C62828]/5 p-5 md:p-6">
        <div class="flex items-center gap-2">
          <BaseIcon name="circle-alert" :size="18" class="text-[#C62828]" />
          <h2 class="font-heading text-lg font-bold text-heading">{{ $t('acc.rejectedTitle') }}</h2>
        </div>
        <div
          v-for="(o, i) in odbijeni"
          :key="i"
          class="flex flex-col gap-2 rounded-sm border border-border bg-surface p-4 sm:flex-row sm:items-center sm:justify-between"
        >
          <div class="min-w-0">
            <p class="font-semibold text-heading">{{ o.naslov }}</p>
            <p v-if="o.razlog" class="mt-0.5 text-[13px] text-text-muted">{{ o.razlog }}</p>
          </div>
          <BaseButton :to="o.editUrl" variant="secondary" size="sm" icon="pen" class="shrink-0">
            {{ $t('acc.rejectedFix') }}
          </BaseButton>
        </div>
      </div>

      <div class="rounded-md border border-border bg-surface p-5 md:p-6">
        <h2 class="mb-4 font-heading text-lg font-bold text-heading">{{ $t('acc.quickActions') }}</h2>
        <div class="flex flex-wrap gap-3">
          <BaseButton :to="localePath('/nalog/autor/nova-prica')" variant="primary" icon="plus">{{ $t('acc.newStory') }}</BaseButton>
          <BaseButton :to="localePath('/nalog/autor/price')" variant="secondary" icon="file-text">{{ $t('acc.navStories') }}</BaseButton>
          <BaseButton :to="localePath('/nalog/autor/postavke')" variant="secondary" icon="settings">{{ $t('acc.navSettings') }}</BaseButton>
        </div>
      </div>
    </div>
  </AccountLayout>
</template>
