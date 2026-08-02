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
        const pages = import.meta.glob('./**/*.vue');
        
        const possiblePaths = [
            `./${name}.vue`,
            `./Frontend/Pages/${name}.vue`,
            `./Backend/Pages/${name}.vue`,
            `./Pages/${name}.vue`,
        ];

        for (const path of possiblePaths) {
            if (pages[path]) {
                return resolvePageComponent(path, pages);
            }
        }

        return resolvePageComponent(`./${name}.vue`, pages);
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#2196F3',
    },
});
