<script setup>
import { Head, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Check, Ban, LockOpen, Pencil, EllipsisVertical, ListFilter, Users } from 'lucide-vue-next';
import Card from '../components/Card.vue';
import Badge from '../components/Badge.vue';
import Avatar from '../components/Avatar.vue';
import Tabs from '../components/Tabs.vue';
import Dropdown from '../components/Dropdown.vue';
import DataTable from '../components/DataTable.vue';
import TableRow from '../components/TableRow.vue';
import TableCell from '../components/TableCell.vue';
import IconBtn from '../components/IconBtn.vue';
import Pagination from '../components/Pagination.vue';
import EmptyState from '../components/EmptyState.vue';

const props = defineProps({
    korisnici: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    filteri: {
        type: Object,
        default: () => ({ status: '', uloga: '', q: '' }),
    },
});

const tabs = [
    { key: '', label: 'Svi' },
    { key: 'aktivan', label: 'Aktivni' },
    { key: 'na_odobrenju', label: 'Na odobrenju' },
    { key: 'blokiran', label: 'Blokirani' },
];

const aktivniTab = ref(props.filteri?.status ?? '');

const cardNaslov = computed(() => {
    return {
        '': 'Svi korisnici',
        aktivan: 'Aktivni korisnici',
        na_odobrenju: 'Na odobrenju',
        blokiran: 'Blokirani',
    }[aktivniTab.value] ?? 'Svi korisnici';
});

const ulogeOpcije = [
    { value: '', label: 'Sve uloge' },
    { value: 'administrator', label: 'Administrator' },
    { value: 'urednik', label: 'Urednik' },
    { value: 'korisnik', label: 'Korisnik' },
];

const trenutnaUloga = computed(() => {
    const found = ulogeOpcije.find((o) => o.value === (props.filteri?.uloga ?? ''));
    return found?.label ?? 'Sve uloge';
});

const columns = [
    { key: 'korisnik', label: 'Korisnik' },
    { key: 'uloga', label: 'Uloga', width: '150px' },
    { key: 'status', label: 'Status', width: '150px' },
    { key: 'zadnja', label: 'Zadnja prijava', width: '160px' },
    { key: 'akcije', label: 'Akcije', align: 'right', width: '130px' },
];

const primijeni = (patch) => {
    router.get('/administracija/korisnici', {
        status: aktivniTab.value || undefined,
        uloga: props.filteri?.uloga || undefined,
        q: props.filteri?.q || undefined,
        ...patch,
    }, { preserveState: true, preserveScroll: true, replace: true });
};

const promijeniTab = (key) => {
    aktivniTab.value = key;
    primijeni({ status: key || undefined });
};

const filtrirajUlogu = (uloga) => primijeni({ uloga: uloga || undefined });

const akcija = (korisnik) => {
    if (!korisnik.akcija) return;
    router.post(`/administracija/korisnici/${korisnik.id}/${korisnik.akcija}`, {}, {
        preserveScroll: true,
    });
};

const akcijaMeta = (a) => {
    return {
        odobri: { icon: Check, color: 'ok', tooltip: 'Odobri' },
        blokiraj: { icon: Ban, color: 'bad', tooltip: 'Blokiraj' },
        odblokiraj: { icon: LockOpen, color: 'ok', tooltip: 'Odblokiraj' },
    }[a] ?? null;
};

const cap = (s) => (s ? s.charAt(0).toUpperCase() + s.slice(1) : s);
</script>

<template>
    <Head title="Korisnici" />

    <div class="space-y-[18px]">
        <header>
            <h1 class="text-[22px] font-bold text-ink">Korisnici</h1>
            <p class="mt-1 text-sm text-ink-2">Biznis i autor nalozi - odobravanje registracija, uloge i status pristupa.</p>
        </header>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <Tabs :tabs="tabs" :model-value="aktivniTab" @update:model-value="promijeniTab" />
            <Dropdown :label="trenutnaUloga" :icon="ListFilter">
                <template #default="{ close }">
                    <button
                        v-for="opt in ulogeOpcije"
                        :key="opt.value"
                        type="button"
                        class="flex w-full items-center px-3 py-2 text-left text-sm text-ink-2 hover:bg-surface-alt hover:text-ink"
                        @click="filtrirajUlogu(opt.value); close()"
                    >
                        {{ opt.label }}
                    </button>
                </template>
            </Dropdown>
        </div>

        <Card :title="cardNaslov" :count="korisnici.total ?? korisnici.data.length" :padded="false">
            <DataTable v-if="korisnici.data.length" :columns="columns">
                <TableRow v-for="k in korisnici.data" :key="k.id">
                    <TableCell label="Korisnik">
                        <span class="flex items-center gap-3">
                            <Avatar :initials="k.initials" size="sm" />
                            <span class="min-w-0 text-left">
                                <span class="block truncate text-[13px] font-semibold text-ink">{{ k.ime }}</span>
                                <span class="block truncate text-xs text-ink-3">{{ k.email }}</span>
                            </span>
                        </span>
                    </TableCell>
                    <TableCell label="Uloga">
                        <Badge :label="k.uloga" :color="k.ulogaBoja" :dot="false" />
                    </TableCell>
                    <TableCell label="Status">
                        <Badge :label="cap(k.status)" :color="k.statusBoja" />
                    </TableCell>
                    <TableCell label="Zadnja prijava">
                        <span class="text-[13px] text-ink-3">{{ k.zadnjaPrijava || '-' }}</span>
                    </TableCell>
                    <TableCell label="Akcije" align="right">
                        <span class="flex items-center justify-end gap-1.5">
                            <IconBtn :icon="Pencil" tooltip="Uredi" size="sm" />
                            <IconBtn
                                v-if="akcijaMeta(k.akcija)"
                                :icon="akcijaMeta(k.akcija).icon"
                                :color="akcijaMeta(k.akcija).color"
                                :tooltip="akcijaMeta(k.akcija).tooltip"
                                size="sm"
                                @click="akcija(k)"
                            />
                            <IconBtn :icon="EllipsisVertical" tooltip="Više" size="sm" />
                        </span>
                    </TableCell>
                </TableRow>
            </DataTable>

            <div v-else class="p-8">
                <EmptyState
                    :icon="Users"
                    title="Nema korisnika"
                    text="Nijedan korisnik ne odgovara odabranim filterima."
                />
            </div>
        </Card>

        <Pagination :links="korisnici.links" :meta="korisnici" />
    </div>
</template>
