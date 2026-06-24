<script setup>
import { useId, computed } from 'vue'

const model = defineModel({ type: String, default: '' })

const props = defineProps({
  label: { type: String, default: '' },
  placeholder: { type: String, default: '' },
  helper: { type: String, default: '' },
  error: { type: String, default: '' },
  required: { type: Boolean, default: false },
  disabled: { type: Boolean, default: false },
  maxlength: { type: Number, default: null },
  rows: { type: Number, default: 5 },
})

const id = useId()
const counter = computed(() =>
  props.maxlength ? `${model.value.length}/${props.maxlength} znakova` : '',
)
</script>

<template>
  <div class="flex flex-col gap-1.5">
    <label v-if="label" :for="id" class="text-sm font-semibold text-heading">
      {{ label }} <span v-if="required" class="text-error">*</span>
    </label>
    <textarea
      :id="id"
      v-model="model"
      :rows="rows"
      :placeholder="placeholder"
      :disabled="disabled"
      :maxlength="maxlength || undefined"
      :aria-invalid="error ? 'true' : undefined"
      class="resize-y rounded-sm border bg-surface px-4 py-3 text-text outline-none transition-colors placeholder:text-text-muted focus:border-primary disabled:bg-surface-alt disabled:opacity-60"
      :class="error ? 'border-error' : 'border-border'"
    />
    <div class="flex justify-between gap-2">
      <p v-if="error" class="text-[13px] text-error">{{ error }}</p>
      <p v-else-if="helper" class="text-[13px] text-text-muted">{{ helper }}</p>
      <p v-if="counter" class="ml-auto text-[13px] text-text-muted">{{ counter }}</p>
    </div>
  </div>
</template>
