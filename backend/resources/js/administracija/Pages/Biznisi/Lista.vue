<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Plus, Pencil, Trash2, Store } from 'lucide-vue-next';
import Card from '../../components/Card.vue';
import Btn from '../../components/Btn.vue';
import IconBtn from '../../components/IconBtn.vue';
import Tabs from '../../components/Tabs.vue';
import SelectField from '../../components/SelectField.vue';
import StatusBadge from '../../components/StatusBadge.vue';
import Badge from '../../components/Badge.vue';
import RowMenu from '../../components/RowMenu.vue';
import Pagination from '../../components/Pagination.vue';
import EmptyState from '../../components/EmptyState.vue';
import { useConfirm } from '../../composables/useConfirm';

const props = defineProps({
    biznisi: { type: Object, default: () => ({ data: [], links: [] }) },
    filteri: { type: Object, default: () => ({ tab: 'sve', kategorija: null }) },
    brojaci: { type: Object, default: () => ({ objavljeni: 0, naCekanju: 0, nacrti: 0 }) },
    kategorije: { type: Array, default: () => [] },
});

const { confirm } = useConfirm();

const tabovi = [
    { key: 'sve', label: 'Sve' },
    { key: 'objavljeni', label: 'Objavljeni' },
    { key: 'na-cekanju', label: 'Na čekanju' },
    { key: 'nacrti', label: 'Nacrti' },
    { key: 'arhiva', label: 'Arhiva' },
];

const aktivniTab = ref(props.filteri?.tab ?? 'sve');
const aktivnaKategorija = ref(props.filteri?.kategorija ?? '');

const kategorijeOpcije = computed(() => props.kategorije.map((k) => ({ value: k.value, label: k.label })));

const podnaslov = computed(() =>
    `${props.brojaci.objavljeni} objavljenih · ${props.brojaci.naCekanju} na čekanju · ${props.brojaci.nacrti} nacrta`,
);

const primijeni = (patch = {}) => {
    router.get('/administracija/biznisi', {
        tab: aktivniTab.value !== 'sve' ? aktivniTab.value : undefined,
        kategorija: aktivnaKategorija.value || undefined,
        ...patch,
    }, { preserveState: true, preserveScroll: true, replace: true });
};

const promijeniTab = (key) => {
    aktivniTab.value = key;
    primijeni({ tab: key !== 'sve' ? key : undefined });
};

const filtrirajKategoriju = (val) => {
    aktivnaKategorija.value = val;
    primijeni({ kategorija: val || undefined });
};

const pill = (kategorija) => {
    const boja = kategorija?.color || '#64748b';
    return {
        color: boja,
        backgroundColor: `${boja}1a`,
    };
};

const obrisi = async (b) => {
    const ok = await confirm({
        danger: true,
        title: `Obrisati „${b.naslov}"?`,
        message: 'Biznis i sve njegove fotografije se trajno brišu.',
        confirmLabel: 'Obriši biznis',
    });
    if (!ok) return;
    router.delete(`/administracija/biznisi/${b.id}`, { preserveScroll: true });
};
</script>

<template>
    <Head title="Biznisi" />

    <div class="space-y-[18px]">
        <header class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-[22px] font-bold text-ink">Biznisi</h1>
                <p class="mt-1 text-sm text-ink-2">{{ podnaslov }}</p>
            </div>
            <Btn variant="primary" :icon="Plus" href="/administracija/biznisi/novi">Novi biznis</Btn>
        </header>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <Tabs :tabs="tabovi" :model-value="aktivniTab" @update:model-value="promijeniTab" />
            <div class="w-full sm:w-[220px]">
                <SelectField
                    :model-value="aktivnaKategorija"
                    :options="kategorijeOpcije"
                    placeholder="Sve kategorije"
                    @update:model-value="filtrirajKategoriju"
                />
            </div>
        </div>

        <Card :count="biznisi.total ?? biznisi.data.length" title="Biznisi" :padded="false">
            <div v-if="biznisi.data.length" class="w-full overflow-x-auto">
                <div class="min-w-[820px]">
                    <div class="flex items-center gap-3.5 border-b border-line bg-surface-alt px-[18px] py-2.5">
                        <div class="flex-1 text-[11px] font-bold uppercase tracking-wide text-ink-3">Naslov</div>
                        <div class="w-[180px] shrink-0 text-[11px] font-bold uppercase tracking-wide text-ink-3">Kategorija</div>
                        <div class="w-[150px] shrink-0 text-[11px] font-bold uppercase tracking-wide text-ink-3">Autor</div>
                        <div class="w-[130px] shrink-0 text-[11px] font-bold uppercase tracking-wide text-ink-3">Status</div>
                        <div class="w-[110px] shrink-0 text-[11px] font-bold uppercase tracking-wide text-ink-3">Datum</div>
                        <div class="w-[90px] shrink-0 text-right text-[11px] font-bold uppercase tracking-wide text-ink-3">Akcije</div>
                    </div>

                    <div
                        v-for="b in biznisi.data"
                        :key="b.id"
                        class="flex cursor-pointer items-center gap-3.5 border-b border-line px-[18px] py-3 last:border-b-0 hover:bg-surface-alt"
                        @click="router.visit(`/administracija/biznisi/${b.id}/uredi`)"
                    >
                        <div class="min-w-0 flex-1">
                            <span class="block truncate text-[13px] font-semibold text-ink">{{ b.naslov }}</span>
                            <span v-if="b.opis" class="block truncate text-xs text-ink-3">{{ b.opis }}</span>
                        </div>
                        <div class="w-[180px] shrink-0">
                            <span
                                v-if="b.kategorija"
                                :style="pill(b.kategorija)"
                                class="inline-flex items-center gap-1.5 rounded px-2.5 py-[3px] text-xs font-semibold"
                            >
                                <span :style="{ backgroundColor: b.kategorija.color || '#64748b' }" class="h-1.5 w-1.5 rounded-full"></span>
                                {{ b.kategorija.label }}
                            </span>
                            <span v-else class="text-xs text-ink-3">-</span>
                        </div>
                        <div class="w-[150px] shrink-0 truncate text-[13px] text-ink-2">{{ b.autor || '-' }}</div>
                        <div class="flex w-[130px] shrink-0 flex-col items-start gap-1">
                            <StatusBadge :status="b.status" />
                            <Badge v-if="b.pendingStanje === 'na_cekanju'" label="Izmjene na čekanju" color="warn" />
                            <Badge v-else-if="b.pendingStanje === 'vraceno'" label="Vraćeno na doradu" color="bad" />
                        </div>
                        <div class="w-[110px] shrink-0 text-[13px] text-ink-3">{{ b.datum }}</div>
                        <div class="flex w-[90px] shrink-0 items-center justify-end gap-1.5" @click.stop>
                            <IconBtn :icon="Pencil" tooltip="Uredi" size="sm" @click="router.visit(`/administracija/biznisi/${b.id}/uredi`)" />
                            <RowMenu>
                                <template #default="{ close }">
                                    <button
                                        type="button"
                                        class="flex w-full items-center gap-2.5 px-3.5 py-2 text-left text-[13px] text-bad hover:bg-bad-bg"
                                        @click="close(); obrisi(b)"
                                    >
                                        <Trash2 :size="16" /> Obriši biznis
                                    </button>
                                </template>
                            </RowMenu>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="p-8">
                <EmptyState :icon="Store" title="Nema biznisa" text="Dodajte prvi biznis u katalog." />
            </div>
        </Card>

        <Pagination :links="biznisi.links" :meta="biznisi" />
    </div>
</template>
