<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppContainer from '@/components/layout/AppContainer.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import BaseChip from '@/components/base/BaseChip.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import MapInteractive from '@/components/map/MapInteractive.vue'
import MapFilterPanel from '@/components/map/MapFilterPanel.vue'
import MapPopup from '@/components/map/MapPopup.vue'
import Pagination from '@/components/common/Pagination.vue'
import { categoryColor } from '@/components/map/markerIcon'
import { useCategories } from '@/composables/useCategories'

const props = defineProps({
  tacke: { type: Array, default: () => [] },
  naslov: { type: String, default: '' },
})

const { categoryByKey } = useCategories()
const catOf = (t) => categoryByKey[t.kategorija] || null

const dostupneKljucevi = computed(() => [
  ...new Set((props.tacke || []).map((t) => t.kategorija).filter(Boolean)),
])

const aktivne = ref([])
const upit = ref('')
const fokusSlug = ref('')
const odabrana = ref(null)
const naseljaList = ref([])
const odabranoNaselje = ref('')

const filtrirano = computed(() => {
  let lista = props.tacke
  if (aktivne.value.length) lista = lista.filter((t) => aktivne.value.includes(t.kategorija))
  if (upit.value.trim()) {
    const q = upit.value.trim().toLowerCase()
    lista = lista.filter(
      (t) => t.naslov?.toLowerCase().includes(q) || t.lokacija?.toLowerCase().includes(q),
    )
  }
  return lista
})

const poStrani = 15
const stranica = ref(1)
const ukupnoStranica = computed(() => Math.max(1, Math.ceil(filtrirano.value.length / poStrani)))
const prikazane = computed(() =>
  filtrirano.value.slice((stranica.value - 1) * poStrani, stranica.value * poStrani),
)

watch(filtrirano, () => {
  stranica.value = 1
})

function odaberi(item) {
  odabrana.value = item
}

onMounted(() => {
  const params = new URLSearchParams(window.location.search)
  const q = params.get('q')
  if (q) upit.value = q
  const tacka = params.get('tacka')
  if (tacka) fokusSlug.value = tacka
})
</script>

<template>
  <div>
    <AppContainer>
      <div class="grid gap-6 lg:grid-cols-[320px_1fr]">
        <MapFilterPanel
          v-model="aktivne"
          v-model:naselje="odabranoNaselje"
          :naselja="naseljaList"
          :available-keys="dostupneKljucevi"
          @search="(v) => (upit = v)"
        />

        <div class="relative">
          <MapInteractive
            :items="filtrirano"
            :active-categories="aktivne"
            :selected-naselje="odabranoNaselje"
            :focus-slug="fokusSlug"
            height="640px"
            @select="odaberi"
            @naselja="naseljaList = $event"
          />
          <div v-if="odabrana" class="absolute right-4 top-4 z-30">
            <MapPopup :item="odabrana" @close="odabrana = null" />
          </div>
        </div>
      </div>
    </AppContainer>

    <AppContainer class="mt-12">
      <div class="flex flex-wrap items-end justify-between gap-3">
        <h2 class="font-heading text-2xl font-bold text-heading">{{ naslov || $t('map.offerOnMap') }}</h2>
        <span class="text-text-muted">{{ $t('map.results', { n: filtrirano.length }) }}</span>
      </div>

      <EmptyState
        v-if="!filtrirano.length"
        icon="map-pin"
        class="mt-6"
        :title="$t('common.noResults')"
        :text="$t('map.emptyText')"
      />

      <div v-else class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <Link
          v-for="t in prikazane"
          :key="t.slug"
          :href="t.to"
          class="group flex flex-col overflow-hidden rounded-md border border-border bg-surface shadow-[var(--shadow-sm)] transition-shadow hover:shadow-[var(--shadow-md)]"
        >
          <div class="relative h-40 overflow-hidden">
            <img
              v-if="t.slika"
              :src="t.slika"
              :alt="t.naslov"
              loading="lazy"
              class="size-full object-cover transition-transform duration-300 group-hover:scale-105"
            />
            <div v-else class="flex size-full items-center justify-center bg-primary-tint text-primary-tint-2">
              <BaseIcon name="image" :size="36" />
            </div>
          </div>
          <div class="flex flex-1 flex-col gap-2 p-4">
            <div>
              <BaseChip v-if="catOf(t)" variant="kategorija" :label="catOf(t).label" :icon="catOf(t).icon" />
            </div>
            <h3 class="line-clamp-2 font-semibold leading-snug text-heading">{{ t.naslov }}</h3>
            <div v-if="t.lokacija" class="mt-auto flex items-center gap-1.5 pt-1 text-[13px] text-text-muted">
              <BaseIcon name="map-pin" :size="15" />
              <span class="truncate">{{ t.lokacija }}</span>
            </div>
          </div>
        </Link>
      </div>

      <div v-if="ukupnoStranica > 1" class="mt-8 flex justify-center">
        <Pagination v-model="stranica" :total="ukupnoStranica" />
      </div>
    </AppContainer>
  </div>
</template>
