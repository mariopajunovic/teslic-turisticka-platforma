<script setup>
import { computed } from 'vue';

const props = defineProps({
    initials: { type: String, default: '' },
    src: { type: String, default: null },
    size: { type: String, default: 'md' },
    variant: { type: String, default: 'tint' },
});

const sizeClass = computed(() => {
    return {
        sm: 'h-[34px] w-[34px] text-xs',
        md: 'h-9 w-9 text-xs',
        lg: 'h-12 w-12 text-sm',
    }[props.size] ?? 'h-9 w-9 text-xs';
});

const variantClass = computed(() => {
    return {
        tint: 'bg-brand-tint text-brand',
        solid: 'bg-brand text-white',
    }[props.variant] ?? 'bg-brand-tint text-brand';
});
</script>

<template>
    <img
        v-if="src"
        :src="src"
        alt=""
        :class="sizeClass"
        class="inline-block shrink-0 rounded-full object-cover"
    />
    <span
        v-else
        :class="[sizeClass, variantClass]"
        class="inline-flex shrink-0 items-center justify-center rounded-full font-bold uppercase tracking-wide select-none"
    >
        {{ initials }}
    </span>
</template>
