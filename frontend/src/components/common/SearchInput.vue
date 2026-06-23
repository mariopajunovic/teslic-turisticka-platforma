<script setup>
import BaseIcon from '@/components/base/BaseIcon.vue'

const model = defineModel({ type: String, default: '' })

defineProps({
  placeholder: { type: String, default: 'Pretraga…' },
})

const emit = defineEmits(['submit'])

function onSubmit() {
  emit('submit', model.value)
}

function clear() {
  model.value = ''
}
</script>

<template>
  <form role="search" class="relative" @submit.prevent="onSubmit">
    <BaseIcon
      name="search"
      :size="18"
      class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-text-muted"
    />
    <input
      v-model="model"
      type="search"
      :placeholder="placeholder"
      class="h-11 w-full rounded-sm border border-border bg-surface pl-10 pr-10 text-text outline-none transition-colors placeholder:text-text-muted focus:border-primary"
      @keyup.enter="onSubmit"
    />
    <button
      v-if="model"
      type="button"
      class="absolute right-2 top-1/2 inline-flex size-7 -translate-y-1/2 items-center justify-center rounded-full text-text-muted transition-colors hover:bg-surface-alt hover:text-heading"
      aria-label="Očisti pretragu"
      @click="clear"
    >
      <BaseIcon name="x" :size="16" />
    </button>
  </form>
</template>
