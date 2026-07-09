import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import AuthenticatedLayout from './layouts/AuthenticatedLayout';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    progress: {
        color: '#262626',
    },
    // @ts-expect-error Inertia v3 resolve type mismatch with resolvePageComponent
    resolve: async (name) => {
        const page = await resolvePageComponent(`./pages/${name}.tsx`, import.meta.glob('./pages/**/*.tsx'));

        if (!name.startsWith('welcome') && !name.startsWith('auth/')) {
            const mod = page as { default: { layout?: React.ComponentType<{ children: React.ReactNode }> } };
            mod.default.layout = mod.default.layout || AuthenticatedLayout;
        }

        return page;
    },
});
