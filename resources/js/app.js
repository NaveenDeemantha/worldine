import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const pages = import.meta.glob([
            './Frontend/Pages/**/*.vue',
            './Backend/Pages/**/*.vue',
            './Pages/**/*.vue',
        ]);

        if (pages[`./${name}.vue`]) {
            return pages[`./${name}.vue`]();
        }

        const possiblePaths = [
            `./Frontend/Pages/${name}.vue`,
            `./Backend/Pages/${name}.vue`,
            `./Pages/${name}.vue`,
        ];

        for (const path of possiblePaths) {
            if (pages[path]) {
                return pages[path]();
            }
        }

        return resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./**/*.vue'),
        );
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
