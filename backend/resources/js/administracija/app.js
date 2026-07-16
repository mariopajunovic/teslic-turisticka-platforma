import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import AdminLayout from './components/AdminLayout.vue';

const NO_LAYOUT = ['Prijava', 'Dvofaktorska', 'PostaviLozinku', 'PostaviDvofaktorsku', 'ZaboravljenaLozinka', 'RezervniKodovi'];

createInertiaApp({
    title: (title) => (title ? `${title} - Administracija` : 'Administracija · TO Teslić'),
    resolve: async (name) => {
        const page = await resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        );
        if (page.default.layout === undefined && !NO_LAYOUT.includes(name)) {
            page.default.layout = AdminLayout;
        }
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
    progress: {
        color: '#0E8275',
    },
});
