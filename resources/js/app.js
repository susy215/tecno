import './bootstrap';
import '../css/app.css';
import "flowbite";

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
// import { Ziggy } from './ziggy'; // ← IMPORTANTE
import { i18nVue } from 'laravel-vue-i18n';
import { InertiaProgress } from '@inertiajs/progress';
import ElementPlus from 'element-plus';
import 'element-plus/dist/index.css';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// import messages from './locales';


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

window.Pusher = Pusher;



createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, window.Ziggy) // ← AQUÍ
            .use(ElementPlus)
            .use(i18nVue, {
                resolve: async lang => {
                const langs = import.meta.glob('../../lang/*.json');
                return await langs[`../../lang/${lang}.json`]();
                }
                })
                .mount('#app')

    },
    progress: {
        color: '#4B5563',
    },
});
InertiaProgress.init({ color: '#4B5563' });
