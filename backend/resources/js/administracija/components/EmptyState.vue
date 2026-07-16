<script setup>
defineProps({
    icon: { type: [Object, Function], default: null },
    title: { type: String, default: '' },
    text: { type: String, default: null },
});

const slots = defineSlots();
</script>

<template>
    <div class="flex flex-col items-center justify-center px-6 py-12 text-center">
        <span
            v-if="icon"
            class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-full bg-surface-alt text-ink-3"
        >
            <component :is="icon" :size="24" />
        </span>
        <h3 class="text-sm font-semibold text-ink">{{ title }}</h3>
        <p v-if="text" class="mt-1 max-w-sm text-sm text-ink-2">{{ text }}</p>
        <div v-if="slots.default" class="mt-4">
            <slot />
        </div>
    </div>
</template>
