<script setup>
import { ref, computed, onMounted, onUnmounted, watch, nextTick } from 'vue'
import { Link, router as inertiaRouter, usePage } from '@inertiajs/vue3'
import { useSite } from '@/composables/useSite'
import AppContainer from './AppContainer.vue'
import NavDropdown from './NavDropdown.vue'
import MobileDrawer from './MobileDrawer.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import BaseButton from '@/components/base/BaseButton.vue'

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

function submitSearch() {
  const q = searchTerm.value.trim()
  searchOpen.value = false
  if (q) inertiaRouter.visit(`/mapa?q=${encodeURIComponent(q)}`)
}

const { mainNav, kontakt, postavke } = useSite()

const page = usePage()
const authUser = computed(() => page.props.auth?.user)
const nalogLink = computed(() =>
  authUser.value?.role === 'autor' ? '/nalog/autor/price' : '/nalog/biznis/profil',
)

function logout() {
  inertiaRouter.post('/logout')
}
</script>

<template>
  <header
    class="sticky top-0 z-40 bg-surface transition-shadow"
    :class="scrolled ? 'shadow-[var(--shadow-sm)]' : ''"
  >
    <!-- Gornja (util) traka — brend -->
    <div class="bg-primary-darker text-primary-tint">
      <AppContainer class="flex h-10 items-center justify-between text-[13px]">
        <!-- Lijevo: kontakt + sekundarni linkovi -->
        <div class="flex items-center gap-5">
          <a :href="`tel:${kontakt.telefon}`" class="flex items-center gap-1.5 hover:text-white">
            <BaseIcon name="phone" :size="14" />
            <span>{{ kontakt.telefon }}</span>
          </a>
          <a
            :href="`mailto:${kontakt.email}`"
            class="hidden items-center gap-1.5 hover:text-white sm:flex"
          >
            <BaseIcon name="mail" :size="14" />
            <span>{{ kontakt.email }}</span>
          </a>
        </div>

        <!-- Desno: jezik + mreže + akcije -->
        <div class="flex items-center gap-4">
          <div class="flex items-center gap-1.5">
            <BaseIcon name="globe" :size="14" class="text-white" />
            <button type="button" class="font-bold text-white" aria-label="Srpski jezik">SR</button>
            <span class="text-primary-tint-2">|</span>
            <button type="button" class="hover:text-white" aria-label="English language">EN</button>
          </div>
          <div class="hidden items-center gap-3 sm:flex">
            <a
              v-for="s in postavke.social || []"
              :key="s.name"
              :href="s.href"
              target="_blank"
              rel="noopener"
              :aria-label="s.label"
              class="hover:text-white"
            >
              <BaseIcon :name="s.name" :size="15" />
            </a>
          </div>
          <div class="hidden items-center gap-3 lg:flex">
            <template v-if="authUser">
              <Link :href="nalogLink" class="font-semibold text-white hover:text-primary-tint">
                {{ authUser.name }}
              </Link>
              <button
                type="button"
                class="inline-flex items-center rounded-sm bg-secondary px-3 py-1 text-[13px] font-bold text-heading transition-colors hover:bg-secondary-dark"
                @click="logout"
              >
                Odjava
              </button>
            </template>
            <template v-else>
              <Link href="/prijava" class="font-semibold text-white hover:text-primary-tint">
                Prijava
              </Link>
              <Link
                href="/pridruzi-se"
                class="inline-flex items-center rounded-sm bg-secondary px-3 py-1 text-[13px] font-bold text-heading transition-colors hover:bg-secondary-dark"
              >
                Pridruži se
              </Link>
            </template>
          </div>
        </div>
      </AppContainer>
    </div>

    <!-- Glavna traka -->
    <div class="border-b border-border bg-surface">
      <AppContainer
        class="flex items-center gap-6 transition-[height] duration-200"
        :class="scrolled ? 'h-14 lg:h-16' : 'h-16 lg:h-[72px]'"
      >
        <Link
          href="/"
          class="shrink-0 text-xl font-extrabold tracking-tight text-primary lg:text-2xl"
          :aria-label="`Početna — ${postavke.brandLogoTekst}`"
        >
          {{ postavke.brandLogoTekst }}
        </Link>

        <!-- Desktop navigacija (rasterećena, 6 sadržajnih stavki) -->
        <nav class="ml-6 hidden items-center gap-x-6 lg:flex">
          <template v-for="item in mainNav" :key="item.to">
            <NavDropdown v-if="item.children" :item="item" />
            <Link
              v-else
              :href="item.to"
              class="text-[15px] font-medium text-text transition-colors hover:text-primary"
            >
              {{ item.label }}
            </Link>
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
    </div>

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
