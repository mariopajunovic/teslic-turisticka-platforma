<script setup>
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';

const props = defineProps({
    page: { type: Number, default: 1 },
    lastPage: { type: Number, default: 1 },
});

const emit = defineEmits(['go']);
</script>

<template>
    <div v-if="lastPage > 1" class="flex items-center gap-1.5">
        <button
            type="button"
            :disabled="page <= 1"
            class="inline-flex h-7 w-7 items-center justify-center rounded-md border border-line text-ink-2 hover:bg-surface-alt disabled:opacity-40"
            @click="emit('go', page - 1)"
        >
            <ChevronLeft :size="15" />
        </button>
        <span class="text-xs text-ink-3">{{ page }} / {{ lastPage }}</span>
        <button
            type="button"
            :disabled="page >= lastPage"
            class="inline-flex h-7 w-7 items-center justify-center rounded-md border border-line text-ink-2 hover:bg-surface-alt disabled:opacity-40"
            @click="emit('go', page + 1)"
        >
            <ChevronRight :size="15" />
        </button>
    </div>
</template>
