<script setup>
import { computed, useId } from 'vue';
import { ChevronDown } from 'lucide-vue-next';

const props = defineProps({
    modelValue: { type: [String, Number, null], default: '' },
    label: { type: String, default: null },
    options: { type: Array, default: () => [] },
    placeholder: { type: String, default: null },
    hint: { type: String, default: null },
    error: { type: String, default: null },
    required: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
});

const emit = defineEmits(['update:modelValue']);

const id = useId();

const onChange = (e) => emit('update:modelValue', e.target.value);

const normalized = computed(() =>
    props.options.map((o) =>
        typeof o === 'object' && o !== null
            ? { value: o.value, label: o.label ?? o.value }
            : { value: o, label: o },
    ),
);

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
        <div class="relative">
            <select
                :id="id"
                :value="modelValue"
                :required="required"
                :disabled="disabled"
                :class="fieldClass"
                class="h-10 w-full appearance-none rounded-[var(--radius-card)] border bg-surface pl-3 pr-9 text-sm text-ink transition-colors focus:outline-none focus:ring-2 disabled:bg-surface-alt disabled:text-ink-3"
                @change="onChange"
            >
                <option v-if="placeholder" value="">{{ placeholder }}</option>
                <option v-for="opt in normalized" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
            </select>
            <ChevronDown :size="16" class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-ink-3" />
        </div>
        <p v-if="error" class="mt-1.5 text-xs text-bad">{{ error }}</p>
        <p v-else-if="hint" class="mt-1.5 text-xs text-ink-3">{{ hint }}</p>
    </div>
</template>
