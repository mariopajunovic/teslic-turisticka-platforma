<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { Lock } from 'lucide-vue-next';
import FormField from '../components/FormField.vue';
import Btn from '../components/Btn.vue';

const props = defineProps({
    token: { type: String, default: '' },
    email: { type: String, default: '' },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post('/administracija/lozinka', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Postavi lozinku" />

    <div class="flex min-h-screen flex-col items-center justify-center gap-4 bg-canvas px-4 py-10">
        <div class="w-full max-w-[420px] rounded-xl border border-line bg-surface p-8 shadow-[var(--shadow-pop)]">
            <div class="flex flex-col items-center gap-2 text-center">
                <img src="/logo.svg" alt="Teslić" class="w-[176px]" />
                <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-ink-3">Administracija</span>
            </div>

            <div class="mt-5 flex flex-col items-center gap-1 text-center">
                <h1 class="text-xl font-bold text-ink">Postavljanje lozinke</h1>
                <p class="text-[13px] text-ink-2">Postavite novu lozinku za svoj administratorski nalog.</p>
            </div>

            <form class="mt-5 space-y-4" @submit.prevent="submit">
                <FormField
                    v-model="form.email"
                    type="email"
                    label="E-mail adresa"
                    autocomplete="username"
                    disabled
                />
                <FormField
                    v-model="form.password"
                    type="password"
                    label="Nova lozinka"
                    placeholder="••••••••"
                    autocomplete="new-password"
                    required
                    :error="form.errors.password"
                />
                <FormField
                    v-model="form.password_confirmation"
                    type="password"
                    label="Potvrdi lozinku"
                    placeholder="••••••••"
                    autocomplete="new-password"
                    required
                />

                <Btn type="submit" variant="primary" size="lg" block :icon="Lock" :disabled="form.processing">
                    Postavi lozinku
                </Btn>
            </form>
        </div>

        <p class="text-xs text-ink-3">© 2026 Turistička organizacija Teslić</p>
    </div>
</template>
