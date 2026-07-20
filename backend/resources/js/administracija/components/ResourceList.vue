<script setup>
import { Head, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Plus, Pencil, Trash2 } from 'lucide-vue-next';
import Card from './Card.vue';
import Btn from './Btn.vue';
import IconBtn from './IconBtn.vue';
import Tabs from './Tabs.vue';
import SelectField from './SelectField.vue';
import StatusBadge from './StatusBadge.vue';
import RowMenu from './RowMenu.vue';
import Pagination from './Pagination.vue';
import EmptyState from './EmptyState.vue';
import { useConfirm } from '../composables/useConfirm';

const props = defineProps({
    stavke: { type: Object, default: () => ({ data: [], links: [] }) },
    filteri: { type: Object, default: () => ({ tab: 'sve', kategorija: null }) },
    brojaci: { type: Object, default: () => ({ objavljeni: 0, naCekanju: 0, nacrti: 0 }) },
    kategorije: { type: Array, default: () => [] },
    naslov: { type: String, required: true },
    jednina: { type: String, required: true },
    baza: { type: String, required: true },
    ikona: { type: [Object, Function], default: null },
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

const url = computed(() => `/administracija/${props.baza}`);

const primijeni = (patch = {}) => {
    router.get(url.value, {
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
    return { color: boja, backgroundColor: `${boja}1a` };
};

const obrisi = async (s) => {
    const ok = await confirm({
        danger: true,
        title: `Obrisati „${s.naslov}"?`,
        message: `${props.jednina} se trajno briše.`,
        confirmLabel: `Obriši`,
    });
    if (!ok) return;
    router.delete(`${url.value}/${s.id}`, { preserveScroll: true });
};
</script>

<template>
    <Head :title="naslov" />

    <div class="space-y-[18px]">
        <header class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-[22px] font-bold text-ink">{{ naslov }}</h1>
                <p class="mt-1 text-sm text-ink-2">{{ podnaslov }}</p>
            </div>
            <Btn variant="primary" :icon="Plus" :href="`${url}/novi`">Novi unos</Btn>
        </header>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <Tabs :tabs="tabovi" :model-value="aktivniTab" @update:model-value="promijeniTab" />
            <div v-if="kategorije.length" class="w-full sm:w-[220px]">
                <SelectField
                    :model-value="aktivnaKategorija"
                    :options="kategorijeOpcije"
                    placeholder="Sve kategorije"
                    @update:model-value="filtrirajKategoriju"
                />
            </div>
        </div>

        <Card :count="stavke.total ?? stavke.data.length" :title="naslov" :padded="false">
            <div v-if="stavke.data.length" class="w-full overflow-x-auto">
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
                        v-for="s in stavke.data"
                        :key="s.id"
                        class="flex cursor-pointer items-center gap-3.5 border-b border-line px-[18px] py-3 last:border-b-0 hover:bg-surface-alt"
                        @click="router.visit(`${url}/${s.id}/uredi`)"
                    >
                        <div class="min-w-0 flex-1">
                            <span class="block truncate text-[13px] font-semibold text-ink">{{ s.naslov }}</span>
                            <span v-if="s.opis" class="block truncate text-xs text-ink-3">{{ s.opis }}</span>
                        </div>
                        <div class="w-[180px] shrink-0">
                            <span
                                v-if="s.kategorija"
                                :style="pill(s.kategorija)"
                                class="inline-flex items-center gap-1.5 rounded px-2.5 py-[3px] text-xs font-semibold"
                            >
                                <span :style="{ backgroundColor: s.kategorija.color || '#64748b' }" class="h-1.5 w-1.5 rounded-full"></span>
                                {{ s.kategorija.label }}
                            </span>
                            <span v-else class="text-xs text-ink-3">-</span>
                        </div>
                        <div class="w-[150px] shrink-0 truncate text-[13px] text-ink-2">{{ s.autor || '-' }}</div>
                        <div class="w-[130px] shrink-0">
                            <StatusBadge :status="s.status" />
                        </div>
                        <div class="w-[110px] shrink-0 text-[13px] text-ink-3">{{ s.datum }}</div>
                        <div class="flex w-[90px] shrink-0 items-center justify-end gap-1.5" @click.stop>
                            <IconBtn :icon="Pencil" tooltip="Uredi" size="sm" @click="router.visit(`${url}/${s.id}/uredi`)" />
                            <RowMenu>
                                <template #default="{ close }">
                                    <button
                                        type="button"
                                        class="flex w-full items-center gap-2.5 px-3.5 py-2 text-left text-[13px] text-bad hover:bg-bad-bg"
                                        @click="close(); obrisi(s)"
                                    >
                                        <Trash2 :size="16" /> Obriši
                                    </button>
                                </template>
                            </RowMenu>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="p-8">
                <EmptyState :icon="ikona" :title="`Nema unosa`" :text="`Dodajte prvi unos.`" />
            </div>
        </Card>

        <Pagination :links="stavke.links" :meta="stavke" />
    </div>
</template>
