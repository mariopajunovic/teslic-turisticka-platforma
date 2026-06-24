<script setup>
import { ref, computed, watch } from 'vue'
import AppContainer from '@/components/layout/AppContainer.vue'
import CardGrid from '@/components/layout/CardGrid.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import SegmentControl from '@/components/common/SegmentControl.vue'
import FilterBar from '@/components/common/FilterBar.vue'
import SearchInput from '@/components/common/SearchInput.vue'
import FormSelect from '@/components/forms/FormSelect.vue'
import Pagination from '@/components/common/Pagination.vue'
import Skeleton from '@/components/common/Skeleton.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import AdCard from '@/components/cards/AdCard.vue'

const props = defineProps({
  oglasi: { type: Array, default: () => [] },
})

const data = computed(() => props.oglasi)
const loading = false
const error = null

const PO_STRANICI = 8
const upit = ref('')
const vrsta = ref('')
const status = ref('aktivni')
const stranica = ref(1)

const statusOpcije = [
  { value: 'aktivni', label: 'Aktivni' },
  { value: 'arhiva', label: 'Arhiva' },
]

// Vrste oglasa — izvedene iz labela u podacima.
const vrsteOpcije = computed(() => {
  const map = new Map()
  for (const o of data.value || []) {
    if (o.vrsta?.label) map.set(o.vrsta.label, o.vrsta.label)
  }
  return [...map.values()].map((label) => ({ value: label, label }))
})

const filtrirano = computed(() => {
  let lista = data.value || []
  lista = lista.filter((o) => (status.value === 'arhiva' ? o.isteklo : !o.isteklo))
  if (vrsta.value) lista = lista.filter((o) => o.vrsta?.label === vrsta.value)
  if (upit.value.trim()) {
    const q = upit.value.trim().toLowerCase()
    lista = lista.filter(
      (o) =>
        o.naslov?.toLowerCase().includes(q) ||
        o.izdavac?.toLowerCase().includes(q) ||
        o.lokacija?.toLowerCase().includes(q),
    )
  }
  return lista
})

const ukupnoStranica = computed(() => Math.max(1, Math.ceil(filtrirano.value.length / PO_STRANICI)))
const vidljivi = computed(() =>
  filtrirano.value.slice((stranica.value - 1) * PO_STRANICI, stranica.value * PO_STRANICI),
)

const aktivniChipovi = computed(() => {
  const chips = []
  if (vrsta.value) chips.push({ key: 'vrsta', label: vrsta.value })
  if (upit.value.trim()) chips.push({ key: 'upit', label: `„${upit.value.trim()}”` })
  return chips
})

watch([vrsta, upit, status], () => {
  stranica.value = 1
})

function ocisti() {
  vrsta.value = ''
  upit.value = ''
}

function ukloni(key) {
  if (key === 'vrsta') vrsta.value = ''
  if (key === 'upit') upit.value = ''
}
</script>

<template>
  <main class="pb-12 md:pb-16">
    <AppContainer class="pt-8">
      <Breadcrumb :items="[{ label: 'Početna', to: '/' }, { label: 'Oglasi' }]" />
    </AppContainer>

    <AppContainer class="mt-6">
      <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
          <h1 class="font-heading text-3xl font-bold text-heading md:text-4xl">
            Poslovne prilike i oglasi
          </h1>
          <p class="mt-2 max-w-2xl text-text-muted">
            Zapošljavanje, saradnja, usluge i konkursi iz Teslića i okoline.
          </p>
        </div>
        <SegmentControl v-model="status" :options="statusOpcije" />
      </div>
    </AppContainer>

    <AppContainer class="mt-6">
      <FilterBar :chips="aktivniChipovi" @clear="ocisti" @remove="ukloni">
        <FormSelect v-model="vrsta" :options="vrsteOpcije" placeholder="Sve vrste" />
        <SearchInput v-model="upit" placeholder="Pretraži oglase…" />
      </FilterBar>
    </AppContainer>

    <AppContainer class="mt-8">
      <BaseAlert
        v-if="error"
        variant="greska"
        title="Greška pri učitavanju"
        text="Trenutno nije moguće učitati oglase. Pokušajte ponovo kasnije."
      />

      <CardGrid v-else-if="loading" :cols="3">
        <Skeleton :count="8" />
      </CardGrid>

      <EmptyState
        v-else-if="!vidljivi.length"
        :title="status === 'arhiva' ? 'Nema arhiviranih oglasa' : 'Nema aktivnih oglasa'"
        text="Za odabrane filtere trenutno nema oglasa. Pokušajte promijeniti pretragu ili pogledajte arhivu."
      >
        <BaseButton
          v-if="status === 'aktivni'"
          variant="secondary"
          size="sm"
          @click="status = 'arhiva'"
        >
          Pogledaj arhivu
        </BaseButton>
        <BaseButton v-else variant="secondary" size="sm" @click="status = 'aktivni'">
          Aktivni oglasi
        </BaseButton>
      </EmptyState>

      <template v-else>
        <CardGrid :cols="3">
          <AdCard v-for="o in vidljivi" :key="o.slug" :item="o" />
        </CardGrid>
        <div v-if="ukupnoStranica > 1" class="mt-10 flex justify-center">
          <Pagination v-model="stranica" :total="ukupnoStranica" />
        </div>
      </template>
    </AppContainer>
  </main>
</template>
