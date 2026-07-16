<script setup>
import { Link } from '@inertiajs/vue3'
import { useConsentStore } from '@/stores/consent'
import BaseButton from '@/components/base/BaseButton.vue'

const consent = useConsentStore()
</script>

<template>
  <Transition name="slide-up">
    <div
      v-if="!consent.accepted"
      class="fixed inset-x-0 bottom-0 z-50 p-3 md:p-4"
      role="region"
      :aria-label="$t('misc.cookieConsent')"
    >
      <div
        class="mx-auto flex max-w-3xl flex-col items-center gap-3 rounded-md border border-border bg-surface px-5 py-4 shadow-[var(--shadow-lg)] sm:flex-row"
      >
        <p class="text-sm leading-snug text-text">
          {{ $t('misc.cookieText') }}
        </p>
        <div class="flex shrink-0 items-center gap-2">
          <Link
            href="/politika-kolacica"
            class="px-2 text-sm font-semibold text-primary hover:underline"
          >
            {{ $t('misc.learnMore') }}
          </Link>
          <BaseButton variant="primary" size="sm" @click="consent.accept">{{ $t('misc.accept') }}</BaseButton>
        </div>
      </div>
    </div>
  </Transition>
</template>

<style scoped>
.slide-up-enter-active,
.slide-up-leave-active {
  transition: all 0.25s ease;
}
.slide-up-enter-from,
.slide-up-leave-to {
  opacity: 0;
  transform: translateY(1rem);
}
</style>
