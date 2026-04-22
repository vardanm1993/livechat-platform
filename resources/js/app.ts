import '../css/app.css';

import {createApp, h, type DefineComponent} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';

void createInertiaApp({
    title: (title) => (title ? `${title} | ${import.meta.env.VITE_APP_NAME ?? 'Livechat Platform'}` : import.meta.env.VITE_APP_NAME ?? 'Livechat Platform'),
    resolve: (name) =>
        resolvePageComponent<DefineComponent>(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),

    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .mount(el);
    },

    progress: {
        color: '#4B5563',
    },
});
