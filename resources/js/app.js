require('./bootstrap');

// Import modules...
import {createApp, h, provide} from 'vue';
import {App as InertiaApp, plugin as InertiaPlugin} from '@inertiajs/inertia-vue3';
import {InertiaProgress} from '@inertiajs/progress';

const el = document.getElementById('app');
import ElementPlus from 'element-plus';
import locale from 'element-plus/lib/locale/lang/ar'
// import 'dayjs/locale/ar'
import 'element-plus/lib/theme-chalk/index.css';
// import './../scss/_element-variables.scss'
import Helper from './helper'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import apolloClient from './graphql-client';


createApp({
    setup () {
        provide( apolloClient)
    },
    render: () =>
            h(InertiaApp, {
                initialPage: JSON.parse(el.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            }),
    })
    .mixin({methods: {route}})
    .use(InertiaPlugin)
    .use(Helper)
    .use(VueSweetalert2, {
        confirmButtonColor: '#44bd32',
        cancelButtonColor: '#ff7674',
    })
    .use(ElementPlus, {locale})
    .mount(el);

InertiaProgress.init({color: '#4B5563'});
