<script setup>
import { Check, X, TriangleAlert } from 'lucide-vue-next';
import { useToast } from '../composables/useToast';

const { state, dismiss } = useToast();

const stil = (tip) =>
    tip === 'bad'
        ? { wrap: 'bg-bad-bg text-bad', icon: TriangleAlert }
        : { wrap: 'bg-ok-bg text-ok', icon: Check };
</script>

<template>
    <Teleport to="body">
        <div class="pointer-events-none fixed right-4 top-4 z-[70] flex w-[380px] max-w-[92vw] flex-col gap-2">
            <TransitionGroup
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="translate-x-4 opacity-0"
                enter-to-class="translate-x-0 opacity-100"
                leave-active-class="transition duration-150 ease-in absolute"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-for="t in state.items"
                    :key="t.id"
                    class="pointer-events-auto flex items-center gap-3 rounded-[10px] border border-line bg-surface px-3.5 py-3 shadow-[var(--shadow-pop)]"
                >
                    <span :class="stil(t.tip).wrap" class="inline-flex h-[34px] w-[34px] shrink-0 items-center justify-center rounded-full">
                        <component :is="stil(t.tip).icon" :size="18" />
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-[13px] font-semibold text-ink">{{ t.title }}</p>
                        <p v-if="t.sub" class="truncate text-xs text-ink-3">{{ t.sub }}</p>
                    </div>
                    <button type="button" class="shrink-0 text-ink-3 hover:text-ink" aria-label="Zatvori" @click="dismiss(t.id)">
                        <X :size="16" />
                    </button>
                </div>
            </TransitionGroup>
        </div>
    </Teleport>
</template>
