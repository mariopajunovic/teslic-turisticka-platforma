<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import SidebarItem from './SidebarItem.vue';
import {
    LayoutDashboard,
    Users,
    ShieldCheck,
    KeyRound,
    ScrollText,
    Languages,
    Globe,
    Settings,
    FileText,
    Store,
    Tag,
    PanelLeft,
    X,
} from 'lucide-vue-next';

defineProps({
    open: { type: Boolean, default: false },
    collapsed: { type: Boolean, default: false },
});

const emit = defineEmits(['close', 'toggle-collapse']);

const page = usePage();

const groups = [
    {
        label: null,
        items: [{ icon: LayoutDashboard, label: 'Nadzorna ploča', href: '/administracija' }],
    },
    {
        label: 'Sadržaj',
        items: [
            { icon: FileText, label: 'Stranice', href: '/administracija/stranice' },
            { icon: Store, label: 'Biznisi', href: '/administracija/biznisi' },
        ],
    },
    {
        label: 'Taksonomija',
        items: [
            { icon: Tag, label: 'Kategorije', href: '/administracija/kategorije' },
        ],
    },
    {
        label: 'Sistem',
        items: [
            { icon: Users, label: 'Korisnici', href: '/administracija/korisnici' },
            { icon: ShieldCheck, label: 'Administratori', href: '/administracija/administratori' },
            { icon: KeyRound, label: 'Uloge', href: '/administracija/uloge' },
            { icon: ScrollText, label: 'Logovi aktivnosti', href: '/administracija/logovi' },
        ],
    },
    {
        label: 'Postavke',
        items: [
            { icon: Settings, label: 'Postavke sajta', href: '/administracija/postavke' },
            { icon: Languages, label: 'Prevodi', href: '/administracija/prevodi' },
            { icon: Globe, label: 'Jezici', href: '/administracija/jezici' },
        ],
    },
];

const isActive = (href) => {
    if (!href || href === '#') return false;
    const url = page.url || '';
    if (href === '/administracija') {
        return url === '/administracija' || url === '/administracija/';
    }
    return url === href || url.startsWith(href + '/') || url.startsWith(href + '?');
};
</script>

<template>
    <aside
        class="hidden lg:flex lg:shrink-0 lg:flex-col bg-sidebar transition-[width] duration-200"
        :class="collapsed ? 'lg:w-[64px]' : 'lg:w-[230px]'"
    >
        <div
            class="flex h-[46px] items-center"
            :class="collapsed ? 'justify-center' : 'px-4'"
        >
            <button
                type="button"
                class="inline-flex h-8 w-8 items-center justify-center rounded-md text-sidebar-group hover:bg-sidebar-alt hover:text-sidebar-strong"
                aria-label="Skupi meni"
                @click="emit('toggle-collapse')"
            >
                <PanelLeft :size="19" />
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto overflow-x-hidden pb-5 pt-1">
            <template v-for="(group, gi) in groups" :key="gi">
                <p
                    v-if="group.label && !collapsed"
                    class="px-4 pb-1.5 pt-4 text-[11px] font-bold uppercase tracking-wider text-sidebar-group"
                >
                    {{ group.label }}
                </p>
                <div v-else-if="group.label" class="pt-4"></div>
                <div :class="collapsed ? 'space-y-1 px-2' : 'space-y-px'">
                    <SidebarItem
                        v-for="item in group.items"
                        :key="item.label"
                        :icon="item.icon"
                        :label="item.label"
                        :href="item.href"
                        :active="isActive(item.href)"
                        :collapsed="collapsed"
                    />
                </div>
            </template>
        </nav>
    </aside>

    <div v-if="open" class="lg:hidden">
        <div class="fixed inset-0 z-40 bg-black/50" @click="emit('close')"></div>
        <aside class="fixed inset-y-0 left-0 z-50 flex w-64 max-w-[85%] flex-col bg-sidebar shadow-[var(--shadow-pop)]">
            <div class="flex h-[46px] items-center justify-between px-4">
                <span class="text-[13px] font-semibold uppercase tracking-wide text-sidebar-group">Administracija</span>
                <button
                    type="button"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-md text-sidebar-text hover:bg-sidebar-alt hover:text-sidebar-strong"
                    aria-label="Zatvori"
                    @click="emit('close')"
                >
                    <X :size="18" />
                </button>
            </div>
            <nav class="flex-1 overflow-y-auto pb-5 pt-1" @click="emit('close')">
                <template v-for="(group, gi) in groups" :key="gi">
                    <p
                        v-if="group.label"
                        class="px-4 pb-1.5 pt-4 text-[11px] font-bold uppercase tracking-wider text-sidebar-group"
                    >
                        {{ group.label }}
                    </p>
                    <div class="space-y-px">
                        <SidebarItem
                            v-for="item in group.items"
                            :key="item.label"
                            :icon="item.icon"
                            :label="item.label"
                            :href="item.href"
                            :active="isActive(item.href)"
                        />
                    </div>
                </template>
            </nav>
        </aside>
    </div>
</template>
