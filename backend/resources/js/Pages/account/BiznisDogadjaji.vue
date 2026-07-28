<script setup>
import { useLocalePath } from '@/composables/useLocalePath'
const { localePath } = useLocalePath()
import { Link } from '@inertiajs/vue3'
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { biznisNav } from '@/constants/account'
import BaseButton from '@/components/base/BaseButton.vue'
import PostRow from '@/components/account/PostRow.vue'
import EmptyState from '@/components/common/EmptyState.vue'

defineProps({
  dogadjaji: { type: Array, default: () => [] },
})
</script>

<template>
  <AccountLayout :items="biznisNav">
    <div class="space-y-6">
      <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="font-heading text-[28px] font-bold text-heading">{{ $t('acc.events') }}</h1>
          <p class="mt-1 text-[15px] text-text-muted">{{ $t('acc.eventsDesc') }}</p>
        </div>
        <BaseButton :to="localePath('/nalog/biznis/dogadjaji/novi')" variant="primary" icon="plus">{{ $t('acc.newEvent') }}</BaseButton>
      </div>

      <div v-if="dogadjaji.length" class="space-y-3">
        <Link v-for="d in dogadjaji" :key="d.id" :href="d.editUrl" class="block">
          <PostRow :item="d" />
        </Link>
      </div>

      <EmptyState v-else :title="$t('acc.noEvents')" :text="$t('acc.noEventsText')" />
    </div>
  </AccountLayout>
</template>
