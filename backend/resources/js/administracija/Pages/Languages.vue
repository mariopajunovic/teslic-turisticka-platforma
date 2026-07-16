<script setup>
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Plus, Pencil, Trash2, Lock, Globe, X } from 'lucide-vue-next';
import Card from '../components/Card.vue';
import Btn from '../components/Btn.vue';
import IconBtn from '../components/IconBtn.vue';
import FormField from '../components/FormField.vue';
import ToggleField from '../components/ToggleField.vue';
import EmptyState from '../components/EmptyState.vue';
import { useConfirm } from '../composables/useConfirm';

const props = defineProps({
    languages: { type: Array, default: () => [] },
});

const { confirm } = useConfirm();

const showForm = ref(false);
const mode = ref('create');
const editing = ref(null);

const form = useForm({ code: '', name: '', is_active: true });

const openCreate = () => {
    mode.value = 'create';
    editing.value = null;
    form.reset();
    form.clearErrors();
    showForm.value = true;
};

const openEdit = (lang) => {
    mode.value = 'edit';
    editing.value = lang;
    form.code = lang.code;
    form.name = lang.name;
    form.is_active = lang.isActive;
    form.clearErrors();
    showForm.value = true;
};

const submit = () => {
    if (mode.value === 'create') {
        form.transform((d) => ({ code: d.code.toLowerCase().trim(), name: d.name }))
            .post('/administracija/jezici', {
                preserveScroll: true,
                onSuccess: () => { showForm.value = false; },
            });
    } else {
        form.transform((d) => ({ name: d.name, is_active: d.is_active }))
            .put(`/administracija/jezici/${editing.value.id}`, {
                preserveScroll: true,
                onSuccess: () => { showForm.value = false; },
            });
    }
};

const remove = async (lang) => {
    const ok = await confirm({
        danger: true,
        title: `Obrisati jezik „${lang.name}"?`,
        message: 'Prevodi za ovaj jezik će ostati u bazi, ali jezik više neće biti dostupan na sajtu.',
        confirmLabel: 'Obriši jezik',
    });
    if (!ok) return;
    router.delete(`/administracija/jezici/${lang.id}`, { preserveScroll: true });
};
</script>

<template>
    <Head title="Jezici" />

    <div class="space-y-[18px]">
        <header class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-[22px] font-bold text-ink">Jezici</h1>
                <p class="mt-1 text-sm text-ink-2">Sistemski jezici su zaključani. Dodajte dodatne jezike po potrebi.</p>
            </div>
            <Btn variant="primary" :icon="Plus" @click="openCreate">Dodaj jezik</Btn>
        </header>

        <Card title="Jezici" :count="languages.length" :padded="false">
            <div v-if="languages.length" class="w-full overflow-x-auto">
                <div class="min-w-[560px]">
                    <div class="flex items-center gap-3.5 border-b border-line bg-surface-alt px-[18px] py-2.5">
                        <div class="flex-1 text-[11px] font-bold uppercase tracking-wide text-ink-3">Jezik</div>
                        <div class="w-[360px] shrink-0 text-[11px] font-bold uppercase tracking-wide text-ink-3">Status</div>
                        <div class="w-[110px] shrink-0 text-right text-[11px] font-bold uppercase tracking-wide text-ink-3">Akcije</div>
                    </div>

                    <div
                        v-for="lang in languages"
                        :key="lang.id"
                        class="flex items-center gap-3.5 border-b border-line px-[18px] py-3 last:border-b-0"
                    >
                        <div class="flex flex-1 items-center gap-2.5">
                            <span class="rounded bg-brand-tint px-2 py-[3px] font-mono text-xs font-bold text-brand">{{ lang.code }}</span>
                            <span class="text-[13px] font-semibold text-ink">{{ lang.name }}</span>
                        </div>

                        <div class="flex w-[360px] shrink-0 items-center gap-1.5">
                            <span
                                v-if="lang.isSystem"
                                class="rounded bg-surface-alt px-2.5 py-[3px] text-xs font-semibold text-ink-2"
                            >Sistemski</span>
                            <span
                                v-else
                                class="rounded bg-brand-tint px-2.5 py-[3px] text-xs font-semibold text-brand"
                            >Dodatni</span>

                            <span
                                v-if="lang.bothScripts"
                                class="rounded bg-info-bg px-2.5 py-[3px] text-xs font-semibold text-info"
                            >Latinica + Ćirilica</span>
                            <span
                                v-else-if="lang.isActive"
                                class="rounded bg-ok-bg px-2.5 py-[3px] text-xs font-semibold text-ok"
                            >Aktivan</span>
                            <span
                                v-else
                                class="rounded bg-surface-alt px-2.5 py-[3px] text-xs font-semibold text-ink-3"
                            >Neaktivan</span>
                        </div>

                        <div class="flex w-[110px] shrink-0 items-center justify-end gap-1.5">
                            <span v-if="lang.isSystem" class="inline-flex h-8 w-8 items-center justify-center text-ink-3" title="Zaključan">
                                <Lock :size="16" />
                            </span>
                            <template v-else>
                                <IconBtn :icon="Pencil" tooltip="Uredi" size="sm" @click="openEdit(lang)" />
                                <IconBtn :icon="Trash2" color="bad" tooltip="Obriši" size="sm" @click="remove(lang)" />
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="p-8">
                <EmptyState :icon="Globe" title="Nema jezika" text="Dodajte prvi dodatni jezik." />
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
                <div class="relative my-auto w-full max-w-[440px] rounded-xl border border-line bg-surface p-6 shadow-[var(--shadow-pop)]">
                    <div class="mb-5 flex items-start justify-between gap-3">
                        <div>
                            <h2 class="text-lg font-bold text-ink">{{ mode === 'create' ? 'Dodaj jezik' : 'Uredi jezik' }}</h2>
                            <p class="mt-0.5 text-[13px] text-ink-3">
                                {{ mode === 'create' ? 'Novi jezik postaje odmah dostupan za prevođenje.' : 'Izmijenite naziv ili status jezika.' }}
                            </p>
                        </div>
                        <button type="button" class="text-ink-3 hover:text-ink" aria-label="Zatvori" @click="showForm = false">
                            <X :size="18" />
                        </button>
                    </div>

                    <form class="space-y-4" @submit.prevent="submit">
                        <FormField
                            v-if="mode === 'create'"
                            v-model="form.code"
                            label="Kod jezika"
                            placeholder="npr. it, es, fr"
                            hint="2-8 malih slova (ISO kod). Ne može se mijenjati kasnije."
                            :error="form.errors.code"
                            required
                        />
                        <div v-else class="flex items-center gap-2.5">
                            <span class="rounded bg-brand-tint px-2 py-[3px] font-mono text-xs font-bold text-brand">{{ form.code }}</span>
                            <span class="text-[13px] text-ink-3">Kod se ne može mijenjati.</span>
                        </div>

                        <FormField
                            v-model="form.name"
                            label="Naziv jezika"
                            placeholder="npr. Italijanski"
                            :error="form.errors.name"
                            required
                        />

                        <ToggleField
                            v-if="mode === 'edit'"
                            v-model="form.is_active"
                            label="Aktivan"
                            hint="Neaktivni jezici se ne prikazuju na sajtu."
                        />

                        <div class="flex justify-end gap-2 pt-2">
                            <Btn variant="secondary" type="button" @click="showForm = false">Odustani</Btn>
                            <Btn variant="primary" type="submit" :disabled="form.processing">
                                {{ mode === 'create' ? 'Dodaj jezik' : 'Sačuvaj' }}
                            </Btn>
                        </div>
                    </form>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
