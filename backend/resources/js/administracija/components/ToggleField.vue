<script setup>
import { useId } from 'vue';

const props = defineProps({
    modelValue: { type: Boolean, default: false },
    label: { type: String, default: null },
    hint: { type: String, default: null },
    disabled: { type: Boolean, default: false },
});

const emit = defineEmits(['update:modelValue']);

const id = useId();

const toggle = () => {
    if (props.disabled) return;
    emit('update:modelValue', !props.modelValue);
};
</script>

<template>
    <div class="flex items-start justify-between gap-4">
        <div v-if="label || hint" class="min-w-0">
            <label :for="id" class="block text-sm font-medium text-ink">{{ label }}</label>
            <p v-if="hint" class="mt-0.5 text-xs text-ink-3">{{ hint }}</p>
        </div>
        <button
            :id="id"
            type="button"
            role="switch"
            :aria-checked="modelValue"
            :disabled="disabled"
            :class="[modelValue ? 'bg-brand' : 'bg-line-strong', disabled ? 'opacity-50 pointer-events-none' : '']"
            class="relative inline-flex h-6 w-11 shrink-0 items-center rounded-full transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-brand/40"
            @click="toggle"
        >
            <span
                :class="modelValue ? 'translate-x-5' : 'translate-x-1'"
                class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform"
            ></span>
        </button>
    </div>
</template>
