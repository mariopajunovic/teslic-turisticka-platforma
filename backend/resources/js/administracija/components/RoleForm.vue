<script setup>
import { useForm } from '@inertiajs/vue3';
import { X, Check } from 'lucide-vue-next';
import FormField from './FormField.vue';

defineProps({
    dozvole: { type: Array, default: () => [] },
});

const emit = defineEmits(['close']);

const form = useForm({ naziv: '', opis: '', dozvole: [] });

const toggle = (kljuc) => {
    const i = form.dozvole.indexOf(kljuc);
    if (i === -1) form.dozvole.push(kljuc);
    else form.dozvole.splice(i, 1);
};

const submit = () => {
    form.post('/administracija/uloge', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            emit('close');
        },
    });
};
</script>

<template>
    <div class="overflow-hidden rounded-[var(--radius-card)] border border-line bg-surface shadow-[var(--shadow-pop)]">
        <div class="flex items-center justify-between border-b border-line px-[18px] py-[15px]">
            <h3 class="text-[15px] font-bold text-ink">Nova uloga</h3>
            <button type="button" class="text-ink-3 hover:text-ink" aria-label="Zatvori" @click="emit('close')">
                <X :size="18" />
            </button>
        </div>

        <form @submit.prevent="submit">
            <div class="space-y-4 p-5">
                <FormField
                    v-model="form.naziv"
                    label="Naziv uloge"
                    placeholder="npr. Moderator"
                    required
                    :error="form.errors.naziv"
                />
                <FormField
                    v-model="form.opis"
                    label="Opis"
                    placeholder="Kratak opis uloge i njenih ovlaštenja"
                    :error="form.errors.opis"
                />

                <div>
                    <p class="mb-2.5 text-[13px] font-semibold text-ink">Dozvole</p>
                    <div class="grid grid-cols-1 gap-x-6 gap-y-2.5 sm:grid-cols-2">
                        <label
                            v-for="d in dozvole"
                            :key="d.kljuc"
                            class="flex cursor-pointer items-center gap-2.5 text-[13px] text-ink select-none"
                        >
                            <span
                                :class="form.dozvole.includes(d.kljuc)
                                    ? 'border-brand bg-brand text-white'
                                    : 'border-line-strong bg-surface text-transparent'"
                                class="inline-flex h-[18px] w-[18px] shrink-0 items-center justify-center rounded border"
                            >
                                <Check :size="12" />
                            </span>
                            <input
                                type="checkbox"
                                class="sr-only"
                                :checked="form.dozvole.includes(d.kljuc)"
                                @change="toggle(d.kljuc)"
                            />
                            {{ d.labela }}
                        </label>
                    </div>
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
                    Sačuvaj ulogu
                </button>
            </div>
        </form>
    </div>
</template>
