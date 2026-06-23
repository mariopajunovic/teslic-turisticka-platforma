<script setup>
import { useId } from 'vue'

const model = defineModel({ type: [String, Number], default: '' })

defineProps({
  label: { type: String, default: '' },
  type: { type: String, default: 'text' },
  placeholder: { type: String, default: '' },
  helper: { type: String, default: '' },
  error: { type: String, default: '' },
  required: { type: Boolean, default: false },
  disabled: { type: Boolean, default: false },
})

const id = useId()
</script>

<template>
  <div class="flex flex-col gap-1.5">
    <label v-if="label" :for="id" class="text-sm font-semibold text-heading">
      {{ label }} <span v-if="required" class="text-error">*</span>
    </label>
    <input
      :id="id"
      v-model="model"
      :type="type"
      :placeholder="placeholder"
      :disabled="disabled"
      :aria-invalid="error ? 'true' : undefined"
      :aria-describedby="error || helper ? `${id}-help` : undefined"
      class="h-11 rounded-sm border bg-surface px-4 text-text outline-none transition-colors placeholder:text-text-muted focus:border-primary disabled:bg-surface-alt disabled:opacity-60"
      :class="error ? 'border-error focus:border-error' : 'border-border'"
    />
    <p v-if="error" :id="`${id}-help`" class="text-[13px] text-error">{{ error }}</p>
    <p v-else-if="helper" :id="`${id}-help`" class="text-[13px] text-text-muted">{{ helper }}</p>
  </div>
</template>
