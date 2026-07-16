<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Copy, Check } from 'lucide-vue-next';
import FormField from '../components/FormField.vue';
import Avatar from '../components/Avatar.vue';
import Badge from '../components/Badge.vue';

const props = defineProps({
    admin: { type: Object, required: true },
    dvaFA: { type: Boolean, default: false },
    setup: { type: Object, default: null },
});

const page = usePage();
const freshCodes = computed(() => page.props?.flash?.recoveryCodes ?? []);

const podaciForm = useForm({ ime: props.admin.ime, email: props.admin.email });
const lozinkaForm = useForm({ trenutna: '', lozinka: '', lozinka_confirmation: '' });
const dvaForm = useForm({ code: '' });
const iskljuciForm = useForm({ trenutna: '' });
const regenForm = useForm({ trenutna: '' });

const prikaziIskljuci = ref(false);
const prikaziRegen = ref(false);
const kopirano = ref(false);

const cuvajPodatke = () => podaciForm.put('/administracija/profil/podaci', { preserveScroll: true });
const cuvajLozinku = () => lozinkaForm.put('/administracija/profil/lozinka', {
    preserveScroll: true,
    onSuccess: () => lozinkaForm.reset(),
});
const ukljuci2fa = () => dvaForm.post('/administracija/profil/2fa', {
    preserveScroll: true,
    onSuccess: () => dvaForm.reset(),
});
const regenerisi = () => regenForm.post('/administracija/profil/2fa/kodovi', {
    preserveScroll: true,
    onSuccess: () => { regenForm.reset(); prikaziRegen.value = false; },
});
const iskljuci2fa = () => iskljuciForm.delete('/administracija/profil/2fa', {
    preserveScroll: true,
    onSuccess: () => { iskljuciForm.reset(); prikaziIskljuci.value = false; },
});

const kopiraj = async () => {
    try {
        await navigator.clipboard.writeText(freshCodes.value.join('\n'));
        kopirano.value = true;
        setTimeout(() => (kopirano.value = false), 2000);
    } catch (e) {
        // ignore
    }
};
</script>

<template>
    <Head title="Moj profil" />

    <div class="mx-auto max-w-[760px] space-y-[18px]">
        <header>
            <h1 class="text-[22px] font-bold text-ink">Moj profil</h1>
            <p class="mt-1 text-sm text-ink-2">Upravljajte svojim nalogom, lozinkom i sigurnošću.</p>
        </header>

        <!-- Osnovni podaci -->
        <div class="overflow-hidden rounded-[var(--radius-card)] border border-line bg-surface">
            <div class="border-b border-line px-[18px] py-[15px]">
                <h2 class="text-[15px] font-bold text-ink">Osnovni podaci</h2>
            </div>
            <form @submit.prevent="cuvajPodatke">
                <div class="space-y-4 p-5">
                    <div class="flex items-center gap-3.5">
                        <Avatar :initials="admin.initials" size="lg" />
                        <div class="min-w-0">
                            <p class="truncate text-[15px] font-bold text-ink">{{ admin.ime }}</p>
                            <p class="truncate text-[13px] text-ink-3">{{ admin.email }} · {{ admin.uloga }}</p>
                        </div>
                    </div>
                    <FormField v-model="podaciForm.ime" label="Ime i prezime" required :error="podaciForm.errors.ime" />
                    <FormField v-model="podaciForm.email" type="email" label="E-mail adresa" required :error="podaciForm.errors.email" />
                </div>
                <div class="flex justify-end border-t border-line bg-surface-alt px-5 py-4">
                    <button type="submit" :disabled="podaciForm.processing" class="rounded-md bg-brand px-4 py-2 text-[13px] font-semibold text-white hover:bg-brand-dark disabled:opacity-50">
                        Sačuvaj izmjene
                    </button>
                </div>
            </form>
        </div>

        <!-- Lozinka -->
        <div class="overflow-hidden rounded-[var(--radius-card)] border border-line bg-surface">
            <div class="border-b border-line px-[18px] py-[15px]">
                <h2 class="text-[15px] font-bold text-ink">Promjena lozinke</h2>
            </div>
            <form @submit.prevent="cuvajLozinku">
                <div class="space-y-4 p-5">
                    <FormField v-model="lozinkaForm.trenutna" type="password" label="Trenutna lozinka" autocomplete="current-password" required :error="lozinkaForm.errors.trenutna" />
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <FormField v-model="lozinkaForm.lozinka" type="password" label="Nova lozinka" autocomplete="new-password" required :error="lozinkaForm.errors.lozinka" />
                        <FormField v-model="lozinkaForm.lozinka_confirmation" type="password" label="Potvrdi novu lozinku" autocomplete="new-password" required />
                    </div>
                </div>
                <div class="flex justify-end border-t border-line bg-surface-alt px-5 py-4">
                    <button type="submit" :disabled="lozinkaForm.processing" class="rounded-md bg-brand px-4 py-2 text-[13px] font-semibold text-white hover:bg-brand-dark disabled:opacity-50">
                        Ažuriraj lozinku
                    </button>
                </div>
            </form>
        </div>

        <!-- 2FA -->
        <div class="overflow-hidden rounded-[var(--radius-card)] border border-line bg-surface">
            <div class="flex items-center justify-between gap-3 border-b border-line px-[18px] py-[15px]">
                <h2 class="text-[15px] font-bold text-ink">Dvofaktorska autentikacija (2FA)</h2>
                <Badge :label="dvaFA ? 'Aktivno' : 'Nije postavljeno'" :color="dvaFA ? 'ok' : 'warn'" />
            </div>

            <!-- Enabled state -->
            <div v-if="dvaFA" class="space-y-4 p-5">
                <p class="text-[13px] text-ink-2">Vaš nalog je zaštićen dvofaktorskom autentikacijom.</p>

                <!-- One-time recovery codes (right after enable/regenerate) -->
                <div v-if="freshCodes.length" class="rounded-md border border-brand/40 bg-brand-tint/50 p-4">
                    <p class="text-[13px] font-bold text-ink">Rezervni kodovi</p>
                    <p class="mt-0.5 text-xs text-ink-2">Sačuvajte ih sada - iz sigurnosnih razloga neće biti ponovo prikazani. Svaki se koristi jednom.</p>
                    <div class="mt-3 grid grid-cols-2 gap-2 rounded-md border border-line bg-surface p-3 sm:grid-cols-4">
                        <span v-for="k in freshCodes" :key="k" class="font-mono text-[13px] text-ink-2">{{ k }}</span>
                    </div>
                    <button type="button" class="mt-3 inline-flex items-center gap-2 rounded-md border border-line bg-surface px-3 py-1.5 text-xs font-semibold text-ink-2 hover:bg-surface-alt" @click="kopiraj">
                        <component :is="kopirano ? Check : Copy" :size="14" /> {{ kopirano ? 'Kopirano' : 'Kopiraj kodove' }}
                    </button>
                </div>

                <!-- Actions -->
                <div v-if="!prikaziRegen && !prikaziIskljuci" class="flex flex-wrap gap-2">
                    <button type="button" class="rounded-md border border-line bg-surface px-4 py-2 text-[13px] font-semibold text-ink-2 hover:bg-surface-alt" @click="prikaziRegen = true">
                        Regeneriši rezervne kodove
                    </button>
                    <button type="button" class="rounded-md border border-line bg-surface px-4 py-2 text-[13px] font-semibold text-bad hover:bg-bad-bg" @click="prikaziIskljuci = true">
                        Onemogući 2FA
                    </button>
                </div>

                <!-- Regenerate form -->
                <form v-if="prikaziRegen" class="flex flex-col gap-3 rounded-md border border-line bg-surface-alt p-4 sm:flex-row sm:items-end" @submit.prevent="regenerisi">
                    <div class="flex-1">
                        <FormField v-model="regenForm.trenutna" type="password" label="Potvrdite lozinkom da regenerišete kodove" required :error="regenForm.errors.trenutna" />
                    </div>
                    <div class="flex gap-2">
                        <button type="button" class="rounded-md border border-line bg-surface px-4 py-2 text-[13px] font-semibold text-ink-2" @click="prikaziRegen = false">Odustani</button>
                        <button type="submit" :disabled="regenForm.processing" class="rounded-md bg-brand px-4 py-2 text-[13px] font-semibold text-white hover:bg-brand-dark disabled:opacity-50">Regeneriši</button>
                    </div>
                </form>

                <!-- Disable form -->
                <form v-if="prikaziIskljuci" class="flex flex-col gap-3 rounded-md border border-line bg-surface-alt p-4 sm:flex-row sm:items-end" @submit.prevent="iskljuci2fa">
                    <div class="flex-1">
                        <FormField v-model="iskljuciForm.trenutna" type="password" label="Potvrdite lozinkom da isključite 2FA" required :error="iskljuciForm.errors.trenutna" />
                    </div>
                    <div class="flex gap-2">
                        <button type="button" class="rounded-md border border-line bg-surface px-4 py-2 text-[13px] font-semibold text-ink-2" @click="prikaziIskljuci = false">Odustani</button>
                        <button type="submit" :disabled="iskljuciForm.processing" class="rounded-md bg-bad px-4 py-2 text-[13px] font-semibold text-white hover:brightness-95 disabled:opacity-50">Onemogući</button>
                    </div>
                </form>
            </div>

            <!-- Setup state -->
            <form v-else @submit.prevent="ukljuci2fa">
                <div class="p-5">
                    <p class="text-[13px] text-ink-2">Dodatni sloj zaštite. Skenirajte QR kod u aplikaciji (Google Authenticator, Authy) i unesite kod za potvrdu.</p>
                    <div class="mt-4 flex flex-col gap-5 sm:flex-row sm:items-start">
                        <img v-if="setup" :src="setup.qr" alt="QR kod" class="h-[150px] w-[150px] shrink-0 rounded-lg border border-line" />
                        <div class="flex-1 space-y-3">
                            <p class="text-[13px] text-ink">Unesite 6-cifreni kod:</p>
                            <input
                                v-model="dvaForm.code"
                                inputmode="numeric"
                                maxlength="6"
                                placeholder="000000"
                                :class="dvaForm.errors.code ? 'border-bad' : 'border-line focus:border-brand'"
                                class="h-11 w-full max-w-[220px] rounded-md border bg-surface text-center font-mono text-lg tracking-[0.3em] text-ink placeholder:text-ink-3 focus:outline-none focus:ring-2 focus:ring-brand/20"
                            />
                            <p v-if="dvaForm.errors.code" class="text-xs text-bad">{{ dvaForm.errors.code }}</p>
                            <p v-if="setup" class="text-xs text-ink-3">Ručni unos: <span class="font-mono text-ink-2">{{ setup.secret }}</span></p>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end border-t border-line bg-surface-alt px-5 py-4">
                    <button type="submit" :disabled="dvaForm.processing" class="rounded-md bg-brand px-4 py-2 text-[13px] font-semibold text-white hover:bg-brand-dark disabled:opacity-50">
                        Uključi 2FA
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
