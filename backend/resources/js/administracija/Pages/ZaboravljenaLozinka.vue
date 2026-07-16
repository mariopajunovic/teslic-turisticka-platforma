<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Mail } from 'lucide-vue-next';
import FormField from '../components/FormField.vue';
import Btn from '../components/Btn.vue';

const page = usePage();
const flash = computed(() => page.props?.flash ?? {});

const form = useForm({ email: '' });

const submit = () => form.post('/administracija/zaboravljena-lozinka');
</script>

<template>
    <Head title="Zaboravljena lozinka" />

    <div class="flex min-h-screen flex-col items-center justify-center gap-4 bg-canvas px-4 py-10">
        <div class="w-full max-w-[420px] rounded-xl border border-line bg-surface p-8 shadow-[var(--shadow-pop)]">
            <div class="flex flex-col items-center gap-2 text-center">
                <img src="/logo.svg" alt="Teslić" class="w-[176px]" />
                <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-ink-3">Administracija</span>
            </div>

            <div class="mt-5 flex flex-col items-center gap-1 text-center">
                <h1 class="text-xl font-bold text-ink">Zaboravljena lozinka</h1>
                <p class="text-[13px] text-ink-2">Unesite e-mail i poslaćemo vam link za postavljanje nove lozinke.</p>
            </div>

            <p v-if="flash.status" class="mt-5 rounded-md bg-ok-bg px-3 py-2 text-sm text-ok">{{ flash.status }}</p>

            <form class="mt-5 space-y-4" @submit.prevent="submit">
                <FormField
                    v-model="form.email"
                    type="email"
                    label="E-mail adresa"
                    placeholder="ime@example.com"
                    autocomplete="username"
                    required
                    :error="form.errors.email"
                />
                <Btn type="submit" variant="primary" size="lg" block :icon="Mail" :disabled="form.processing">
                    Pošalji reset link
                </Btn>
            </form>

            <div class="mt-4 text-center">
                <Link href="/administracija/prijava" class="text-[13px] font-semibold text-ink-3 hover:text-ink">
                    ← Nazad na prijavu
                </Link>
            </div>
        </div>
    </div>
</template>
