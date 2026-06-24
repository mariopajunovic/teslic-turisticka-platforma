<script setup>
import { ref, watch, computed } from 'vue'
import { router } from '@inertiajs/vue3'
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
  oglasi: { type: Object, default: () => ({ data: [], meta: { current_page: 1, last_page: 1 } }) },
  kategorija: { type: String, default: '' },
  q: { type: String, default: '' },
  status: { type: String, default: 'aktivni' },
})

const error = null

const statusOpcije = [
  { value: 'aktivni', label: 'Aktivni' },
  { value: 'arhiva', label: 'Arhiva' },
]

const vrsteOpcije = computed(() => {
  const map = new Map()
  for (const o of props.oglasi.data || []) {
    if (o.vrsta?.key && o.vrsta?.label) map.set(o.vrsta.key, o.vrsta.label)
  }
  return [...map.entries()].map(([key, label]) => ({ value: key, label }))
})

const vrsta = ref(props.kategorija || '')
const upit = ref(props.q || '')
const status = ref(props.status || 'aktivni')

let debounceTimer = null

function reload(params) {
  router.get(
    window.location.pathname,
    params,
    { preserveState: true, preserveScroll: true, replace: true },
  )
}

watch(vrsta, (val) => {
  reload({ kategorija: val || undefined, q: upit.value || undefined, status: status.value, page: 1 })
})

watch(status, (val) => {
  reload({ kategorija: vrsta.value || undefined, q: upit.value || undefined, status: val, page: 1 })
})

watch(upit, (val) => {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => {
    reload({ kategorija: vrsta.value || undefined, q: val || undefined, status: status.value, page: 1 })
  }, 350)
})

function goPage(page) {
  reload({ kategorija: vrsta.value || undefined, q: upit.value || undefined, status: status.value, page })
}

const aktivniChipovi = () => {
  const chips = []
  if (vrsta.value) {
    const found = vrsteOpcije.value.find((o) => o.value === vrsta.value)
    chips.push({ key: 'vrsta', label: found ? found.label : vrsta.value })
  }
  if (upit.value.trim()) chips.push({ key: 'upit', label: `„${upit.value.trim()}"` })
  return chips
}

function ocisti() {
  vrsta.value = ''
  upit.value = ''
  reload({ status: status.value })
}

function ukloni(key) {
  if (key === 'vrsta') vrsta.value = ''
  if (key === 'upit') upit.value = ''
  reload({ kategorija: vrsta.value || undefined, q: upit.value || undefined, status: status.value, page: 1 })
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
      <FilterBar :chips="aktivniChipovi()" @clear="ocisti" @remove="ukloni">
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

      <CardGrid v-else-if="!oglasi.data" :cols="3">
        <Skeleton :count="8" />
      </CardGrid>

      <EmptyState
        v-else-if="!oglasi.data.length"
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
          <AdCard v-for="o in oglasi.data" :key="o.slug" :item="o" />
        </CardGrid>
        <div v-if="oglasi.meta.last_page > 1" class="mt-10 flex justify-center">
          <Pagination
            :model-value="oglasi.meta.current_page"
            :total="oglasi.meta.last_page"
            @update:model-value="goPage"
          />
        </div>
      </template>
    </AppContainer>
  </main>
</template>
