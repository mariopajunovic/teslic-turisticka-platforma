<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Plus, Pencil, KeyRound, ShieldCheck, Mail, Ban, RotateCcw } from 'lucide-vue-next';
import Card from '../components/Card.vue';
import Badge from '../components/Badge.vue';
import Avatar from '../components/Avatar.vue';
import DataTable from '../components/DataTable.vue';
import TableRow from '../components/TableRow.vue';
import TableCell from '../components/TableCell.vue';
import IconBtn from '../components/IconBtn.vue';
import RowMenu from '../components/RowMenu.vue';
import Btn from '../components/Btn.vue';
import AdminForm from '../components/AdminForm.vue';
import EmptyState from '../components/EmptyState.vue';
import { useConfirm } from '../composables/useConfirm';

const props = defineProps({
    administratori: { type: Array, default: () => [] },
    uloge: { type: Array, default: () => [] },
});

const { confirm } = useConfirm();

const showForm = ref(false);
const editAdmin = ref(null);

const columns = [
    { key: 'admin', label: 'Administrator' },
    { key: 'uloga', label: 'Uloga', width: '150px' },
    { key: 'dvaFA', label: '2FA', width: '150px' },
    { key: 'zadnja', label: 'Zadnja prijava', width: '160px' },
    { key: 'akcije', label: 'Akcije', align: 'right', width: '140px' },
];

const noviAdmin = () => {
    editAdmin.value = null;
    showForm.value = true;
};

const urediAdmina = (a) => {
    editAdmin.value = a;
    showForm.value = true;
};

const onemoguci2fa = async (a) => {
    if (!a.dvaFA) return;
    const ok = await confirm({
        title: `Onemogući 2FA za ${a.ime}?`,
        message: 'Pri sljedećoj prijavi administrator će morati ponovo postaviti dvofaktorsku autentikaciju.',
        confirmLabel: 'Onemogući',
    });
    if (!ok) return;
    router.post(`/administracija/administratori/${a.id}/reset-2fa`, {}, { preserveScroll: true });
};

const resetLozinke = async (a) => {
    const ok = await confirm({
        title: `Poslati reset lozinke?`,
        message: `Link za postavljanje nove lozinke biće poslan na ${a.email}.`,
        confirmLabel: 'Pošalji link',
    });
    if (!ok) return;
    router.post(`/administracija/administratori/${a.id}/reset-lozinke`, {}, { preserveScroll: true });
};

const deaktiviraj = async (a) => {
    const ok = await confirm({
        danger: true,
        title: `Deaktivirati ${a.ime}?`,
        message: 'Nalog se neće moći prijaviti dok ga ponovo ne aktivirate.',
        confirmLabel: 'Deaktiviraj',
    });
    if (!ok) return;
    router.post(`/administracija/administratori/${a.id}/deaktiviraj`, {}, { preserveScroll: true });
};

const aktiviraj = async (a) => {
    const ok = await confirm({
        title: `Aktivirati ${a.ime}?`,
        message: 'Nalog će ponovo moći da se prijavljuje.',
        confirmLabel: 'Aktiviraj',
    });
    if (!ok) return;
    router.post(`/administracija/administratori/${a.id}/aktiviraj`, {}, { preserveScroll: true });
};
</script>

<template>
    <Head title="Administratori" />

    <div class="space-y-[18px]">
        <header class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-[22px] font-bold text-ink">Administratori</h1>
                <p class="mt-1 text-sm text-ink-2">Zaposleni s pristupom panelu. 2FA je obavezno za sve administratore.</p>
            </div>
            <Btn variant="primary" :icon="Plus" @click="noviAdmin">Novi administrator</Btn>
        </header>

        <Card title="Administratori" :count="administratori.length" :padded="false">
            <DataTable v-if="administratori.length" :columns="columns">
                <TableRow v-for="a in administratori" :key="a.id" :class="!a.aktivan ? 'opacity-60' : ''">
                    <TableCell label="Administrator">
                        <span class="flex items-center gap-3">
                            <Avatar :initials="a.initials" size="sm" />
                            <span class="min-w-0 text-left">
                                <span class="flex items-center gap-2">
                                    <span class="truncate text-[13px] font-semibold text-ink">{{ a.ime }}</span>
                                    <Badge v-if="!a.aktivan" label="Neaktivan" color="gray" :dot="false" />
                                </span>
                                <span class="block truncate text-xs text-ink-3">{{ a.email }}</span>
                            </span>
                        </span>
                    </TableCell>
                    <TableCell label="Uloga">
                        <Badge :label="a.uloga" :color="a.ulogaBoja" :dot="false" />
                    </TableCell>
                    <TableCell label="2FA">
                        <Badge :label="a.dvaFAtekst" :color="a.dvaFA ? 'ok' : 'warn'" />
                    </TableCell>
                    <TableCell label="Zadnja prijava">
                        <span class="text-[13px] text-ink-3">{{ a.zadnjaPrijava || '-' }}</span>
                    </TableCell>
                    <TableCell label="Akcije" align="right">
                        <span v-if="!a.jeSuper && !a.jaSam" class="flex items-center justify-end gap-1.5">
                            <IconBtn :icon="Pencil" tooltip="Uredi" size="sm" @click="urediAdmina(a)" />
                            <IconBtn
                                :icon="KeyRound"
                                :disabled="!a.dvaFA"
                                :tooltip="a.dvaFA ? 'Onemogući 2FA' : '2FA nije postavljen'"
                                size="sm"
                                @click="onemoguci2fa(a)"
                            />
                            <RowMenu>
                                <template #default="{ close }">
                                    <button
                                        type="button"
                                        class="flex w-full items-center gap-2.5 px-3.5 py-2 text-left text-[13px] text-ink-2 hover:bg-surface-alt hover:text-ink"
                                        @click="close(); resetLozinke(a)"
                                    >
                                        <Mail :size="16" /> Pošalji reset lozinke
                                    </button>
                                    <div class="my-1.5 border-t border-line"></div>
                                    <button
                                        v-if="a.aktivan && !a.jeSuper && !a.jaSam"
                                        type="button"
                                        class="flex w-full items-center gap-2.5 px-3.5 py-2 text-left text-[13px] text-bad hover:bg-bad-bg"
                                        @click="close(); deaktiviraj(a)"
                                    >
                                        <Ban :size="16" /> Deaktiviraj nalog
                                    </button>
                                    <button
                                        v-else-if="!a.aktivan"
                                        type="button"
                                        class="flex w-full items-center gap-2.5 px-3.5 py-2 text-left text-[13px] text-brand hover:bg-brand-tint"
                                        @click="close(); aktiviraj(a)"
                                    >
                                        <RotateCcw :size="16" /> Aktiviraj nalog
                                    </button>
                                    <p v-else class="px-3.5 py-2 text-xs text-ink-3">Ovaj nalog se ne može deaktivirati.</p>
                                </template>
                            </RowMenu>
                        </span>
                        <Link
                            v-else-if="a.jaSam"
                            href="/administracija/profil"
                            class="text-[13px] font-semibold text-brand hover:underline"
                        >
                            Moj profil
                        </Link>
                        <span v-else class="text-[13px] text-ink-3">-</span>
                    </TableCell>
                </TableRow>
            </DataTable>

            <div v-else class="p-8">
                <EmptyState
                    :icon="ShieldCheck"
                    title="Nema administratora"
                    text="Dodajte prvi administratorski nalog za upravljanje sistemom."
                />
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
                    <AdminForm :uloge="uloge" :admin="editAdmin" @close="showForm = false" />
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
