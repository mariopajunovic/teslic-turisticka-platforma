<script setup>
defineProps({
    clickable: { type: Boolean, default: false },
});
</script>

<template>
    <tr
        :class="clickable ? 'cursor-pointer hover:bg-surface-alt' : 'md:hover:bg-surface-alt'"
        class="block rounded-[var(--radius-card)] border border-line bg-surface p-3 shadow-[var(--shadow-card)] transition-colors md:table-row md:rounded-none md:border-0 md:border-b md:border-line md:p-0 md:shadow-none md:last:border-b-0"
    >
        <slot />
    </tr>
</template>
