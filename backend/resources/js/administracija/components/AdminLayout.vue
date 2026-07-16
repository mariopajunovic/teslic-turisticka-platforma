<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Sidebar from './Sidebar.vue';
import Topbar from './Topbar.vue';
import ConfirmModal from './ConfirmModal.vue';
import ToastHost from './ToastHost.vue';
import { useToast } from '../composables/useToast';

const props = defineProps({
    title: { type: String, default: null },
});

const page = usePage();
const { push } = useToast();
const drawerOpen = ref(false);
const collapsed = ref(false);

watch(
    () => page.props?.flash,
    (flash) => {
        if (!flash) return;
        if (flash.status) push('Sačuvano', flash.status);
        if (flash.error) push('Greška', flash.error, 'bad');
    },
    { deep: true },
);

const pageTitle = computed(() => props.title ?? page.props?.title ?? '');

onMounted(() => {
    collapsed.value = localStorage.getItem('admin.sidebar.collapsed') === '1';
});

const toggleCollapse = () => {
    collapsed.value = !collapsed.value;
    localStorage.setItem('admin.sidebar.collapsed', collapsed.value ? '1' : '0');
};

watch(
    () => page.url,
    () => {
        drawerOpen.value = false;
    },
);
</script>

<template>
    <div class="flex min-h-screen bg-canvas">
        <Sidebar
            :open="drawerOpen"
            :collapsed="collapsed"
            @close="drawerOpen = false"
            @toggle-collapse="toggleCollapse"
        />

        <div class="flex min-w-0 flex-1 flex-col">
            <Topbar :title="pageTitle" @toggle="drawerOpen = !drawerOpen" @toggle-collapse="toggleCollapse">
                <template v-if="$slots.title" #title>
                    <slot name="title" />
                </template>
            </Topbar>

            <main class="flex-1 px-4 py-5 sm:px-6 sm:py-6">
                <slot />
            </main>
        </div>

        <ConfirmModal />
        <ToastHost />
    </div>
</template>
