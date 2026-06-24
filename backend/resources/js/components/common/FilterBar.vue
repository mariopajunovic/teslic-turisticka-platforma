<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseChip from '@/components/base/BaseChip.vue'
import FilterDrawer from './FilterDrawer.vue'

defineProps({
  // aktivni filteri: [{ key, label }]
  chips: { type: Array, default: () => [] },
})

const emit = defineEmits(['clear', 'remove'])

const open = ref(false)

// Reaktivni breakpoint (lg = 1024px) — slot smije postojati samo na jednom
// mjestu istovremeno, pa se kontrole renderuju ili u traci ili u draweru.
const isDesktop = ref(true)
let mq = null

function update(e) {
  isDesktop.value = e.matches
}

onMounted(() => {
  mq = window.matchMedia('(min-width: 1024px)')
  isDesktop.value = mq.matches
  mq.addEventListener('change', update)
})

onUnmounted(() => {
  mq?.removeEventListener('change', update)
})
</script>

<template>
  <div class="space-y-3">
    <!-- Desktop: kontrole u redu + Očisti filtere -->
    <div v-if="isDesktop" class="flex items-end gap-3">
      <div class="flex flex-1 flex-wrap items-end gap-3">
        <slot />
      </div>
      <BaseButton variant="ghost" size="sm" @click="emit('clear')">Očisti filtere</BaseButton>
    </div>

    <!-- Mobilni: dugme koje otvara drawer; kontrole žive u draweru -->
    <div v-else>
      <BaseButton variant="secondary" icon="filter" block @click="open = true">Filteri</BaseButton>
      <FilterDrawer v-model="open">
        <slot />
      </FilterDrawer>
    </div>

    <!-- Aktivni filteri (sve veličine) -->
    <div v-if="chips.length" class="flex flex-wrap items-center gap-2">
      <BaseChip
        v-for="chip in chips"
        :key="chip.key"
        variant="uklonjiv"
        :label="chip.label"
        @remove="emit('remove', chip.key)"
      />
      <button
        type="button"
        class="ml-1 text-sm font-medium text-primary underline-offset-2 hover:underline"
        @click="emit('clear')"
      >
        Očisti filtere
      </button>
    </div>
  </div>
</template>
