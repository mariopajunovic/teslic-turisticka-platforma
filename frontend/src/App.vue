<script setup>
import { computed } from 'vue'
import { RouterView, useRoute } from 'vue-router'
import AppHeader from '@/components/layout/AppHeader.vue'
import AppFooter from '@/components/layout/AppFooter.vue'
import CookieBanner from '@/components/layout/CookieBanner.vue'

const route = useRoute()
// Nalog/dashboard rute imaju vlastitu ljusku (AccountLayout) — bez javnog headera/footera.
const isAccount = computed(() => route.meta.layout === 'account')
</script>

<template>
  <RouterView v-if="isAccount" />
  <div v-else class="flex min-h-screen flex-col bg-surface">
    <AppHeader />
    <main class="flex-1">
      <RouterView />
    </main>
    <AppFooter />
    <CookieBanner />
  </div>
</template>
