<script setup>
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { X, Mail } from 'lucide-vue-next';
import FormField from './FormField.vue';
import SelectField from './SelectField.vue';

const props = defineProps({
    uloge: { type: Array, default: () => [] },
    admin: { type: Object, default: null },
});

const emit = defineEmits(['close']);

const jeEdit = computed(() => !!props.admin);

const form = useForm({
    ime: props.admin?.ime ?? '',
    email: props.admin?.email ?? '',
    uloga: props.admin?.ulogaKljuc ?? (props.uloge[0]?.value ?? ''),
});

const submit = () => {
    const opts = { preserveScroll: true, onSuccess: () => emit('close') };
    if (jeEdit.value) {
        form.put(`/administracija/administratori/${props.admin.id}`, opts);
    } else {
        form.post('/administracija/administratori', opts);
    }
};
</script>

<template>
    <div class="overflow-hidden rounded-[var(--radius-card)] border border-line bg-surface shadow-[var(--shadow-pop)]">
        <div class="flex items-center justify-between border-b border-line px-[18px] py-[15px]">
            <h3 class="text-[15px] font-bold text-ink">{{ jeEdit ? 'Uredi administratora' : 'Novi administrator' }}</h3>
            <button type="button" class="text-ink-3 hover:text-ink" aria-label="Zatvori" @click="emit('close')">
                <X :size="18" />
            </button>
        </div>

        <form @submit.prevent="submit">
            <div class="space-y-4 p-5">
                <FormField
                    v-model="form.ime"
                    label="Ime i prezime"
                    placeholder="npr. Ana Kovač"
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
                <SelectField
                    v-if="!admin || !admin.jeSuper"
                    v-model="form.uloga"
                    label="Uloga"
                    :options="uloge"
                    :error="form.errors.uloga"
                />

                <div v-if="!jeEdit" class="flex items-start gap-2.5 rounded-md bg-info-bg px-3 py-2.5 text-info">
                    <Mail :size="16" class="mt-0.5 shrink-0" />
                    <p class="text-xs">Administrator će na email dobiti link za postavljanje lozinke.</p>
                </div>
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
                    {{ jeEdit ? 'Sačuvaj izmjene' : 'Kreiraj administratora' }}
                </button>
            </div>
        </form>
    </div>
</template>
