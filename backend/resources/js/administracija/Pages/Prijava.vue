<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { ShieldCheck, LogIn } from 'lucide-vue-next';
import FormField from '../components/FormField.vue';
import Btn from '../components/Btn.vue';

defineProps({
    status: { type: String, default: null },
});

const page = usePage();
const flash = computed(() => page.props?.flash ?? {});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/administracija/prijava', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Prijava" />

    <div class="flex min-h-screen flex-col items-center justify-center gap-4 bg-canvas px-4 py-10">
        <div class="w-full max-w-[420px] rounded-xl border border-line bg-surface p-8 shadow-[var(--shadow-pop)]">
            <div class="flex flex-col items-center gap-2 text-center">
                <img src="/logo.svg" alt="Teslić" class="w-[176px]" />
                <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-ink-3">Administracija</span>
            </div>

            <div class="mt-5 flex flex-col items-center gap-1 text-center">
                <h1 class="text-xl font-bold text-ink">Prijava na panel</h1>
                <p class="text-[13px] text-ink-2">Unesite pristupne podatke za administraciju.</p>
            </div>

            <p
                v-if="status || flash.status"
                class="mt-5 rounded-[var(--radius-card)] bg-ok-bg px-3 py-2 text-sm text-ok"
            >
                {{ status || flash.status }}
            </p>
            <p
                v-if="flash.error"
                class="mt-5 rounded-[var(--radius-card)] bg-bad-bg px-3 py-2 text-sm text-bad"
            >
                {{ flash.error }}
            </p>

            <form class="mt-5 space-y-4" @submit.prevent="submit">
                <FormField
                    v-model="form.email"
                    label="E-mail adresa"
                    type="email"
                    placeholder="ime@example.com"
                    autocomplete="username"
                    required
                    :error="form.errors.email"
                />
                <FormField
                    v-model="form.password"
                    label="Lozinka"
                    type="password"
                    placeholder="••••••••"
                    autocomplete="current-password"
                    required
                    :error="form.errors.password"
                />

                <div class="flex items-center justify-between gap-3">
                    <label class="inline-flex items-center gap-2 text-[13px] text-ink-2 select-none">
                        <input
                            v-model="form.remember"
                            type="checkbox"
                            class="h-4 w-4 rounded border-line text-brand focus:ring-brand/30"
                        />
                        Zapamti me
                    </label>
                    <Link href="/administracija/zaboravljena-lozinka" class="text-[13px] font-semibold text-brand hover:underline">
                        Zaboravljena lozinka?
                    </Link>
                </div>

                <Btn type="submit" variant="primary" size="lg" block :icon="LogIn" :disabled="form.processing">
                    Prijavi se
                </Btn>
            </form>

            <p class="mt-5 flex items-center justify-center gap-1.5 text-center text-xs text-ink-3">
                <ShieldCheck :size="15" />
                Pristup zaštićen dvofaktorskom autentikacijom (2FA)
            </p>
        </div>

        <p class="text-xs text-ink-3">© 2026 Turistička organizacija Teslić</p>
    </div>
</template>
