<script setup>
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppContainer from '@/components/layout/AppContainer.vue'
import Hero from '@/components/common/Hero.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import RelatedContent from '@/components/common/RelatedContent.vue'
import CTASection from '@/components/common/CTASection.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseChip from '@/components/base/BaseChip.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import BusinessCard from '@/components/cards/BusinessCard.vue'
import LocationCard from '@/components/cards/LocationCard.vue'
import EventCard from '@/components/cards/EventCard.vue'
import MapInteractive from '@/components/map/MapInteractive.vue'
import MapFilterPanel from '@/components/map/MapFilterPanel.vue'
import MapPopup from '@/components/map/MapPopup.vue'
import { categoryColor } from '@/components/map/markerIcon'
import { useCategories } from '@/composables/useCategories'

const props = defineProps({
  tacke: { type: Array, default: () => [] },
  povezani: { type: Object, default: () => ({ biznis: null, lokalitet: null, dogadjaj: null }) },
})

const { categoryByKey } = useCategories()
const catOf = (t) => categoryByKey[t.kategorija] || null

const dostupneKljucevi = computed(() => [
  ...new Set((props.tacke || []).map((t) => t.kategorija).filter(Boolean)),
])

const aktivne = ref([])
const upit = ref('')
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

function odaberi(item) {
  odabrana.value = item
}
</script>

<template>
  <main class="pb-12 md:pb-16">
    <Hero
      kicker="Mapa ponude"
      kicker-class="text-primary-tint-2"
      title="Cijeli Teslić na jednoj mapi"
      subtitle="Pretražite biznise, atrakcije, smještaj i događaje i lako se orijentišite u prostoru."
      image="https://images.unsplash.com/photo-1611458182018-c043f4e947ec?auto=format&fit=crop&w=1600&q=80"
    />

    <AppContainer class="pt-6">
      <Breadcrumb :items="[{ label: 'Početna', to: '/' }, { label: 'Mapa ponude' }]" />
    </AppContainer>

    <AppContainer class="mt-8">
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
            height="640px"
            @select="odaberi"
            @naselja="naseljaList = $event"
          />
          <div v-if="odabrana" class="absolute right-4 top-4 z-[1000]">
            <MapPopup :item="odabrana" @close="odabrana = null" />
          </div>
        </div>
      </div>
    </AppContainer>

    <!-- Ponuda na mapi -->
    <AppContainer class="mt-12">
      <div class="flex flex-wrap items-end justify-between gap-3">
        <h2 class="font-heading text-2xl font-bold text-heading">Ponuda na mapi</h2>
        <span class="text-text-muted">{{ filtrirano.length }} rezultata</span>
      </div>

      <EmptyState
        v-if="!filtrirano.length"
        icon="map-pin"
        class="mt-6"
        title="Nema rezultata"
        text="Za odabrane slojeve i pretragu nema tačaka na mapi."
      />

      <div v-else class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <Link
          v-for="t in filtrirano"
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
            <span
              v-else
              class="flex size-full items-center justify-center"
              :class="t.kategorija === 'dogadjaj' ? 'text-heading' : 'text-white'"
              :style="{ backgroundColor: categoryColor(t.kategorija) }"
            >
              <BaseIcon v-if="catOf(t)" :name="catOf(t).icon" :size="34" />
            </span>
          </div>
          <div class="flex flex-1 flex-col gap-2 p-4">
            <div>
              <BaseChip
                v-if="catOf(t)"
                variant="kategorija"
                :label="catOf(t).label"
                :icon="catOf(t).icon"
              />
            </div>
            <h3 class="line-clamp-2 font-semibold leading-snug text-heading">{{ t.naslov }}</h3>
            <div
              v-if="t.lokacija"
              class="mt-auto flex items-center gap-1.5 pt-1 text-[13px] text-text-muted"
            >
              <BaseIcon name="map-pin" :size="15" />
              <span class="truncate">{{ t.lokacija }}</span>
            </div>
          </div>
        </Link>
      </div>
    </AppContainer>

    <!-- Povezani sadržaj -->
    <section
      v-if="povezani.biznis || povezani.lokalitet || povezani.dogadjaj"
      class="mt-12 bg-surface-alt py-12 md:py-14"
    >
      <AppContainer>
        <RelatedContent
          kicker="Povezano"
          title="Sa mape direktno u ponudu"
          class="!mt-0"
          back-to="/"
          back-label="← Nazad na Početnu"
        >
          <BusinessCard v-if="povezani.biznis" :item="povezani.biznis" />
          <LocationCard v-if="povezani.lokalitet" :item="povezani.lokalitet" />
          <EventCard v-if="povezani.dogadjaj" :item="povezani.dogadjaj" />
        </RelatedContent>
      </AppContainer>
    </section>

    <AppContainer class="mt-12">
      <CTASection
        title="Želite da budete na mapi Teslića?"
        text="Registrujte biznis i pojavite se na interaktivnoj mapi ponude."
      >
        <BaseButton variant="sekundarna" to="/pridruzi-se/biznis">Registruj biznis</BaseButton>
      </CTASection>
    </AppContainer>
  </main>
</template>
