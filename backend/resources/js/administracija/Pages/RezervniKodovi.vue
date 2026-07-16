<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ShieldCheck, Copy, Check } from 'lucide-vue-next';

const props = defineProps({
    kodovi: { type: Array, default: () => [] },
});

const kopirano = ref(false);

const kopiraj = async () => {
    try {
        await navigator.clipboard.writeText(props.kodovi.join('\n'));
        kopirano.value = true;
        setTimeout(() => (kopirano.value = false), 2000);
    } catch (e) {
        // ignore
    }
};
</script>

<template>
    <Head title="Rezervni kodovi" />

    <div class="flex min-h-screen flex-col items-center justify-center gap-4 bg-canvas px-4 py-10">
        <div class="w-full max-w-[440px] rounded-xl border border-line bg-surface p-8 shadow-[var(--shadow-pop)]">
            <div class="flex flex-col items-center gap-2 text-center">
                <span class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-ok-bg text-ok">
                    <ShieldCheck :size="22" />
                </span>
                <h1 class="mt-1 text-xl font-bold text-ink">2FA je aktivirana</h1>
                <p class="text-[13px] text-ink-2">
                    Sačuvajte ove rezervne kodove na sigurnom mjestu. Svaki se može iskoristiti jednom ako izgubite pristup aplikaciji.
                </p>
            </div>

            <div class="mt-5 grid grid-cols-2 gap-2 rounded-lg border border-line bg-surface-alt p-4">
                <span v-for="k in kodovi" :key="k" class="font-mono text-sm text-ink-2">{{ k }}</span>
            </div>

            <button
                type="button"
                class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-md border border-line bg-surface px-4 py-2 text-[13px] font-semibold text-ink-2 hover:bg-surface-alt"
                @click="kopiraj"
            >
                <component :is="kopirano ? Check : Copy" :size="15" /> {{ kopirano ? 'Kopirano' : 'Kopiraj kodove' }}
            </button>

            <Link
                href="/administracija"
                class="mt-4 flex w-full items-center justify-center rounded-md bg-brand px-4 py-3 text-sm font-semibold text-white hover:bg-brand-dark"
            >
                Sačuvao sam - nastavi na panel
            </Link>
        </div>
    </div>
</template>
