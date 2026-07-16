<script setup>
defineProps({
    tabs: { type: Array, default: () => [] },
    modelValue: { type: [String, Number], default: null },
});

const emit = defineEmits(['update:modelValue']);

const select = (key) => emit('update:modelValue', key);
</script>

<template>
    <div class="flex flex-wrap items-center gap-1.5">
        <button
            v-for="tab in tabs"
            :key="tab.key"
            type="button"
            :class="modelValue === tab.key
                ? 'bg-brand-tint text-brand font-bold'
                : 'text-ink-2 hover:bg-surface-alt font-medium'"
            class="rounded-md px-3.5 py-1.5 text-[13px] transition-colors"
            @click="select(tab.key)"
        >
            {{ tab.label }}
        </button>
    </div>
</template>
