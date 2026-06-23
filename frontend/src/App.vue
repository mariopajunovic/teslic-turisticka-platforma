<script setup>
import { computed } from 'vue'
import { RouterView, useRoute } from 'vue-router'
import { useGateStore } from '@/stores/gate'
import AppHeader from '@/components/layout/AppHeader.vue'
import AppFooter from '@/components/layout/AppFooter.vue'
import CookieBanner from '@/components/layout/CookieBanner.vue'
import SiteGate from '@/components/SiteGate.vue'

const route = useRoute()
const gate = useGateStore()
// Nalog/dashboard rute imaju vlastitu ljusku (AccountLayout) — bez javnog headera/footera.
const isAccount = computed(() => route.meta.layout === 'account')
</script>

<template>
  <!-- Privremena zaštita: ništa se ne prikazuje dok se ne unese šifra -->
  <SiteGate v-if="!gate.unlocked" />

  <template v-else>
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
</template>
