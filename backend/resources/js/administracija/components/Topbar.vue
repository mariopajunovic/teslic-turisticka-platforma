<script setup>
import { computed, ref, onMounted, onBeforeUnmount } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { Menu, Search, ChevronDown, Bell, LogOut, User } from 'lucide-vue-next';
import Avatar from './Avatar.vue';

defineProps({
    title: { type: String, default: '' },
});

const emit = defineEmits(['toggle', 'toggle-collapse']);

const page = usePage();
const admin = computed(() => page.props?.auth?.admin ?? null);
const initials = computed(() => admin.value?.initials ?? '');
const name = computed(() => admin.value?.name ?? 'Administrator');
const email = computed(() => admin.value?.email ?? '');

const menuOpen = ref(false);
const root = ref(null);

const onOutside = (e) => {
    if (root.value && !root.value.contains(e.target)) menuOpen.value = false;
};
const onEsc = (e) => {
    if (e.key === 'Escape') menuOpen.value = false;
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
            <div class="relative hidden md:block">
                <Search :size="16" class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-ink-3" />
                <input
                    type="search"
                    placeholder="Traži…"
                    class="h-9 w-60 rounded-md border border-line bg-surface-alt pl-9 pr-3 text-sm text-ink placeholder:text-ink-3 focus:border-brand focus:bg-surface focus:outline-none focus:ring-2 focus:ring-brand/20"
                />
            </div>

            <button
                type="button"
                class="hidden h-9 w-9 items-center justify-center rounded-md border border-line bg-surface-alt text-ink-2 hover:text-ink sm:inline-flex"
                aria-label="Obavještenja"
            >
                <Bell :size="18" />
            </button>

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
