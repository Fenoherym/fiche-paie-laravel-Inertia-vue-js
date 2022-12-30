require('./bootstrap');
require('../bootstrap/js/bootstrap.min.js')


import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'

import { InertiaProgress } from '@inertiajs/progress'
import Toaster from "@meforma/vue-toaster";

import VueAwesomePaginate from "vue-awesome-paginate";
import "vue-awesome-paginate/dist/style.css";

InertiaProgress.init()

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Toaster)
            .use(VueAwesomePaginate)
            .mount(el)
    },
})
