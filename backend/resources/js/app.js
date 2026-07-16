import { createApp, h } from 'vue';
import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createPinia } from 'pinia';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { i18n, resolveUiLocale, applyMessages } from '@/i18n';

const appName = import.meta.env.VITE_APP_NAME || 'TO Teslić';

// Non-localized first path segments (Fortify auth, toggles, assets, prefixes).
const NON_LOCALIZED = new Set([
    'login', 'logout', 'register', 'forgot-password', 'reset-password', 'user',
    'storage', 'build', 'pismo', 'admin', 'administracija', 'sitemap.xml', 'robots.txt',
    'odrzavanje', 'up', 'email', 'two-factor-challenge', 'livewire',
]);

let languagePrefixes = new Set(['en', 'de']);

function activeLanguagePrefix() {
    const seg = window.location.pathname.split('/')[1];
    return languagePrefixes.has(seg) ? seg : '';
}

// Keep internal Inertia navigations inside the active language prefix,
// so hardcoded hrefs like "/turizam" become "/en/turizam" automatically.
router.on('before', (event) => {
    const url = event.detail.visit.url;
    if (!url || url.origin !== window.location.origin) return;

    const prefix = activeLanguagePrefix();
    if (!prefix) return;

    const seg = url.pathname.split('/')[1];
    if (NON_LOCALIZED.has(seg) || languagePrefixes.has(seg)) return;

    url.pathname = `/${prefix}${url.pathname === '/' ? '' : url.pathname}`;
});

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: async (name) => {
        const page = await resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        );
        if (page.default.layout === undefined && !name.startsWith('account/')) {
            page.default.layout = PublicLayout;
        }
        return page;
    },
    setup({ el, App, props, plugin }) {
        const locale = props.initialPage?.props?.locale;
        if (locale?.languages) {
            languagePrefixes = new Set(locale.languages.map((l) => l.prefix).filter(Boolean));
        }

        const shared = props.initialPage?.props?.i18n;
        if (shared) applyMessages(shared.language, shared.messages);
        i18n.global.locale.value = resolveUiLocale(locale);

        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(createPinia())
            .use(i18n)
            .mount(el);
    },
    progress: {
        color: '#0E8275',
    },
});
