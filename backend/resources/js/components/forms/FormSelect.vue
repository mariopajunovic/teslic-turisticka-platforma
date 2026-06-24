<script setup>
import { useId } from 'vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const model = defineModel({ type: [String, Number], default: '' })

defineProps({
  label: { type: String, default: '' },
  // options: [{ value, label }] ili niz stringova
  options: { type: Array, default: () => [] },
  placeholder: { type: String, default: 'Odaberite…' },
  helper: { type: String, default: '' },
  error: { type: String, default: '' },
  required: { type: Boolean, default: false },
  disabled: { type: Boolean, default: false },
})

const id = useId()
const normalize = (o) => (typeof o === 'object' ? o : { value: o, label: o })
</script>

<template>
  <div class="flex flex-col gap-1.5">
    <label v-if="label" :for="id" class="text-sm font-semibold text-heading">
      {{ label }} <span v-if="required" class="text-error">*</span>
    </label>
    <div class="relative">
      <select
        :id="id"
        v-model="model"
        :disabled="disabled"
        :aria-invalid="error ? 'true' : undefined"
        class="h-11 w-full appearance-none rounded-sm border bg-surface px-4 pr-10 text-text outline-none transition-colors focus:border-primary disabled:bg-surface-alt disabled:opacity-60"
        :class="[error ? 'border-error' : 'border-border', model ? 'text-text' : 'text-text-muted']"
      >
        <option value="" disabled>{{ placeholder }}</option>
        <option v-for="o in options" :key="normalize(o).value" :value="normalize(o).value">
          {{ normalize(o).label }}
        </option>
      </select>
      <BaseIcon
        name="chevron-down"
        :size="18"
        class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-text-muted"
      />
    </div>
    <p v-if="error" class="text-[13px] text-error">{{ error }}</p>
    <p v-else-if="helper" class="text-[13px] text-text-muted">{{ helper }}</p>
  </div>
</template>
