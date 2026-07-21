<script setup>
// Ljuska naloga: glavni javni Header/Footer + account sidebar/tabovi u sredini.
import { usePage, Link } from '@inertiajs/vue3'
import AppHeader from '@/components/layout/AppHeader.vue'
import AppFooter from '@/components/layout/AppFooter.vue'
import CookieBanner from '@/components/layout/CookieBanner.vue'
import Seo from '@/components/common/Seo.vue'
import AccountSidebar from '@/components/account/AccountSidebar.vue'

const page = usePage()

defineProps({
  items: { type: Array, required: true },
  heading: { type: String, default: 'MOJ NALOG' },
  initials: { type: String, default: '' },
})
</script>

<template>
  <div class="flex min-h-screen flex-col bg-surface">
    <Seo :seo="page.props.seo || {}" />
    <AppHeader />

    <!-- Mobilni account tabovi -->
    <nav class="border-b border-border bg-surface lg:hidden">
      <div class="mx-auto flex w-full max-w-[var(--container-content)] gap-2 overflow-x-auto px-4 py-3">
        <Link
          v-for="it in items"
          :key="it.to"
          :href="it.to"
          class="shrink-0 rounded-pill px-3.5 py-2 text-[13px] font-medium transition-colors"
          :class="page.url === it.to ? 'bg-primary text-white' : 'bg-surface-alt text-text-muted'"
        >
          {{ $t(it.label) }}
        </Link>
      </div>
    </nav>

    <!-- Body: sidebar + sadržaj, centrirano na širinu glavnog sajta -->
    <div class="mx-auto flex w-full max-w-[var(--container-content)] flex-1 gap-8 px-4 py-6 md:px-6 md:py-8">
      <div class="hidden lg:block">
        <AccountSidebar :items="items" :heading="heading" />
      </div>
      <main class="min-w-0 flex-1">
        <slot />
      </main>
    </div>

    <AppFooter />
    <CookieBanner />
  </div>
</template>
