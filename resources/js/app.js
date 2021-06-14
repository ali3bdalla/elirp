require('./bootstrap');

// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";import { InertiaProgress } from '@inertiajs/progress';
import ElementPlus from 'element-plus';
import locale from 'element-plus/lib/locale/lang/ar'
import 'dayjs/locale/ar'
import 'element-plus/lib/theme-chalk/index.css';
import './../scss/_element-variables.scss'
const el = document.getElementById('app');
createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})
    .mixin({ methods: { route } })
    .use(ElementPlus,{locale})
    .use(InertiaPlugin)
    .use( Menu)
    .use(MenuButton)
    .use(MenuItems)
    .use( MenuItem)
    .mount(el);

InertiaProgress.init({ color: '#4B5563' });
