<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Check, Ban, LockOpen, Pencil, Eye, Mail, Trash2, ListFilter, Users } from 'lucide-vue-next';
import Card from '../components/Card.vue';
import Badge from '../components/Badge.vue';
import Avatar from '../components/Avatar.vue';
import Tabs from '../components/Tabs.vue';
import Dropdown from '../components/Dropdown.vue';
import DataTable from '../components/DataTable.vue';
import TableRow from '../components/TableRow.vue';
import TableCell from '../components/TableCell.vue';
import IconBtn from '../components/IconBtn.vue';
import RowMenu from '../components/RowMenu.vue';
import Pagination from '../components/Pagination.vue';
import EmptyState from '../components/EmptyState.vue';
import UserForm from '../components/UserForm.vue';
import { useConfirm } from '../composables/useConfirm';

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

const { confirm } = useConfirm();

const showForm = ref(false);
const editKorisnik = ref(null);

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
    { value: 'autor', label: 'Autor' },
    { value: 'biznis', label: 'Biznis korisnik' },
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

const uredi = (k) => {
    editKorisnik.value = k;
    showForm.value = true;
};

const statusAkcija = async (k) => {
    if (!k.akcija) return;
    if (k.akcija === 'blokiraj') {
        const ok = await confirm({
            danger: true,
            title: `Blokirati ${k.ime}?`,
            message: 'Korisnik se neće moći prijaviti niti objavljivati dok ga ne odblokirate.',
            confirmLabel: 'Blokiraj',
        });
        if (!ok) return;
    }
    router.post(`/administracija/korisnici/${k.id}/${k.akcija}`, {}, { preserveScroll: true });
};

const resetLozinke = async (k) => {
    const ok = await confirm({
        title: 'Poslati reset lozinke?',
        message: `Link za postavljanje nove lozinke biće poslan na ${k.email}.`,
        confirmLabel: 'Pošalji link',
    });
    if (!ok) return;
    router.post(`/administracija/korisnici/${k.id}/reset-lozinke`, {}, { preserveScroll: true });
};

const obrisi = async (k) => {
    const ok = await confirm({
        danger: true,
        title: `Obrisati ${k.ime}?`,
        message: 'Nalog se trajno briše. Ova radnja se ne može poništiti.',
        confirmLabel: 'Obriši nalog',
    });
    if (!ok) return;
    router.delete(`/administracija/korisnici/${k.id}`, { preserveScroll: true });
};

const akcijaMeta = (a) => {
    return {
        odobri: { icon: Check, color: 'ok', tooltip: 'Odobri' },
        blokiraj: { icon: Ban, color: 'bad', tooltip: 'Blokiraj' },
        odblokiraj: { icon: LockOpen, color: 'ok', tooltip: 'Odblokiraj' },
    }[a] ?? null;
};
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
                        <Link :href="`/administracija/korisnici/${k.id}`" class="flex items-center gap-3 group">
                            <Avatar :initials="k.initials" :src="k.avatar" size="sm" />
                            <span class="min-w-0 text-left">
                                <span class="block truncate text-[13px] font-semibold text-ink group-hover:text-brand">{{ k.ime }}</span>
                                <span class="block truncate text-xs text-ink-3">{{ k.email }}</span>
                            </span>
                        </Link>
                    </TableCell>
                    <TableCell label="Uloga">
                        <Badge :label="k.uloga" :color="k.ulogaBoja" :dot="false" />
                    </TableCell>
                    <TableCell label="Status">
                        <Badge :label="k.statusLabel" :color="k.statusBoja" />
                    </TableCell>
                    <TableCell label="Zadnja prijava">
                        <span class="text-[13px] text-ink-3">{{ k.zadnjaPrijava || '-' }}</span>
                    </TableCell>
                    <TableCell label="Akcije" align="right">
                        <span class="flex items-center justify-end gap-1.5">
                            <IconBtn :icon="Pencil" tooltip="Uredi" size="sm" @click="uredi(k)" />
                            <IconBtn
                                v-if="akcijaMeta(k.akcija)"
                                :icon="akcijaMeta(k.akcija).icon"
                                :color="akcijaMeta(k.akcija).color"
                                :tooltip="akcijaMeta(k.akcija).tooltip"
                                size="sm"
                                @click="statusAkcija(k)"
                            />
                            <RowMenu>
                                <template #default="{ close }">
                                    <Link
                                        :href="`/administracija/korisnici/${k.id}`"
                                        class="flex w-full items-center gap-2.5 px-3.5 py-2 text-left text-[13px] text-ink-2 hover:bg-surface-alt hover:text-ink"
                                    >
                                        <Eye :size="16" /> Otvori detalje
                                    </Link>
                                    <button
                                        type="button"
                                        class="flex w-full items-center gap-2.5 px-3.5 py-2 text-left text-[13px] text-ink-2 hover:bg-surface-alt hover:text-ink"
                                        @click="close(); resetLozinke(k)"
                                    >
                                        <Mail :size="16" /> Pošalji reset lozinke
                                    </button>
                                    <div class="my-1.5 border-t border-line"></div>
                                    <button
                                        type="button"
                                        class="flex w-full items-center gap-2.5 px-3.5 py-2 text-left text-[13px] text-bad hover:bg-bad-bg"
                                        @click="close(); obrisi(k)"
                                    >
                                        <Trash2 :size="16" /> Obriši nalog
                                    </button>
                                </template>
                            </RowMenu>
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
                <div class="relative my-auto w-full max-w-[480px]">
                    <UserForm :korisnik="editKorisnik" @close="showForm = false" />
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
