<script setup>
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { X } from 'lucide-vue-next';
import FormField from './FormField.vue';
import SelectField from './SelectField.vue';
import TranslatableField from './TranslatableField.vue';

const props = defineProps({
    korisnik: { type: Object, default: null },
});

const emit = defineEmits(['close']);

const uloge = [
    { value: 'autor', label: 'Autor' },
    { value: 'biznis', label: 'Biznis korisnik' },
];

const statusi = [
    { value: 'na_odobrenju', label: 'Na odobrenju' },
    { value: 'aktivan', label: 'Aktivan' },
    { value: 'blokiran', label: 'Blokiran' },
];

const form = useForm({
    ime: props.korisnik?.ime ?? '',
    email: props.korisnik?.email ?? '',
    uloga: props.korisnik?.ulogaKljuc ?? 'autor',
    status: props.korisnik?.status ?? 'na_odobrenju',
    telefon: props.korisnik?.telefon ?? '',
    bio: props.korisnik?.bioTranslations ?? {},
});

const bioErrors = computed(() => {
    const out = {};
    for (const [k, v] of Object.entries(form.errors)) {
        if (k.startsWith('bio.')) out[k.slice(4)] = v;
    }
    return out;
});

const submit = () => {
    form.put(`/administracija/korisnici/${props.korisnik.id}`, {
        preserveScroll: true,
        onSuccess: () => emit('close'),
    });
};
</script>

<template>
    <div class="overflow-hidden rounded-[var(--radius-card)] border border-line bg-surface shadow-[var(--shadow-pop)]">
        <div class="flex items-center justify-between border-b border-line px-[18px] py-[15px]">
            <h3 class="text-[15px] font-bold text-ink">Uredi korisnika</h3>
            <button type="button" class="text-ink-3 hover:text-ink" aria-label="Zatvori" @click="emit('close')">
                <X :size="18" />
            </button>
        </div>

        <form @submit.prevent="submit">
            <div class="space-y-4 p-5">
                <FormField
                    v-model="form.ime"
                    label="Ime i prezime"
                    placeholder="npr. Marko Đukić"
                    required
                    :error="form.errors.ime"
                />
                <FormField
                    v-model="form.email"
                    type="email"
                    label="E-mail adresa"
                    placeholder="ime@example.com"
                    required
                    :error="form.errors.email"
                />
                <div class="grid grid-cols-2 gap-3">
                    <SelectField
                        v-model="form.uloga"
                        label="Uloga"
                        :options="uloge"
                        required
                        :error="form.errors.uloga"
                    />
                    <SelectField
                        v-model="form.status"
                        label="Status"
                        :options="statusi"
                        required
                        :error="form.errors.status"
                    />
                </div>
                <FormField
                    v-model="form.telefon"
                    label="Telefon"
                    placeholder="npr. 065 123 456"
                    :error="form.errors.telefon"
                />
                <TranslatableField
                    v-model="form.bio"
                    label="Bio"
                    type="textarea"
                    placeholder="Kratak opis korisnika"
                    hint="Prevod po jeziku - prazno pada na srpski."
                    :errors="bioErrors"
                />
            </div>

            <div class="flex items-center justify-end gap-2.5 border-t border-line bg-surface-alt px-5 py-4">
                <button
                    type="button"
                    class="rounded-md border border-line bg-surface px-4 py-2 text-[13px] font-semibold text-ink-2 hover:bg-surface-alt"
                    @click="emit('close')"
                >
                    Odustani
                </button>
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="rounded-md bg-brand px-4 py-2 text-[13px] font-semibold text-white hover:bg-brand-dark disabled:opacity-50"
                >
                    Sačuvaj izmjene
                </button>
            </div>
        </form>
    </div>
</template>
