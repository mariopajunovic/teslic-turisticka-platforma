<script setup>
import { computed } from 'vue';
import { Info, TriangleAlert } from 'lucide-vue-next';
import { useConfirm } from '../composables/useConfirm';

const { state, respond } = useConfirm();

const icon = computed(() => (state.danger ? TriangleAlert : Info));
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition-opacity duration-150 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-100 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="state.open" class="fixed inset-0 z-[60] flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-[#0f172a]/40" @click="respond(false)"></div>

                <div class="relative w-full max-w-[440px] rounded-xl bg-surface p-6 shadow-[var(--shadow-pop)]">
                    <span
                        :class="state.danger ? 'bg-bad-bg text-bad' : 'bg-brand-tint text-brand'"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-full"
                    >
                        <component :is="icon" :size="22" />
                    </span>

                    <h2 class="mt-3.5 text-base font-bold text-ink">{{ state.title }}</h2>
                    <p v-if="state.message" class="mt-1.5 text-sm text-ink-2">{{ state.message }}</p>

                    <div class="mt-5 flex items-center justify-end gap-2.5">
                        <button
                            type="button"
                            class="rounded-md border border-line bg-surface px-4 py-2 text-sm font-semibold text-ink-2 hover:bg-surface-alt"
                            @click="respond(false)"
                        >
                            {{ state.cancelLabel }}
                        </button>
                        <button
                            type="button"
                            :class="state.danger ? 'bg-bad hover:brightness-95' : 'bg-brand hover:bg-brand-dark'"
                            class="rounded-md px-4 py-2 text-sm font-semibold text-white"
                            @click="respond(true)"
                        >
                            {{ state.confirmLabel }}
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
