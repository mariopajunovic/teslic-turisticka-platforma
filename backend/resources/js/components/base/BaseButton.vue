<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import BaseIcon from './BaseIcon.vue'

const props = defineProps({
  variant: {
    type: String,
    default: 'primary',
    validator: (v) => ['primary', 'secondary', 'ghost', 'akcent', 'sekundarna'].includes(v),
  },
  size: { type: String, default: 'md', validator: (v) => ['md', 'sm'].includes(v) },
  icon: { type: String, default: '' },
  iconPosition: { type: String, default: 'left' },
  disabled: { type: Boolean, default: false },
  to: { type: [String, Object], default: null },
  href: { type: String, default: null },
  type: { type: String, default: 'button' },
  block: { type: Boolean, default: false },
})

const variants = {
  primary: 'bg-primary text-white hover:bg-primary-dark',
  secondary: 'bg-surface text-primary border border-primary hover:bg-primary-tint',
  ghost: 'bg-transparent text-primary hover:bg-primary-tint',
  akcent: 'bg-accent text-heading hover:bg-accent-dark',
  sekundarna: 'bg-secondary text-heading hover:bg-secondary-dark',
}

const sizes = {
  md: 'h-11 px-5 text-base',
  sm: 'h-9 px-4 text-sm',
}

const classes = computed(() => [
  'inline-flex items-center justify-center gap-2 rounded-sm font-semibold transition-colors',
  'disabled:cursor-not-allowed disabled:opacity-50',
  variants[props.variant],
  sizes[props.size],
  props.block ? 'w-full' : '',
])

const tag = computed(() => {
  if (props.to) return Link
  if (props.href) return 'a'
  return 'button'
})

const iconSize = computed(() => (props.size === 'sm' ? 16 : 18))
</script>

<template>
  <component
    :is="tag"
    :href="(tag === Link ? to : href) || undefined"
    :type="tag === 'button' ? type : undefined"
    :disabled="tag === 'button' ? disabled : undefined"
    :aria-disabled="tag !== 'button' && disabled ? 'true' : undefined"
    :class="classes"
  >
    <BaseIcon v-if="icon && iconPosition === 'left'" :name="icon" :size="iconSize" />
    <span><slot /></span>
    <BaseIcon v-if="icon && iconPosition === 'right'" :name="icon" :size="iconSize" />
  </component>
</template>
