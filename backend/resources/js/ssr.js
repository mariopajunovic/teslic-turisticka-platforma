import { createInertiaApp } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { renderToString } from '@vue/server-renderer';
import { createSSRApp, h } from 'vue';
import { createPinia } from 'pinia';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const appName = process.env.VITE_APP_NAME || 'TO Teslić';

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        title: (title) => (title ? `${title} — ${appName}` : appName),
        resolve: (name) => {
            const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
            const resolved = pages[`./Pages/${name}.vue`];
            if (resolved.default.layout === undefined && !name.startsWith('account/')) {
                resolved.default.layout = PublicLayout;
            }
            return resolved;
        },
        setup({ App, props, plugin }) {
            return createSSRApp({ render: () => h(App, props) }).use(plugin).use(createPinia());
        },
    }),
);
