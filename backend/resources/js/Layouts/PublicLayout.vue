<script setup>
import { usePage } from '@inertiajs/vue3'
import AppHeader from '@/components/layout/AppHeader.vue'
import AppFooter from '@/components/layout/AppFooter.vue'
import CookieBanner from '@/components/layout/CookieBanner.vue'
import Seo from '@/components/common/Seo.vue'

const page = usePage()
</script>

<template>
  <div class="flex min-h-screen flex-col bg-surface">
    <Seo :seo="page.props.seo || {}" />
    <AppHeader />
    <main class="flex-1">
      <slot />
    </main>
    <AppFooter />
    <CookieBanner />
  </div>
</template>
