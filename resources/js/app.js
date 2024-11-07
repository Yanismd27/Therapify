import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import "@/Utils/toast.css"; // Importe ton CSS personnalisé après le CSS par défaut

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        
        app.use(plugin)
           .use(ZiggyVue)
           .use(Toast, {
               // Retire la configuration ici pour utiliser celle de ton fichier toast.js
               // Garde uniquement les options essentielles qui ne sont pas dans ton toast.js
               position: "top-right",
               timeout: 3000,
               closeOnClick: true,
               pauseOnHover: true,
               draggable: true,
               draggablePercent: 0.6,
               showCloseButtonOnHover: false,
               hideProgressBar: true,
               closeButton: "button",
           });

        return app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});