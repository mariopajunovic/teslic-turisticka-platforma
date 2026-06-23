<script setup>
import { computed } from 'vue'
import BaseIcon from './BaseIcon.vue'

const props = defineProps({
  variant: {
    type: String,
    default: 'info',
    validator: (v) => ['uspjeh', 'greska', 'info'].includes(v),
  },
  title: { type: String, default: '' },
  text: { type: String, default: '' },
})

const map = {
  uspjeh: { bg: 'bg-success-tint', text: 'text-success', icon: 'circle-check' },
  greska: { bg: 'bg-error-tint', text: 'text-error', icon: 'circle-alert' },
  info: { bg: 'bg-info-tint', text: 'text-info', icon: 'info' },
}

const style = computed(() => map[props.variant])
</script>

<template>
  <div class="flex gap-3 rounded-md p-4" :class="style.bg" role="alert">
    <BaseIcon :name="style.icon" :size="20" :class="style.text" class="mt-0.5 shrink-0" />
    <div class="space-y-0.5">
      <p v-if="title" class="font-semibold" :class="style.text">{{ title }}</p>
      <p v-if="text || $slots.default" class="text-sm text-text">
        <slot>{{ text }}</slot>
      </p>
    </div>
  </div>
</template>
