<script setup>
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Plus, Pencil, Eye, Trash2, FileText, CornerDownRight } from 'lucide-vue-next';
import Card from '../../components/Card.vue';
import Badge from '../../components/Badge.vue';
import Btn from '../../components/Btn.vue';
import IconBtn from '../../components/IconBtn.vue';
import RowMenu from '../../components/RowMenu.vue';
import EmptyState from '../../components/EmptyState.vue';
import StranicaForm from '../../components/StranicaForm.vue';
import { useConfirm } from '../../composables/useConfirm';

const props = defineProps({
    stranice: { type: Array, default: () => [] },
});

const { confirm } = useConfirm();
const showForm = ref(false);
const editStranica = ref(null);

const nova = () => {
    editStranica.value = null;
    showForm.value = true;
};

const uredi = (s) => {
    router.visit(`/administracija/stranice/${s.id}/uredi`);
};

const postavke = (s) => {
    editStranica.value = s;
    showForm.value = true;
};

const obrisi = async (s) => {
    const ok = await confirm({
        danger: true,
        title: `Obrisati „${s.title}"?`,
        message: 'Stranica i sav njen sadržaj se trajno brišu.',
        confirmLabel: 'Obriši stranicu',
    });
    if (!ok) return;
    router.delete(`/administracija/stranice/${s.id}`, { preserveScroll: true });
};

const TIP_BOJE = {
    Biznisi: '#2271B1',
    Lokaliteti: '#0A7D54',
    'Događaji': '#B26A00',
    'Priče': '#D63638',
    Oglasi: '#7A3EA1',
    Kategorija: '#0E8275',
};

const tipStyle = (s) => {
    const boja = TIP_BOJE[s.tipLabel] || '#787C82';
    return { color: boja, backgroundColor: `${boja}1a` };
};
</script>

<template>
    <Head title="Stranice" />

    <div class="space-y-[18px]">
        <header class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-[22px] font-bold text-ink">Stranice</h1>
                <p class="mt-1 text-sm text-ink-2">Sve stranice sajta - sadržaj, SEO i objava.</p>
            </div>
            <Btn variant="primary" :icon="Plus" @click="nova">Nova stranica</Btn>
        </header>

        <Card title="Stranice" :count="stranice.length" :padded="false">
            <div v-if="stranice.length" class="w-full overflow-x-auto">
                <div class="min-w-[720px]">
                    <div class="flex items-center gap-3.5 border-b border-line bg-surface-alt px-[18px] py-2.5">
                        <div class="flex-1 text-[11px] font-bold uppercase tracking-wide text-ink-3">Stranica</div>
                        <div class="w-[150px] shrink-0 text-[11px] font-bold uppercase tracking-wide text-ink-3">Tip</div>
                        <div class="w-[140px] shrink-0 text-[11px] font-bold uppercase tracking-wide text-ink-3">Status</div>
                        <div class="w-[110px] shrink-0 text-[11px] font-bold uppercase tracking-wide text-ink-3">Blokova</div>
                        <div class="w-[150px] shrink-0 text-[11px] font-bold uppercase tracking-wide text-ink-3">Izmijenjeno</div>
                        <div class="w-[120px] shrink-0 text-right text-[11px] font-bold uppercase tracking-wide text-ink-3">Akcije</div>
                    </div>

                    <div v-for="s in stranice" :key="s.id" class="flex items-center gap-3.5 border-b border-line px-[18px] py-3 last:border-b-0">
                        <div class="min-w-0 flex-1" :style="s.dubina ? { paddingLeft: '26px' } : {}">
                            <div class="flex items-center gap-2">
                                <CornerDownRight v-if="s.dubina" :size="14" class="shrink-0 text-ink-3" />
                                <span class="truncate text-[13px] font-semibold text-ink">{{ s.title }}</span>
                                <span v-if="s.isSystem" class="shrink-0 rounded bg-surface-alt px-1.5 py-px text-[11px] font-semibold text-ink-3">Sistemska</span>
                            </div>
                            <span class="text-xs text-ink-3">{{ s.url }}</span>
                        </div>
                        <div class="w-[150px] shrink-0">
                            <span :style="tipStyle(s)" class="inline-flex items-center rounded px-2.5 py-[3px] text-xs font-semibold">{{ s.tipLabel }}</span>
                        </div>
                        <div class="w-[140px] shrink-0">
                            <Badge :label="s.published ? 'Objavljeno' : 'Nacrt'" :color="s.published ? 'ok' : 'gray'" />
                        </div>
                        <div class="w-[110px] shrink-0 text-[13px] text-ink-2">{{ s.blokova }} {{ s.blokova === 1 ? 'blok' : 'blokova' }}</div>
                        <div class="w-[150px] shrink-0 text-[13px] text-ink-3">{{ s.izmijenjeno }}</div>
                        <div class="flex w-[120px] shrink-0 items-center justify-end gap-1.5">
                            <IconBtn :icon="Pencil" tooltip="Uredi" size="sm" @click="uredi(s)" />
                            <a
                                :href="s.url"
                                target="_blank"
                                title="Pregled"
                                class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-md border border-line bg-surface-alt text-ink-2 transition-colors hover:border-line-strong hover:text-ink"
                            >
                                <Eye :size="16" />
                            </a>
                            <RowMenu>
                                <template #default="{ close }">
                                    <button
                                        type="button"
                                        class="flex w-full items-center gap-2.5 px-3.5 py-2 text-left text-[13px] text-ink-2 hover:bg-surface-alt hover:text-ink"
                                        @click="close(); postavke(s)"
                                    >
                                        <Pencil :size="16" /> Postavke i SEO
                                    </button>
                                    <template v-if="!s.isSystem">
                                        <div class="my-1.5 border-t border-line"></div>
                                        <button
                                            type="button"
                                            class="flex w-full items-center gap-2.5 px-3.5 py-2 text-left text-[13px] text-bad hover:bg-bad-bg"
                                            @click="close(); obrisi(s)"
                                        >
                                            <Trash2 :size="16" /> Obriši stranicu
                                        </button>
                                    </template>
                                    <p v-else class="px-3.5 py-2 text-xs text-ink-3">Sistemska stranica se ne može obrisati.</p>
                                </template>
                            </RowMenu>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="p-8">
                <EmptyState :icon="FileText" title="Nema stranica" text="Kreirajte prvu stranicu sajta." />
            </div>
        </Card>
    </div>

    <Teleport to="body">
        <Transition
            enter-active-class="transition-opacity duration-150 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-100 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="showForm" class="fixed inset-0 z-[60] flex items-start justify-center overflow-y-auto p-4 sm:p-8">
                <div class="absolute inset-0 bg-[#0f172a]/40" @click="showForm = false"></div>
                <div class="relative my-auto w-full max-w-[520px]">
                    <StranicaForm :stranica="editStranica" @close="showForm = false" />
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
