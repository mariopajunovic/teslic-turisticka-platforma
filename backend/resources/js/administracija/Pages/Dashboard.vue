<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import {
    Inbox,
    UserPlus,
    Megaphone,
    CalendarDays,
    Check,
    Pencil,
    Eye,
    Plus,
    Trash2,
    LogIn,
    LogOut,
    Activity,
} from 'lucide-vue-next';
import Card from '../components/Card.vue';
import Badge from '../components/Badge.vue';
import StatCard from '../components/StatCard.vue';
import IconBtn from '../components/IconBtn.vue';
import EmptyState from '../components/EmptyState.vue';

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({ odobravanje: 0, naloziNaOdobrenju: 0, aktivniOglasi: 0, dogadjaji: 0 }),
    },
    red: { type: Array, default: () => [] },
    aktivnosti: { type: Array, default: () => [] },
});

const page = usePage();
const ime = computed(() => (page.props?.auth?.admin?.name ?? '').split(' ')[0] || 'administratore');

const statCards = [
    { key: 'odobravanje', label: 'Sadržaj na odobrenju', icon: Inbox, color: 'warn', caption: 'Čeka pregled administratora' },
    { key: 'naloziNaOdobrenju', label: 'Nalozi na odobrenju', icon: UserPlus, color: 'info', caption: 'Nove registracije' },
    { key: 'aktivniOglasi', label: 'Aktivni oglasi', icon: Megaphone, color: 'ok', caption: 'Trenutno objavljeno' },
    { key: 'dogadjaji', label: 'Nadolazeći događaji', icon: CalendarDays, color: 'brand', caption: 'U narednih 30 dana' },
];

const iconMap = {
    'log-in': LogIn,
    'log-out': LogOut,
    plus: Plus,
    'trash-2': Trash2,
    pencil: Pencil,
    check: Check,
};

const resolveIcon = (name) => iconMap[name] ?? Activity;

const iconWrap = (boja) => {
    return {
        brand: 'text-brand bg-brand-tint',
        ok: 'text-ok bg-ok-bg',
        warn: 'text-warn bg-warn-bg',
        bad: 'text-bad bg-bad-bg',
        info: 'text-info bg-info-bg',
        gray: 'text-ink-2 bg-surface-alt',
    }[boja] ?? 'text-ink-2 bg-surface-alt';
};
</script>

<template>
    <Head title="Nadzorna ploča" />

    <div class="space-y-6">
        <header>
            <h1 class="text-[22px] font-bold text-ink">Pregled</h1>
            <p class="mt-1 text-sm text-ink-2">Dobrodošao natrag, {{ ime }}. Evo šta se dešava na portalu.</p>
        </header>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <StatCard
                v-for="card in statCards"
                :key="card.key"
                :label="card.label"
                :value="stats[card.key] ?? 0"
                :caption="card.caption"
                :icon="card.icon"
                :color="card.color"
            />
        </div>

        <div class="grid grid-cols-1 gap-5 lg:grid-cols-[1fr_400px]">
            <Card title="Red odobravanja" :count="red.length" :padded="false">
                <div v-if="red.length" class="divide-y divide-line">
                    <div
                        v-for="(item, i) in red"
                        :key="i"
                        class="flex items-center gap-3 px-[18px] py-3"
                    >
                        <Badge :label="item.tip" :color="item.tipBoja" class="w-24 shrink-0 justify-center" />
                        <div class="min-w-0 flex-1">
                            <Link :href="item.url || '#'" class="block truncate text-[13px] font-semibold text-ink hover:text-brand">
                                {{ item.naslov }}
                            </Link>
                            <p class="truncate text-xs text-ink-3">{{ item.meta }}</p>
                        </div>
                        <span v-if="item.datum" class="hidden shrink-0 text-[11px] text-ink-3 sm:block">{{ item.datum }}</span>
                        <div class="flex shrink-0 items-center gap-1.5">
                            <IconBtn :icon="Eye" color="brand" tooltip="Pregledaj izmjene i odobri" :href="item.url" />
                        </div>
                    </div>
                </div>
                <div v-else class="p-5">
                    <EmptyState
                        :icon="Inbox"
                        title="Nema stavki na čekanju"
                        text="Sav sadržaj je pregledan. Nove stavke pojaviće se ovdje."
                    />
                </div>
            </Card>

            <Card title="Nedavna aktivnost" :padded="false">
                <div v-if="aktivnosti.length" class="divide-y divide-line">
                    <div
                        v-for="(log, i) in aktivnosti"
                        :key="i"
                        class="flex items-start gap-3 px-[18px] py-3"
                    >
                        <span
                            :class="iconWrap(log.boja)"
                            class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full"
                        >
                            <component :is="resolveIcon(log.icon)" :size="16" />
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="text-[13px] text-ink"><span class="font-semibold">{{ log.ko }}</span> {{ log.tekst }}</p>
                            <p class="text-xs text-ink-3">{{ log.vrijeme }}</p>
                        </div>
                    </div>
                </div>
                <div v-else class="p-5">
                    <EmptyState
                        :icon="Activity"
                        title="Nema zabilježene aktivnosti"
                        text="Radnje administratora i korisnika prikazaće se ovdje."
                    />
                </div>
            </Card>
        </div>
    </div>
</template>
