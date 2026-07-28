<script setup>
import { computed, ref, onMounted, onBeforeUnmount } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { Menu, Search, ChevronDown, Bell, LogOut, User } from 'lucide-vue-next';
import Avatar from './Avatar.vue';
import Badge from './Badge.vue';

defineProps({
    title: { type: String, default: '' },
});

const emit = defineEmits(['toggle', 'toggle-collapse']);

const page = usePage();
const admin = computed(() => page.props?.auth?.admin ?? null);
const initials = computed(() => admin.value?.initials ?? '');
const name = computed(() => admin.value?.name ?? 'Administrator');
const email = computed(() => admin.value?.email ?? '');
const brojObavijesti = computed(() => page.props?.badges?.obavijesti ?? 0);

const menuOpen = ref(false);
const root = ref(null);

const bellOpen = ref(false);
const bellRoot = ref(null);
const obavijesti = ref([]);
const obavUcitava = ref(false);

const searchRoot = ref(null);
const upit = ref('');
const rezultati = ref([]);
const pretragaUcitava = ref(false);
const pretragaOpen = ref(false);
let pretragaTimer = null;
let pretragaSeq = 0;

const imaRezultata = computed(() => rezultati.value.some((g) => g.stavke?.length));

const traziSad = async (q) => {
    const seq = ++pretragaSeq;
    pretragaUcitava.value = true;
    try {
        const r = await fetch(`/administracija/pretraga?q=${encodeURIComponent(q)}`, {
            headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        });
        const data = await r.json();
        if (seq === pretragaSeq) rezultati.value = Array.isArray(data.grupe) ? data.grupe : [];
    } catch (e) {
        if (seq === pretragaSeq) rezultati.value = [];
    } finally {
        if (seq === pretragaSeq) pretragaUcitava.value = false;
    }
};

const naUpit = () => {
    const q = upit.value.trim();
    pretragaOpen.value = true;
    if (pretragaTimer) clearTimeout(pretragaTimer);
    if (q.length < 2) {
        rezultati.value = [];
        pretragaUcitava.value = false;
        return;
    }
    pretragaTimer = setTimeout(() => traziSad(q), 250);
};

const otvoriRezultat = (url) => {
    pretragaOpen.value = false;
    upit.value = '';
    rezultati.value = [];
    router.visit(url);
};

const ucitajObavijesti = async () => {
    obavUcitava.value = true;
    try {
        const r = await fetch('/administracija/obavijesti', {
            headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        });
        const data = await r.json();
        obavijesti.value = Array.isArray(data.stavke) ? data.stavke : [];
    } catch (e) {
        obavijesti.value = [];
    } finally {
        obavUcitava.value = false;
    }
};

const toggleBell = () => {
    bellOpen.value = !bellOpen.value;
    if (bellOpen.value) ucitajObavijesti();
};

const otvori = (url) => {
    bellOpen.value = false;
    router.visit(url);
};

const onOutside = (e) => {
    if (root.value && !root.value.contains(e.target)) menuOpen.value = false;
    if (bellRoot.value && !bellRoot.value.contains(e.target)) bellOpen.value = false;
    if (searchRoot.value && !searchRoot.value.contains(e.target)) pretragaOpen.value = false;
};
const onEsc = (e) => {
    if (e.key === 'Escape') {
        menuOpen.value = false;
        bellOpen.value = false;
        pretragaOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', onOutside);
    document.addEventListener('keydown', onEsc);
});
onBeforeUnmount(() => {
    document.removeEventListener('click', onOutside);
    document.removeEventListener('keydown', onEsc);
});

const odjava = () => {
    menuOpen.value = false;
    router.post('/administracija/odjava');
};
</script>

<template>
    <header class="sticky top-0 z-30 flex h-[60px] items-center justify-between gap-3 border-b border-line bg-surface px-4 sm:px-6">
        <div class="flex min-w-0 items-center gap-3.5">
            <button
                type="button"
                class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-md border border-line bg-surface-alt text-ink-2 hover:text-ink lg:hidden"
                aria-label="Otvori meni"
                @click="emit('toggle')"
            >
                <Menu :size="18" />
            </button>

            <h1 class="min-w-0 truncate text-[19px] font-bold text-ink">
                <slot name="title">{{ title }}</slot>
            </h1>
        </div>

        <div class="flex items-center gap-2 sm:gap-3.5">
            <div ref="searchRoot" class="relative hidden md:block">
                <Search :size="16" class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-ink-3" />
                <input
                    v-model="upit"
                    type="search"
                    placeholder="Traži biznise, stranice, korisnike…"
                    autocomplete="off"
                    class="h-9 w-60 rounded-md border border-line bg-surface-alt pl-9 pr-3 text-sm text-ink placeholder:text-ink-3 focus:border-brand focus:bg-surface focus:outline-none focus:ring-2 focus:ring-brand/20 lg:w-72"
                    @input="naUpit"
                    @focus="pretragaOpen = true"
                />

                <transition
                    enter-active-class="transition duration-100 ease-out"
                    enter-from-class="opacity-0 scale-95"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="transition duration-75 ease-in"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-95"
                >
                    <div
                        v-if="pretragaOpen && upit.trim().length >= 2"
                        class="absolute right-0 mt-2 w-80 origin-top-right overflow-hidden rounded-[var(--radius-card)] border border-line bg-surface shadow-[var(--shadow-pop)]"
                    >
                        <p v-if="pretragaUcitava" class="px-3 py-6 text-center text-[13px] text-ink-3">Pretraga…</p>
                        <div v-else-if="imaRezultata" class="max-h-[70vh] overflow-y-auto py-1">
                            <div v-for="grupa in rezultati" :key="grupa.tip">
                                <template v-if="grupa.stavke?.length">
                                    <p class="px-3 pb-1 pt-2 text-[11px] font-bold uppercase tracking-wide text-ink-3">{{ grupa.tip }}</p>
                                    <button
                                        v-for="(s, i) in grupa.stavke"
                                        :key="grupa.tip + i"
                                        type="button"
                                        class="flex w-full flex-col items-start gap-0.5 px-3 py-2 text-left hover:bg-surface-alt"
                                        @click="otvoriRezultat(s.url)"
                                    >
                                        <span class="w-full truncate text-[13px] font-semibold text-ink">{{ s.naslov }}</span>
                                        <span v-if="s.meta" class="w-full truncate text-xs text-ink-3">{{ s.meta }}</span>
                                    </button>
                                </template>
                            </div>
                        </div>
                        <p v-else class="px-3 py-6 text-center text-[13px] text-ink-3">Nema rezultata za „{{ upit.trim() }}".</p>
                    </div>
                </transition>
            </div>

            <div ref="bellRoot" class="relative hidden sm:block">
                <button
                    type="button"
                    class="relative inline-flex h-9 w-9 items-center justify-center rounded-md border border-line bg-surface-alt text-ink-2 hover:text-ink"
                    aria-label="Obavještenja"
                    @click="toggleBell"
                >
                    <Bell :size="18" />
                    <span
                        v-if="brojObavijesti > 0"
                        class="absolute -right-1 -top-1 flex h-4 min-w-4 items-center justify-center rounded-full bg-bad px-1 text-[10px] font-bold text-white"
                    >{{ brojObavijesti > 9 ? '9+' : brojObavijesti }}</span>
                </button>

                <transition
                    enter-active-class="transition duration-100 ease-out"
                    enter-from-class="opacity-0 scale-95"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="transition duration-75 ease-in"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-95"
                >
                    <div
                        v-if="bellOpen"
                        class="absolute right-0 mt-2 w-80 origin-top-right overflow-hidden rounded-[var(--radius-card)] border border-line bg-surface shadow-[var(--shadow-pop)]"
                    >
                        <div class="flex items-center justify-between border-b border-line px-3 py-2.5">
                            <p class="text-sm font-bold text-ink">Obavještenja</p>
                            <span v-if="brojObavijesti > 0" class="text-xs text-ink-3">{{ brojObavijesti }} na čekanju</span>
                        </div>

                        <div class="max-h-[70vh] overflow-y-auto">
                            <p v-if="obavUcitava" class="px-3 py-6 text-center text-[13px] text-ink-3">Učitavanje…</p>
                            <template v-else-if="obavijesti.length">
                                <button
                                    v-for="(o, i) in obavijesti"
                                    :key="i"
                                    type="button"
                                    class="flex w-full items-start gap-2.5 border-b border-line px-3 py-2.5 text-left last:border-0 hover:bg-surface-alt"
                                    @click="otvori(o.url)"
                                >
                                    <Badge :label="o.tip" :color="o.tipBoja" class="w-28 shrink-0 justify-center" />
                                    <span class="min-w-0 flex-1">
                                        <span class="block truncate text-[13px] font-semibold text-ink">{{ o.naslov }}</span>
                                        <span class="block truncate text-xs text-ink-3">{{ o.meta }}</span>
                                        <span v-if="o.datum" class="mt-0.5 block text-[11px] text-ink-3">{{ o.datum }}</span>
                                    </span>
                                </button>
                            </template>
                            <p v-else class="px-3 py-6 text-center text-[13px] text-ink-3">Nema novih obavještenja.</p>
                        </div>
                    </div>
                </transition>
            </div>

            <div ref="root" class="relative">
                <button
                    type="button"
                    class="flex items-center rounded-full ring-offset-2 ring-offset-surface hover:ring-2 hover:ring-brand/30"
                    aria-label="Nalog"
                    @click="menuOpen = !menuOpen"
                >
                    <Avatar :initials="initials" size="sm" variant="solid" />
                </button>

                <transition
                    enter-active-class="transition duration-100 ease-out"
                    enter-from-class="opacity-0 scale-95"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="transition duration-75 ease-in"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-95"
                >
                    <div
                        v-if="menuOpen"
                        class="absolute right-0 mt-2 w-56 origin-top-right rounded-[var(--radius-card)] border border-line bg-surface py-1 shadow-[var(--shadow-pop)]"
                    >
                        <div class="border-b border-line px-3 py-2.5">
                            <p class="truncate text-sm font-medium text-ink">{{ name }}</p>
                            <p v-if="email" class="truncate text-xs text-ink-3">{{ email }}</p>
                        </div>
                        <Link
                            href="/administracija/profil"
                            class="flex items-center gap-2.5 px-3 py-2 text-sm text-ink-2 hover:bg-surface-alt hover:text-ink"
                            @click="menuOpen = false"
                        >
                            <User :size="16" /> Moj profil
                        </Link>
                        <button
                            type="button"
                            class="flex w-full items-center gap-2.5 px-3 py-2 text-left text-sm text-bad hover:bg-bad-bg"
                            @click="odjava"
                        >
                            <LogOut :size="16" /> Odjava
                        </button>
                    </div>
                </transition>
            </div>
        </div>
    </header>
</template>
