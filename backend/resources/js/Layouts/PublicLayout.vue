<script setup>
import AppHeader from '@/components/layout/AppHeader.vue'
import AppFooter from '@/components/layout/AppFooter.vue'
import CookieBanner from '@/components/layout/CookieBanner.vue'
</script>

<template>
  <div class="flex min-h-screen flex-col bg-surface">
    <AppHeader />
    <main class="flex-1">
      <slot />
    </main>
    <AppFooter />
    <CookieBanner />
  </div>
</template>
