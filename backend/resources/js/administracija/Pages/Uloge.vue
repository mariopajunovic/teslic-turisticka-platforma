<script setup>
import { Head, router } from '@inertiajs/vue3';
import { ref, reactive, computed } from 'vue';
import { Check, Minus, KeyRound, Plus, Pencil, Trash2, X, Users } from 'lucide-vue-next';
import Card from '../components/Card.vue';
import Badge from '../components/Badge.vue';
import Btn from '../components/Btn.vue';
import IconBtn from '../components/IconBtn.vue';
import RoleForm from '../components/RoleForm.vue';
import { useConfirm } from '../composables/useConfirm';

const props = defineProps({
    uloge: { type: Array, default: () => [] },
    matrica: { type: Array, default: () => [] },
    kolone: { type: Array, default: () => [] },
    sveDozvole: { type: Array, default: () => [] },
});

const { confirm } = useConfirm();

const showForm = ref(false);
const editMode = ref(false);
const saving = ref(false);
const draft = ref({});

const drawer = reactive({ open: false, naziv: '', korisnici: [], loading: false });

const udjiEdit = () => {
    const d = {};
    for (const u of props.uloge) d[u.id] = [...u.dozvole];
    draft.value = d;
    editMode.value = true;
};

const izadjiEdit = () => {
    editMode.value = false;
};

const jeChecked = (row, kolona) => {
    if (editMode.value) return (draft.value[kolona.id] ?? []).includes(row.kljuc);
    return !!row.uloge[kolona.id];
};

const toggleCell = (row, kolona) => {
    if (!editMode.value || kolona.zasticena) return;
    const lista = draft.value[kolona.id] ?? (draft.value[kolona.id] = []);
    const i = lista.indexOf(row.kljuc);
    if (i === -1) lista.push(row.kljuc);
    else lista.splice(i, 1);
};

const sacuvajDozvole = async () => {
    const ok = await confirm({
        title: 'Sačuvaj izmjene dozvola?',
        message: 'Izmjene će odmah biti primijenjene na sve naloge s tim ulogama.',
        confirmLabel: 'Sačuvaj',
    });
    if (!ok) return;

    saving.value = true;
    router.put('/administracija/uloge/dozvole', { dodjele: draft.value }, {
        preserveScroll: true,
        onSuccess: () => { editMode.value = false; },
        onFinish: () => { saving.value = false; },
    });
};

const obrisiUlogu = async (u) => {
    const ok = await confirm({
        danger: true,
        title: `Brisanje uloge ${u.naziv}?`,
        message: 'Ova radnja je nepovratna. Uloga i sve njene dodjele biće trajno uklonjene s naloga.',
        confirmLabel: 'Obriši ulogu',
    });
    if (!ok) return;

    router.delete(`/administracija/uloge/${u.id}`, { preserveScroll: true });
};

const otvoriKorisnike = async (u) => {
    drawer.open = true;
    drawer.naziv = u.naziv;
    drawer.korisnici = [];
    drawer.loading = true;
    try {
        const r = await fetch(`/administracija/uloge/${u.id}/korisnici`, { headers: { Accept: 'application/json' } });
        const data = await r.json();
        drawer.korisnici = data.korisnici ?? [];
    } catch (e) {
        drawer.korisnici = [];
    }
    drawer.loading = false;
};

const colWidth = computed(() => (props.kolone.length > 3 ? '120px' : '150px'));
</script>

<template>
    <Head title="Uloge i dozvole" />

    <div class="space-y-[18px]">
        <header class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-[22px] font-bold text-ink">Uloge i prava</h1>
                <p class="mt-1 text-sm text-ink-2">Definicije uloga i dodijeljenih dozvola u sistemu.</p>
            </div>
            <Btn v-if="!showForm" variant="primary" :icon="Plus" @click="showForm = true">Nova uloga</Btn>
        </header>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="u in uloge"
                :key="u.id"
                class="group cursor-pointer rounded-[var(--radius-card)] border border-line bg-surface p-5 transition-colors hover:border-line-strong"
                @click="otvoriKorisnike(u)"
            >
                <div class="flex items-start justify-between gap-3">
                    <div class="flex min-w-0 items-center gap-2.5">
                        <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-[var(--radius-card)] bg-brand-tint text-brand">
                            <KeyRound :size="18" />
                        </span>
                        <h3 class="truncate text-[15px] font-bold text-ink">{{ u.naziv }}</h3>
                    </div>
                    <div class="flex shrink-0 items-center gap-1.5" @click.stop>
                        <Badge :label="`${u.brojNaloga} naloga`" :color="u.boja || 'gray'" :dot="false" />
                        <IconBtn
                            v-if="!u.zasticena"
                            :icon="Trash2"
                            color="bad"
                            tooltip="Obriši ulogu"
                            size="sm"
                            @click="obrisiUlogu(u)"
                        />
                    </div>
                </div>
                <p class="mt-3 text-sm text-ink-2">{{ u.opis }}</p>
            </div>
        </div>

        <Card title="Matrica dozvola" :padded="false">
            <template #actions>
                <template v-if="editMode">
                    <button
                        type="button"
                        class="rounded-md border border-line bg-surface px-3 py-1.5 text-xs font-semibold text-ink-2 hover:bg-surface-alt"
                        @click="izadjiEdit"
                    >
                        Odustani
                    </button>
                    <button
                        type="button"
                        :disabled="saving"
                        class="rounded-md bg-brand px-3 py-1.5 text-xs font-semibold text-white hover:bg-brand-dark disabled:opacity-50"
                        @click="sacuvajDozvole"
                    >
                        Sačuvaj izmjene
                    </button>
                </template>
                <button
                    v-else
                    type="button"
                    class="inline-flex items-center gap-1.5 rounded-md border border-line bg-surface px-3 py-1.5 text-xs font-semibold text-ink-2 hover:bg-surface-alt"
                    @click="udjiEdit"
                >
                    <Pencil :size="14" /> Uredi dozvole
                </button>
            </template>

            <div class="w-full overflow-x-auto">
                <table class="w-full min-w-full border-collapse text-sm">
                    <thead class="bg-surface-alt">
                        <tr>
                            <th class="border-b border-line px-[18px] py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-ink-3">
                                Dozvola
                            </th>
                            <th
                                v-for="k in kolone"
                                :key="k.id"
                                :style="{ width: colWidth }"
                                class="border-b border-line px-3 py-3 text-center text-[11px] font-semibold uppercase tracking-wide text-ink-3 whitespace-nowrap"
                            >
                                {{ k.naziv }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in matrica" :key="row.kljuc" class="border-b border-line last:border-b-0">
                            <td class="px-[18px] py-2.5 text-ink">{{ row.dozvola }}</td>
                            <td v-for="k in kolone" :key="k.id" class="px-3 py-2.5 text-center">
                                <button
                                    v-if="editMode"
                                    type="button"
                                    :disabled="k.zasticena"
                                    :class="jeChecked(row, k)
                                        ? 'border-brand bg-brand text-white'
                                        : 'border-line-strong bg-surface text-transparent'"
                                    class="inline-flex h-[18px] w-[18px] items-center justify-center rounded border disabled:opacity-60"
                                    @click="toggleCell(row, k)"
                                >
                                    <Check :size="12" />
                                </button>
                                <template v-else>
                                    <Check v-if="jeChecked(row, k)" :size="18" class="inline text-ok" />
                                    <Minus v-else :size="18" class="inline text-ink-3" />
                                </template>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </Card>
    </div>

    <Teleport to="body">
        <Transition
            enter-active-class="transition-opacity duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="drawer.open" class="fixed inset-0 z-50">
                <div class="absolute inset-0 bg-[#0f172a]/40" @click="drawer.open = false"></div>
                <aside class="absolute right-0 top-0 flex h-full w-[440px] max-w-[92%] flex-col border-l border-line bg-surface shadow-[var(--shadow-pop)]">
                    <header class="flex shrink-0 items-start justify-between gap-3 border-b border-line px-6 py-5">
                        <div class="min-w-0">
                            <h2 class="text-lg font-bold text-ink">{{ drawer.naziv }}</h2>
                            <p class="mt-0.5 text-[13px] text-ink-3">
                                {{ drawer.korisnici.length }} {{ drawer.korisnici.length === 1 ? 'nalog' : 'naloga' }} s ovom ulogom
                            </p>
                        </div>
                        <button type="button" class="text-ink-3 hover:text-ink" aria-label="Zatvori" @click="drawer.open = false">
                            <X :size="18" />
                        </button>
                    </header>

                    <div class="flex-1 overflow-y-auto">
                        <p v-if="drawer.loading" class="px-6 py-5 text-[13px] text-ink-3">Učitavanje…</p>
                        <div v-else-if="drawer.korisnici.length" class="divide-y divide-line">
                            <div v-for="(k, i) in drawer.korisnici" :key="i" class="flex items-center gap-3 px-6 py-3">
                                <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-tint text-xs font-bold uppercase text-brand">
                                    {{ k.initials }}
                                </span>
                                <div class="min-w-0">
                                    <p class="truncate text-[13px] font-semibold text-ink">{{ k.ime }}</p>
                                    <p class="truncate text-xs text-ink-3">{{ k.email }}</p>
                                </div>
                            </div>
                        </div>
                        <div v-else class="flex flex-col items-center gap-2 px-6 py-12 text-center">
                            <Users :size="28" class="text-ink-3" />
                            <p class="text-[13px] text-ink-3">Nijedan nalog nema ovu ulogu.</p>
                        </div>
                    </div>
                </aside>
            </div>
        </Transition>
    </Teleport>

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
                <div class="relative my-auto w-full max-w-[640px]">
                    <RoleForm :dozvole="sveDozvole" @close="showForm = false" />
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
