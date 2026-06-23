<script setup>
import { useId } from 'vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const model = defineModel({ type: Boolean, default: false })

defineProps({
  label: { type: String, default: '' },
  required: { type: Boolean, default: false },
  disabled: { type: Boolean, default: false },
})

const id = useId()
</script>

<template>
  <label
    :for="id"
    class="inline-flex cursor-pointer items-start gap-2.5 text-text"
    :class="disabled ? 'cursor-not-allowed opacity-60' : ''"
  >
    <span class="relative mt-0.5 inline-flex">
      <input
        :id="id"
        v-model="model"
        type="checkbox"
        :disabled="disabled"
        class="peer size-5 shrink-0 appearance-none rounded-sm border border-border bg-surface outline-none transition-colors checked:border-primary checked:bg-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
      />
      <BaseIcon
        name="check"
        :size="14"
        class="pointer-events-none absolute left-1/2 top-1/2 hidden -translate-x-1/2 -translate-y-1/2 text-white peer-checked:block"
      />
    </span>
    <span class="text-[15px] leading-snug">
      <slot>{{ label }}</slot>
      <span v-if="required" class="text-error"> *</span>
    </span>
  </label>
</template>
