<script setup>
import { ref, computed } from 'vue'
import AppContainer from '@/components/layout/AppContainer.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import MapInteractive from '@/components/map/MapInteractive.vue'
import MapFilterPanel from '@/components/map/MapFilterPanel.vue'
import ResultsList from '@/components/map/ResultsList.vue'
import MapPopup from '@/components/map/MapPopup.vue'

const props = defineProps({
  tacke: { type: Array, default: () => [] },
})

const aktivne = ref([])
const upit = ref('')
const odabrana = ref(null)

const filtrirano = computed(() => {
  let lista = props.tacke
  if (aktivne.value.length) lista = lista.filter((t) => aktivne.value.includes(t.kategorija))
  if (upit.value.trim()) {
    const q = upit.value.trim().toLowerCase()
    lista = lista.filter(
      (t) =>
        t.naslov?.toLowerCase().includes(q) || t.lokacija?.toLowerCase().includes(q),
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
    <AppContainer class="space-y-6 pt-8">
      <Breadcrumb :items="[{ label: 'Početna', to: '/' }, { label: 'Mapa ponude' }]" />

      <header>
        <h1 class="text-2xl font-semibold text-heading md:text-3xl">Mapa ponude</h1>
        <p class="mt-2 max-w-2xl text-text-muted">
          Istražite biznise, turističke lokalitete i događaje Teslića na interaktivnoj mapi.
        </p>
      </header>

      <div class="grid gap-6 lg:grid-cols-[320px_1fr]">
        <div class="space-y-6">
          <MapFilterPanel v-model="aktivne" @search="(v) => (upit = v)" />
          <ResultsList :items="filtrirano" @select="odaberi" />
        </div>

        <div class="relative">
          <MapInteractive
            :items="filtrirano"
            :active-categories="aktivne"
            height="640px"
            @select="odaberi"
          />
          <div v-if="odabrana" class="absolute right-4 top-4 z-[1000]">
            <MapPopup :item="odabrana" @close="odabrana = null" />
          </div>
        </div>
      </div>
    </AppContainer>
  </main>
</template>
