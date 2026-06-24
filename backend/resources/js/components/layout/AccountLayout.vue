<script setup>
// Ljuska naloga (1:1 13_Moj-profil): Topbar + (Sidebar | mobilni tabovi) + sadržaj.
// Ne koristi javni Header/Footer.
import { Link, usePage } from '@inertiajs/vue3'
import AccountSidebar from '@/components/account/AccountSidebar.vue'
import BaseButton from '@/components/base/BaseButton.vue'

const page = usePage()

defineProps({
  items: { type: Array, required: true },
  heading: { type: String, default: 'MOJ NALOG' },
  initials: { type: String, default: 'PĐ' },
})
</script>

<template>
  <div class="flex min-h-screen flex-col bg-surface-alt">
    <!-- Topbar -->
    <header class="flex items-center gap-4 border-b border-border bg-surface px-4 py-3.5 md:px-8">
      <Link href="/" class="text-2xl font-extrabold tracking-tight text-primary">teslić</Link>
      <span class="hidden text-[15px] font-medium text-text-muted sm:inline">Moj nalog</span>
      <div class="ml-auto flex items-center gap-3">
        <span
          class="flex size-9 items-center justify-center rounded-full bg-primary-tint text-[13px] font-bold text-primary"
        >
          {{ initials }}
        </span>
        <BaseButton href="#" variant="ghost" size="sm" icon="log-out">Odjava</BaseButton>
      </div>
    </header>

    <!-- Mobilni tabovi (pilule) -->
    <nav class="flex gap-2 overflow-x-auto border-b border-border bg-surface px-4 py-3 lg:hidden">
      <Link
        v-for="it in items"
        :key="it.to"
        :href="it.to"
        class="shrink-0 rounded-pill px-3.5 py-2 text-[13px] font-medium transition-colors"
        :class="page.url === it.to ? 'bg-primary text-white' : 'bg-surface-alt text-text-muted'"
      >
        {{ it.label }}
      </Link>
    </nav>

    <!-- Body -->
    <div class="flex flex-1 gap-8 px-4 py-6 md:px-8 md:py-8">
      <div class="hidden lg:block">
        <AccountSidebar :items="items" :heading="heading" />
      </div>
      <main class="min-w-0 flex-1">
        <slot />
      </main>
    </div>
  </div>
</template>
