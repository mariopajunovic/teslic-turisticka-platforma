<script setup>
import { ref, onMounted, onUnmounted, watch, nextTick } from 'vue'
import { useRouter, RouterLink } from 'vue-router'
import { mainNav } from '@/constants/navigation'
import AppContainer from './AppContainer.vue'
import NavDropdown from './NavDropdown.vue'
import MobileDrawer from './MobileDrawer.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import BaseButton from '@/components/base/BaseButton.vue'

const router = useRouter()
const scrolled = ref(false)
const drawerOpen = ref(false)
const searchOpen = ref(false)
const searchTerm = ref('')
const searchInput = ref(null)

const onScroll = () => (scrolled.value = window.scrollY > 8)
const onKey = (e) => {
  if (e.key === 'Escape') searchOpen.value = false
}

onMounted(() => {
  window.addEventListener('scroll', onScroll, { passive: true })
  window.addEventListener('keydown', onKey)
  onScroll()
})
onUnmounted(() => {
  window.removeEventListener('scroll', onScroll)
  window.removeEventListener('keydown', onKey)
})

watch(searchOpen, async (v) => {
  if (v) {
    await nextTick()
    searchInput.value?.focus()
  }
})

// Globalna pretraga (privremeno) — pravi overlay s rezultatima u F5.
function submitSearch() {
  const q = searchTerm.value.trim()
  searchOpen.value = false
  if (q) router.push({ path: '/mapa', query: { q } })
}
</script>

<template>
  <header
    class="sticky top-0 z-40 border-b border-border bg-surface/95 backdrop-blur transition-shadow"
    :class="scrolled ? 'shadow-[var(--shadow-sm)]' : ''"
  >
    <AppContainer
      class="flex items-center gap-6 transition-[height] duration-200"
      :class="scrolled ? 'h-14 lg:h-16' : 'h-14 lg:h-18'"
    >
      <RouterLink
        to="/"
        class="shrink-0 text-xl font-extrabold tracking-tight text-primary lg:text-2xl"
      >
        teslić
      </RouterLink>

      <!-- Desktop navigacija -->
      <nav class="hidden flex-wrap items-center gap-x-5 gap-y-1 lg:flex">
        <template v-for="item in mainNav" :key="item.to">
          <NavDropdown v-if="item.children" :item="item" />
          <RouterLink
            v-else
            :to="item.to"
            class="text-sm font-medium text-text transition-colors hover:text-primary"
            active-class="text-primary"
          >
            {{ item.label }}
          </RouterLink>
        </template>
      </nav>

      <div class="ml-auto flex items-center gap-2">
        <button
          type="button"
          class="inline-flex size-10 items-center justify-center rounded-sm text-heading hover:bg-surface-alt"
          aria-label="Pretraga"
          @click="searchOpen = !searchOpen"
        >
          <BaseIcon name="search" :size="20" />
        </button>

        <!-- Desktop akcije (wrapper kontroliše vidljivost; BaseButton ima vlastiti inline-flex) -->
        <div class="hidden items-center gap-2 lg:flex">
          <BaseButton href="#" variant="ghost" size="sm">Prijava</BaseButton>
          <BaseButton to="/pridruzi-se" variant="primary" size="sm">Pridruži se</BaseButton>
        </div>

        <!-- Mobilni hamburger -->
        <button
          type="button"
          class="inline-flex size-10 items-center justify-center rounded-sm text-heading hover:bg-surface-alt lg:hidden"
          aria-label="Otvori meni"
          @click="drawerOpen = true"
        >
          <BaseIcon name="menu" :size="22" />
        </button>
      </div>
    </AppContainer>

    <!-- Pretraga overlay (privremeno; rezultati u F5) -->
    <Transition name="search">
      <div v-if="searchOpen" class="border-t border-border bg-surface">
        <AppContainer class="py-3">
          <form class="flex items-center gap-2" @submit.prevent="submitSearch">
            <div class="relative flex-1">
              <BaseIcon
                name="search"
                :size="18"
                class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-text-muted"
              />
              <input
                ref="searchInput"
                v-model="searchTerm"
                type="search"
                placeholder="Pretraži ponudu, lokalitete, događaje…"
                class="h-11 w-full rounded-sm border border-border bg-surface pl-10 pr-4 outline-none focus:border-primary"
              />
            </div>
            <BaseButton type="submit" variant="primary">Traži</BaseButton>
          </form>
        </AppContainer>
      </div>
    </Transition>

    <MobileDrawer v-model="drawerOpen" />
  </header>
</template>

<style scoped>
.search-enter-active,
.search-leave-active {
  transition: all 0.2s ease;
}
.search-enter-from,
.search-leave-to {
  opacity: 0;
  transform: translateY(-8px);
}
</style>
