<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { ShieldCheck } from 'lucide-vue-next';
import Btn from '../components/Btn.vue';

const page = usePage();
const flash = computed(() => page.props?.flash ?? {});

const nacin = ref('app');
const form = useForm({ code: '' });

const onInput = (e) => {
    if (nacin.value === 'app') {
        form.code = e.target.value.replace(/\D/g, '').slice(0, 6);
    } else {
        form.code = e.target.value.trim().toLowerCase().slice(0, 20);
    }
};

const prebaci = () => {
    nacin.value = nacin.value === 'app' ? 'rezervni' : 'app';
    form.code = '';
    form.clearErrors();
};

const submit = () => form.post('/administracija/2fa');
</script>

<template>
    <Head title="Dvofaktorska potvrda" />

    <div class="flex min-h-screen flex-col items-center justify-center gap-4 bg-canvas px-4 py-10">
        <div class="w-full max-w-[420px] rounded-xl border border-line bg-surface p-8 shadow-[var(--shadow-pop)]">
            <div class="flex flex-col items-center gap-2 text-center">
                <img src="/logo.svg" alt="Teslić" class="w-[150px]" />
                <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-ink-3">Administracija</span>
            </div>

            <div class="mt-4 flex flex-col items-center gap-1 text-center">
                <h1 class="text-xl font-bold text-ink">Dvofaktorska potvrda</h1>
                <p class="text-[13px] text-ink-2">
                    {{ nacin === 'app' ? 'Unesite 6-cifreni kod iz aplikacije za autentifikaciju.' : 'Unesite jedan od rezervnih kodova.' }}
                </p>
            </div>

            <p v-if="flash.error" class="mt-4 rounded-md bg-bad-bg px-3 py-2 text-sm text-bad">{{ flash.error }}</p>

            <form class="mt-5 space-y-3" @submit.prevent="submit">
                <input
                    :value="form.code"
                    type="text"
                    :inputmode="nacin === 'app' ? 'numeric' : 'text'"
                    autocomplete="one-time-code"
                    :placeholder="nacin === 'app' ? '000000' : 'xxxx-xxxx'"
                    :maxlength="nacin === 'app' ? 6 : 20"
                    :class="form.errors.code ? 'border-bad focus:border-bad' : 'border-line focus:border-brand'"
                    class="h-12 w-full rounded-lg border bg-surface text-center font-mono text-lg tracking-[0.3em] text-ink placeholder:text-ink-3 focus:outline-none focus:ring-2 focus:ring-brand/20"
                    @input="onInput"
                />
                <p v-if="form.errors.code" class="text-center text-xs text-bad">{{ form.errors.code }}</p>

                <Btn type="submit" variant="primary" size="lg" block :icon="ShieldCheck" :disabled="form.processing || !form.code">
                    Potvrdi i uđi
                </Btn>
            </form>

            <div class="mt-4 flex items-center justify-between gap-3 text-[13px]">
                <Link href="/administracija/prijava" class="font-semibold text-ink-3 hover:text-ink">← Nazad na prijavu</Link>
                <button type="button" class="font-semibold text-brand hover:underline" @click="prebaci">
                    {{ nacin === 'app' ? 'Koristi rezervni kod' : 'Koristi kod iz aplikacije' }}
                </button>
            </div>
        </div>
    </div>
</template>
