<script setup>
import { computed } from 'vue';
import { X, MoveRight } from 'lucide-vue-next';
import Badge from './Badge.vue';
import IconBtn from './IconBtn.vue';

const props = defineProps({
    log: { type: Object, default: null },
});

defineEmits(['close']);

const meta = computed(() => {
    if (!props.log) return [];
    return [
        ['Korisnik', props.log.korisnikPuni],
        ['Uloga', props.log.uloga],
        ['Entitet', props.log.entitet],
        ['IP adresa', props.log.ip],
        ['Uređaj', props.log.uredaj],
    ];
});

const izmjene = computed(() => props.log?.izmjene ?? []);
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition-opacity duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="log" class="fixed inset-0 z-50">
                <div class="absolute inset-0 bg-[#0f172a]/40" @click="$emit('close')"></div>

                <aside
                    class="absolute right-0 top-0 flex h-full w-[460px] max-w-[92%] flex-col border-l border-line bg-surface shadow-[var(--shadow-pop)]"
                >
                    <header class="shrink-0 border-b border-line px-6 py-5">
                        <div class="flex items-center justify-between gap-3">
                            <Badge :label="log.akcija" :color="log.akcijaBoja" />
                            <IconBtn :icon="X" tooltip="Zatvori" size="sm" @click="$emit('close')" />
                        </div>
                        <h2 class="mt-3 text-lg font-bold text-ink">{{ log.naslov }}</h2>
                        <p class="mt-0.5 text-[13px] text-ink-3">{{ log.vrijeme }}</p>
                    </header>

                    <div class="flex-1 overflow-y-auto">
                        <div class="border-b border-line px-6 py-3">
                            <div
                                v-for="([oznaka, vrijednost]) in meta"
                                :key="oznaka"
                                class="flex items-start justify-between gap-4 py-[7px]"
                            >
                                <span class="shrink-0 text-[13px] text-ink-2">{{ oznaka }}</span>
                                <span class="min-w-0 truncate text-right text-[13px] font-semibold text-ink" :title="vrijednost">
                                    {{ vrijednost }}
                                </span>
                            </div>
                        </div>

                        <div class="px-6 py-5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-sidebar-group">
                                Izmijenjena polja
                            </p>

                            <div v-if="izmjene.length" class="mt-4 space-y-4">
                                <div v-for="(iz, i) in izmjene" :key="i" class="space-y-1.5">
                                    <p class="text-xs font-semibold text-ink-2">{{ iz.polje }}</p>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span
                                            v-if="iz.staro !== null"
                                            class="rounded bg-bad-bg px-2 py-0.5 text-[13px] text-bad line-through"
                                        >
                                            {{ iz.staro }}
                                        </span>
                                        <MoveRight
                                            v-if="iz.staro !== null && iz.novo !== null"
                                            :size="15"
                                            class="shrink-0 text-ink-3"
                                        />
                                        <span
                                            v-if="iz.novo !== null"
                                            class="rounded bg-ok-bg px-2 py-0.5 text-[13px] text-ok"
                                        >
                                            {{ iz.novo }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <p v-else class="mt-3 text-[13px] text-ink-3">
                                Ova akcija nema zabilježenih promjena polja.
                            </p>
                        </div>
                    </div>
                </aside>
            </div>
        </Transition>
    </Teleport>
</template>
