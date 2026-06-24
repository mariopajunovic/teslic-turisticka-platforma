<script setup>
import { ref } from 'vue'
import AppContainer from '@/components/layout/AppContainer.vue'
import SectionHeader from '@/components/common/SectionHeader.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const props = defineProps({
  data: { type: Object, default: () => ({}) },
})

const otvoreno = ref(null)

function toggle(i) {
  otvoreno.value = otvoreno.value === i ? null : i
}
</script>

<template>
  <AppContainer class="space-y-6">
    <SectionHeader v-if="data.naslov" :title="data.naslov" />
    <div class="divide-y divide-border overflow-hidden rounded-md border border-border bg-surface">
      <div v-for="(item, i) in data.items || []" :key="i">
        <button
          type="button"
          class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left font-semibold text-heading transition-colors hover:bg-surface-alt"
          :aria-expanded="otvoreno === i"
          @click="toggle(i)"
        >
          <span>{{ item.q }}</span>
          <BaseIcon
            :name="otvoreno === i ? 'chevron-up' : 'chevron-down'"
            :size="20"
            class="shrink-0 text-primary"
          />
        </button>
        <div v-if="otvoreno === i" class="px-5 pb-5 text-text-muted">{{ item.a }}</div>
      </div>
    </div>
  </AppContainer>
</template>
