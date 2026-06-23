<script setup>
import { computed } from 'vue'
import BaseIcon from './BaseIcon.vue'

const props = defineProps({
  variant: {
    type: String,
    default: 'kategorija',
    validator: (v) => ['filter', 'kategorija', 'uklonjiv'].includes(v),
  },
  label: { type: String, required: true },
  icon: { type: String, default: '' },
  active: { type: Boolean, default: false },
})

defineEmits(['click', 'remove'])

const base = 'inline-flex items-center gap-1.5 rounded-pill font-medium transition-colors'

const classes = computed(() => {
  if (props.variant === 'filter') {
    return [
      base,
      'px-4 py-2 text-sm cursor-pointer',
      props.active
        ? 'bg-primary text-white'
        : 'bg-primary-tint text-primary-dark hover:bg-primary-tint-2',
    ]
  }
  if (props.variant === 'uklonjiv') {
    return [base, 'px-4 py-2 text-sm bg-primary-tint text-primary-dark']
  }
  // kategorija (statična oznaka)
  return [base, 'px-3 py-1.5 text-[13px] bg-surface text-text border border-border']
})
</script>

<template>
  <component
    :is="variant === 'filter' ? 'button' : 'span'"
    :type="variant === 'filter' ? 'button' : undefined"
    :aria-pressed="variant === 'filter' ? String(active) : undefined"
    :class="classes"
    @click="variant === 'filter' && $emit('click')"
  >
    <BaseIcon v-if="icon" :name="icon" :size="14" />
    <span>{{ label }}</span>
    <button
      v-if="variant === 'uklonjiv'"
      type="button"
      class="-mr-1 ml-0.5 inline-flex cursor-pointer rounded-full p-0.5 hover:bg-primary-tint-2"
      :aria-label="`Ukloni ${label}`"
      @click="$emit('remove')"
    >
      <BaseIcon name="x" :size="14" />
    </button>
  </component>
</template>
