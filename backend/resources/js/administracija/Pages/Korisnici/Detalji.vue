<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ArrowLeft, Pencil, Mail, Trash2, LogIn, Plus, Activity as ActivityIcon, Inbox } from 'lucide-vue-next';
import Card from '../../components/Card.vue';
import Badge from '../../components/Badge.vue';
import Avatar from '../../components/Avatar.vue';
import Btn from '../../components/Btn.vue';
import RowMenu from '../../components/RowMenu.vue';
import UserForm from '../../components/UserForm.vue';
import MiniPager from '../../components/MiniPager.vue';
import ImageUpload from '../../components/ImageUpload.vue';
import { useConfirm } from '../../composables/useConfirm';

const props = defineProps({
    korisnik: { type: Object, required: true },
    sekcije: { type: Array, default: () => [] },
    logovi: { type: Object, default: () => ({ items: [], page: 1, lastPage: 1, total: 0 }) },
});

const { confirm } = useConfirm();
const showForm = ref(false);

const detailUrl = () => `/administracija/korisnici/${props.korisnik.id}`;

const pageParams = () => {
    const p = {};
    for (const s of props.sekcije) p[`${s.key}_page`] = s.page;
    p.log_page = props.logovi.page;
    return p;
};

const goSection = (key, page) => {
    router.get(detailUrl(), { ...pageParams(), [`${key}_page`]: page }, {
        only: ['sekcije'], preserveScroll: true, preserveState: true,
    });
};

const goLog = (page) => {
    router.get(detailUrl(), { ...pageParams(), log_page: page }, {
        only: ['logovi'], preserveScroll: true, preserveState: true,
    });
};

const logIcons = {
    'log-in': LogIn,
    plus: Plus,
    pencil: Pencil,
    'trash-2': Trash2,
    activity: ActivityIcon,
};

const logStyle = (boja) => {
    return {
        ok: 'bg-ok-bg text-ok',
        bad: 'bg-bad-bg text-bad',
        brand: 'bg-brand-tint text-brand',
        info: 'bg-info-bg text-info',
    }[boja] ?? 'bg-surface-alt text-ink-3';
};

const resetLozinke = async () => {
    const ok = await confirm({
        title: 'Poslati link za lozinku?',
        message: `Link za postavljanje lozinke biće poslan na ${props.korisnik.email}.`,
        confirmLabel: 'Pošalji link',
    });
    if (!ok) return;
    router.post(`/administracija/korisnici/${props.korisnik.id}/reset-lozinke`, {}, { preserveScroll: true });
};

const obrisi = async () => {
    const ok = await confirm({
        danger: true,
        title: `Obrisati ${props.korisnik.ime}?`,
        message: 'Nalog se trajno briše. Ova radnja se ne može poništiti.',
        confirmLabel: 'Obriši nalog',
    });
    if (!ok) return;
    router.delete(`/administracija/korisnici/${props.korisnik.id}`);
};
</script>

<template>
    <Head :title="korisnik.ime" />

    <div class="space-y-[18px]">
        <Link href="/administracija/korisnici" class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-ink-3 hover:text-ink">
            <ArrowLeft :size="15" /> Korisnici
        </Link>

        <section class="overflow-hidden rounded-[var(--radius-card)] border border-line bg-surface">
            <div class="flex flex-col gap-4 border-b border-line px-5 py-[18px] sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3.5">
                    <Avatar :initials="korisnik.initials" :src="korisnik.avatar" size="lg" />
                    <div class="min-w-0">
                        <h1 class="truncate text-xl font-bold text-ink">{{ korisnik.ime }}</h1>
                        <p class="truncate text-[13px] text-ink-3">{{ korisnik.email }}</p>
                    </div>
                </div>
                <div class="flex shrink-0 items-center gap-2">
                    <Btn variant="secondary" :icon="Pencil" @click="showForm = true">Uredi</Btn>
                    <RowMenu>
                        <template #default="{ close }">
                            <button
                                type="button"
                                class="flex w-full items-center gap-2.5 px-3.5 py-2 text-left text-[13px] text-ink-2 hover:bg-surface-alt hover:text-ink"
                                @click="close(); resetLozinke()"
                            >
                                <Mail :size="16" /> Pošalji link za lozinku
                            </button>
                            <div class="my-1.5 border-t border-line"></div>
                            <button
                                type="button"
                                class="flex w-full items-center gap-2.5 px-3.5 py-2 text-left text-[13px] text-bad hover:bg-bad-bg"
                                @click="close(); obrisi()"
                            >
                                <Trash2 :size="16" /> Obriši nalog
                            </button>
                        </template>
                    </RowMenu>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-x-9 gap-y-3 px-5 py-3.5">
                <div class="flex flex-col gap-1">
                    <span class="text-[11px] font-bold uppercase tracking-wide text-ink-3">Uloga</span>
                    <Badge :label="korisnik.uloga" :color="korisnik.ulogaBoja" :dot="false" />
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-[11px] font-bold uppercase tracking-wide text-ink-3">Status</span>
                    <Badge :label="korisnik.statusLabel" :color="korisnik.statusBoja" />
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-[11px] font-bold uppercase tracking-wide text-ink-3">Registrovan</span>
                    <span class="text-[13px] font-semibold text-ink">{{ korisnik.registrovan || '-' }}</span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-[11px] font-bold uppercase tracking-wide text-ink-3">Zadnja prijava</span>
                    <span class="text-[13px] font-semibold text-ink">{{ korisnik.zadnjaPrijava || '-' }}</span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-[11px] font-bold uppercase tracking-wide text-ink-3">Email</span>
                    <Badge
                        :label="korisnik.emailVerifikovan ? 'Verifikovan' : 'Nije verifikovan'"
                        :color="korisnik.emailVerifikovan ? 'ok' : 'warn'"
                    />
                </div>
            </div>
        </section>

        <div class="flex flex-col gap-[18px] lg:flex-row lg:items-start">
            <Card title="Podaci naloga" class="w-full lg:w-[340px] lg:shrink-0">
                <ImageUpload
                    :src="korisnik.avatar"
                    :upload-url="`/administracija/korisnici/${korisnik.id}/avatar`"
                    :delete-url="`/administracija/korisnici/${korisnik.id}/avatar`"
                    label="Avatar"
                    hint="Prilagodite isječak i zoom na kvadrat."
                    :aspect="1"
                    shape="circle"
                    class="mb-3 border-b border-line pb-4"
                />
                <dl class="divide-y divide-line">
                    <div v-for="row in [
                        { l: 'Email', v: korisnik.email },
                        { l: 'Telefon', v: korisnik.telefon },
                        { l: 'Bio', v: korisnik.bio },
                        { l: 'Registrovan', v: korisnik.registrovan },
                        { l: 'Zadnja prijava', v: korisnik.zadnjaPrijava },
                        { l: 'ID naloga', v: `#${korisnik.id}` },
                    ]" :key="row.l" class="flex items-start justify-between gap-4 py-2.5 first:pt-0 last:pb-0">
                        <dt class="text-[13px] text-ink-2">{{ row.l }}</dt>
                        <dd class="min-w-0 break-words text-right text-[13px] font-semibold text-ink">{{ row.v || '-' }}</dd>
                    </div>
                </dl>
            </Card>

            <div class="flex min-w-0 flex-1 flex-col gap-[18px]">
                <Card v-for="sekcija in sekcije" :key="sekcija.key" :title="sekcija.naslov" :count="sekcija.total" :padded="false">
                    <div v-if="sekcija.items.length" class="divide-y divide-line">
                        <div v-for="item in sekcija.items" :key="item.id" class="flex items-center justify-between gap-3 px-[18px] py-3">
                            <div class="min-w-0">
                                <p class="truncate text-[13px] font-semibold text-ink">{{ item.naslov }}</p>
                                <p class="truncate text-xs text-ink-3">{{ item.datum || '-' }}</p>
                            </div>
                            <Badge :label="item.status" :color="item.statusBoja" />
                        </div>
                    </div>
                    <div v-else class="px-[18px] py-6 text-center text-[13px] text-ink-3">Nema stavki.</div>

                    <div v-if="sekcija.lastPage > 1" class="flex items-center justify-between border-t border-line px-[18px] py-2.5">
                        <span class="text-xs text-ink-3">Ukupno {{ sekcija.total }}</span>
                        <MiniPager :page="sekcija.page" :last-page="sekcija.lastPage" @go="goSection(sekcija.key, $event)" />
                    </div>
                </Card>

                <Card title="Aktivnost" :count="logovi.total" :padded="false">
                    <div v-if="logovi.items.length" class="divide-y divide-line">
                        <div v-for="log in logovi.items" :key="log.id" class="flex items-start gap-3 px-[18px] py-3">
                            <span :class="logStyle(log.boja)" class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full">
                                <component :is="logIcons[log.icon] ?? ActivityIcon" :size="16" />
                            </span>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-baseline justify-between gap-3">
                                    <p class="text-[13px] font-semibold text-ink">{{ log.naslov }}</p>
                                    <p class="shrink-0 text-xs text-ink-3">{{ log.time }}</p>
                                </div>
                                <ul v-if="log.izmjene.length" class="mt-1 space-y-0.5">
                                    <li v-for="(iz, i) in log.izmjene" :key="i" class="text-xs text-ink-2">
                                        <span class="font-medium text-ink-3">{{ iz.polje }}:</span>
                                        <span class="text-ink-3 line-through">{{ iz.staro }}</span>
                                        <span class="text-ink-3"> → </span>
                                        <span class="text-ink">{{ iz.novo }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div v-else class="flex flex-col items-center gap-2 px-[18px] py-8 text-center">
                        <Inbox :size="26" class="text-ink-3" />
                        <p class="text-[13px] text-ink-3">Još nema zabilježene aktivnosti.</p>
                    </div>

                    <div v-if="logovi.lastPage > 1" class="flex items-center justify-end border-t border-line px-[18px] py-2.5">
                        <MiniPager :page="logovi.page" :last-page="logovi.lastPage" @go="goLog($event)" />
                    </div>
                </Card>
            </div>
        </div>
    </div>

    <Teleport to="body">
        <Transition
            enter-active-class="transition-opacity duration-150 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-100 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="showForm" class="fixed inset-0 z-[60] flex items-start justify-center overflow-y-auto p-4 sm:p-8">
                <div class="absolute inset-0 bg-[#0f172a]/40" @click="showForm = false"></div>
                <div class="relative my-auto w-full max-w-[480px]">
                    <UserForm :korisnik="korisnik" @close="showForm = false" />
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
