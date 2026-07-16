<script setup>
import { Head, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { User, Activity, Calendar, Download, ScrollText } from 'lucide-vue-next';
import Card from '../components/Card.vue';
import Badge from '../components/Badge.vue';
import Dropdown from '../components/Dropdown.vue';
import DataTable from '../components/DataTable.vue';
import TableRow from '../components/TableRow.vue';
import TableCell from '../components/TableCell.vue';
import Pagination from '../components/Pagination.vue';
import EmptyState from '../components/EmptyState.vue';
import LogDetail from '../components/LogDetail.vue';

const selected = ref(null);

const props = defineProps({
    logovi: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    filteri: {
        type: Object,
        default: () => ({ korisnik: '', akcija: '', period: '' }),
    },
});

const akcijaOpcije = [
    { value: '', label: 'Sve akcije' },
    { value: 'created', label: 'Kreiranje' },
    { value: 'updated', label: 'Izmjena' },
    { value: 'deleted', label: 'Brisanje' },
    { value: 'auth', label: 'Prijava / Odjava' },
];

const periodOpcije = [
    { value: '', label: 'Sve vrijeme' },
    { value: 'danas', label: 'Danas' },
    { value: '7dana', label: 'Zadnjih 7 dana' },
    { value: '30dana', label: 'Zadnjih 30 dana' },
];

const korisnikOpcije = [
    { value: '', label: 'Svi korisnici' },
    { value: 'admin', label: 'Administratori' },
    { value: 'web', label: 'Korisnici' },
];

const labelFor = (opcije, value, fallback) => {
    const found = opcije.find((o) => o.value === (value ?? ''));
    return found?.label ?? fallback;
};

const akcijaLabel = computed(() => labelFor(akcijaOpcije, props.filteri?.akcija, 'Sve akcije'));
const periodLabel = computed(() => labelFor(periodOpcije, props.filteri?.period, 'Sve vrijeme'));
const korisnikLabel = computed(() => labelFor(korisnikOpcije, props.filteri?.korisnik, 'Svi korisnici'));

const izvozUrl = computed(() => {
    const p = new URLSearchParams();
    if (props.filteri?.korisnik) p.set('korisnik', props.filteri.korisnik);
    if (props.filteri?.akcija) p.set('akcija', props.filteri.akcija);
    if (props.filteri?.period) p.set('period', props.filteri.period);
    const qs = p.toString();
    return '/administracija/logovi/izvoz' + (qs ? '?' + qs : '');
});

const columns = [
    { key: 'vrijeme', label: 'Vrijeme', width: '160px' },
    { key: 'korisnik', label: 'Korisnik', width: '150px' },
    { key: 'akcija', label: 'Akcija' },
    { key: 'entitet', label: 'Entitet', width: '230px' },
    { key: 'ip', label: 'IP adresa', width: '120px' },
];

const primijeni = (patch) => {
    router.get('/administracija/logovi', {
        korisnik: props.filteri?.korisnik || undefined,
        akcija: props.filteri?.akcija || undefined,
        period: props.filteri?.period || undefined,
        ...patch,
    }, { preserveState: true, preserveScroll: true, replace: true });
};
</script>

<template>
    <Head title="Logovi aktivnosti" />

    <div class="space-y-[18px]">
        <header>
            <h1 class="text-[22px] font-bold text-ink">Logovi aktivnosti</h1>
            <p class="mt-1 text-sm text-ink-2">Evidencija prijava i ključnih administrativnih radnji (uzročnik, entitet, IP).</p>
        </header>

        <div class="flex flex-col gap-2 sm:flex-row sm:flex-wrap sm:items-center">
            <Dropdown :label="korisnikLabel" :icon="User">
                <template #default="{ close }">
                    <button
                        v-for="opt in korisnikOpcije"
                        :key="opt.value"
                        type="button"
                        class="flex w-full items-center px-3 py-2 text-left text-sm text-ink-2 hover:bg-surface-alt hover:text-ink"
                        @click="primijeni({ korisnik: opt.value || undefined }); close()"
                    >
                        {{ opt.label }}
                    </button>
                </template>
            </Dropdown>
            <Dropdown :label="akcijaLabel" :icon="Activity">
                <template #default="{ close }">
                    <button
                        v-for="opt in akcijaOpcije"
                        :key="opt.value"
                        type="button"
                        class="flex w-full items-center px-3 py-2 text-left text-sm text-ink-2 hover:bg-surface-alt hover:text-ink"
                        @click="primijeni({ akcija: opt.value || undefined }); close()"
                    >
                        {{ opt.label }}
                    </button>
                </template>
            </Dropdown>
            <Dropdown :label="periodLabel" :icon="Calendar">
                <template #default="{ close }">
                    <button
                        v-for="opt in periodOpcije"
                        :key="opt.value"
                        type="button"
                        class="flex w-full items-center px-3 py-2 text-left text-sm text-ink-2 hover:bg-surface-alt hover:text-ink"
                        @click="primijeni({ period: opt.value || undefined }); close()"
                    >
                        {{ opt.label }}
                    </button>
                </template>
            </Dropdown>
        </div>

        <Card title="Aktivnosti" :padded="false">
            <template #actions>
                <a
                    :href="izvozUrl"
                    class="inline-flex h-8 items-center gap-1.5 rounded-md border border-line bg-surface px-3 text-xs font-medium text-ink hover:bg-surface-alt"
                >
                    <Download :size="15" />
                    Izvezi CSV
                </a>
            </template>

            <DataTable v-if="logovi.data.length" :columns="columns">
                <TableRow v-for="(log, i) in logovi.data" :key="i" clickable @click="selected = log">
                    <TableCell label="Vrijeme">
                        <span class="text-[13px] text-ink-3 whitespace-nowrap">{{ log.vrijeme }}</span>
                    </TableCell>
                    <TableCell label="Korisnik">
                        <span class="text-[13px] font-semibold text-ink">{{ log.korisnikPuni || 'Sistem' }}</span>
                    </TableCell>
                    <TableCell label="Akcija">
                        <span class="flex items-center justify-end gap-2 md:justify-start">
                            <Badge :label="log.akcija" :color="log.akcijaBoja" />
                            <span v-if="log.opis" class="truncate text-[13px] text-ink-2">{{ log.opis }}</span>
                        </span>
                    </TableCell>
                    <TableCell label="Entitet">
                        <span class="text-[13px] text-ink-3">{{ log.entitet || '-' }}</span>
                    </TableCell>
                    <TableCell label="IP adresa">
                        <span class="font-mono text-xs text-ink-3">{{ log.ip || '-' }}</span>
                    </TableCell>
                </TableRow>
            </DataTable>

            <div v-else class="p-8">
                <EmptyState
                    :icon="ScrollText"
                    title="Nema zapisa"
                    text="Nijedan zapis ne odgovara odabranim filterima."
                />
            </div>
        </Card>

        <Pagination :links="logovi.links" :meta="logovi" />
    </div>

    <LogDetail :log="selected" @close="selected = null" />
</template>
