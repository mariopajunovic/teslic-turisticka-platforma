<script setup>
import { Head, useForm, router } from '@inertiajs/vue3';
import { ShieldCheck } from 'lucide-vue-next';
import Btn from '../components/Btn.vue';

const props = defineProps({
    qr: { type: String, default: '' },
    secret: { type: String, default: '' },
});

const form = useForm({ code: '' });

const submit = () => form.post('/administracija/2fa-postavljanje');
const odjava = () => router.post('/administracija/odjava');
</script>

<template>
    <Head title="Postavi 2FA" />

    <div class="flex min-h-screen flex-col items-center justify-center gap-4 bg-canvas px-4 py-10">
        <div class="w-full max-w-[440px] rounded-xl border border-line bg-surface p-8 shadow-[var(--shadow-pop)]">
            <div class="flex flex-col items-center gap-2 text-center">
                <img src="/logo.svg" alt="Teslić" class="w-[150px]" />
                <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-ink-3">Administracija</span>
            </div>

            <div class="mt-4 flex flex-col items-center gap-1 text-center">
                <h1 class="text-xl font-bold text-ink">Postavite dvofaktorsku zaštitu</h1>
                <p class="text-[13px] text-ink-2">Iz sigurnosnih razloga, aktivirajte 2FA prije ulaska u panel.</p>
            </div>

            <div class="mt-5 flex justify-center">
                <img :src="qr" alt="QR kod" class="h-40 w-40 rounded-lg border border-line" />
            </div>

            <p class="mt-3 text-center text-xs text-ink-3">
                Skenirajte kod u aplikaciji (Google Authenticator, Authy), pa unesite 6-cifreni kod.
            </p>
            <p class="mt-1.5 text-center text-xs text-ink-3">
                Ručni unos: <span class="font-mono text-ink-2">{{ secret }}</span>
            </p>

            <form class="mt-4 space-y-3" @submit.prevent="submit">
                <input
                    v-model="form.code"
                    inputmode="numeric"
                    autocomplete="one-time-code"
                    maxlength="6"
                    placeholder="000000"
                    :class="form.errors.code ? 'border-bad focus:border-bad' : 'border-line focus:border-brand'"
                    class="h-12 w-full rounded-lg border bg-surface text-center font-mono text-lg tracking-[0.4em] text-ink placeholder:text-ink-3 focus:outline-none focus:ring-2 focus:ring-brand/20"
                />
                <p v-if="form.errors.code" class="text-center text-xs text-bad">{{ form.errors.code }}</p>

                <Btn type="submit" variant="primary" size="lg" block :icon="ShieldCheck" :disabled="form.processing">
                    Aktiviraj i nastavi
                </Btn>
            </form>

            <button
                type="button"
                class="mt-4 w-full text-center text-[13px] font-semibold text-ink-3 hover:text-ink"
                @click="odjava"
            >
                Odjavi se
            </button>
        </div>
    </div>
</template>
