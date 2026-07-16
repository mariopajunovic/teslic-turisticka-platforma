<script setup>
import { computed, useId } from 'vue';

const props = defineProps({
    modelValue: { type: String, default: '' },
    label: { type: String, default: null },
    placeholder: { type: String, default: null },
    hint: { type: String, default: null },
    error: { type: String, default: null },
    rows: { type: [Number, String], default: 4 },
    required: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
});

const emit = defineEmits(['update:modelValue']);

const id = useId();

const onInput = (e) => emit('update:modelValue', e.target.value);

const fieldClass = computed(() =>
    props.error
        ? 'border-bad focus:border-bad focus:ring-bad/20'
        : 'border-line focus:border-brand focus:ring-brand/20',
);
</script>

<template>
    <div>
        <label v-if="label" :for="id" class="mb-1.5 block text-sm font-medium text-ink">
            {{ label }}
            <span v-if="required" class="text-bad">*</span>
        </label>
        <textarea
            :id="id"
            :value="modelValue"
            :placeholder="placeholder"
            :rows="rows"
            :required="required"
            :disabled="disabled"
            :class="fieldClass"
            class="w-full rounded-[var(--radius-card)] border bg-surface px-3 py-2 text-sm text-ink placeholder:text-ink-3 transition-colors focus:outline-none focus:ring-2 disabled:bg-surface-alt disabled:text-ink-3"
            @input="onInput"
        ></textarea>
        <p v-if="error" class="mt-1.5 text-xs text-bad">{{ error }}</p>
        <p v-else-if="hint" class="mt-1.5 text-xs text-ink-3">{{ hint }}</p>
    </div>
</template>
