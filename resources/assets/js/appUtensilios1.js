/*
------------------------------------
Direccion ip
------------------------------------
*/

import getIp from './modules/globales.js';
/*
 **********************************************
 * TODOS LOS IMPORT
 **********************************************
 */
import Vue from 'vue';


import CssVuetify from 'vuetify/dist/vuetify.css';
import materialIcons from 'material-design-icons/iconfont/material-icons.css'

import Vuetify from 'vuetify';
Vue.use(Vuetify);
/*
------------------------------------
Para las rutas de vue
------------------------------------
*/
import VueRouter from 'vue-router';
Vue.use(VueRouter);

/*
------------------------------------
Para los request
------------------------------------
*/
import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);
/*
------------------------------------
Para imprimir en consola
------------------------------------
*/
const options = {
    logLevel: 'debug',
    stringifyArguments: false,
    showLogLevel: false
}

import VueLogger from 'vuejs-logger'
Vue.use(VueLogger, options)
/*
------------------------------------
Mascara de las entradas
------------------------------------
*/
import VueMask from 'di-vue-mask'
Vue.use(VueMask);


/*
 **********************************************
 * LAS VISTAS
 **********************************************
 */
import master from './Utensilios/uten_master.vue'
import home from './Utensilios/uten_home.vue'


import uten_display from './Utensilios/Utensilios/uten_display.vue'
import uten_nuevo from './Utensilios/Utensilios/uten_nuevo.vue'
import uten_editar from './Utensilios/Utensilios/uten_editar.vue'



import ucat_display from './Utensilios/Categorias/uCategoria_display.vue'
import ucat_nuevo from './Utensilios/Categorias/uCategoria_nuevo.vue'
import ucat_editar from './Utensilios/Categorias/uCategoria_editar.vue'


/*
 **********************************************
 * LAS RUTAS
 **********************************************
 */
const routes = [{
    name: 'master',
    path: '/',
    props: {
        ip: getIp()
    },
    component: master,
    children: [{
        name: 'utensilios',
        path: 'utensilios',
        props: {
            ip: getIp()
        },
        component: home,
        children: [
            {
                name: 'uten_display',
                path: 'uten_display',
                props: {
                    ip: getIp()
                },
                component: uten_display
            },
            {
                name: 'uten_nuevo',
                path: 'uten_nuevo',
                props: {
                    ip: getIp()
                },
                component: uten_nuevo
            },
            {
                name: 'uten_editar',
                path: 'uten_editar:id',
                props: {
                    ip: getIp()
                },
                component: uten_editar
            },

            /*
            +---------
            |Categorias
            +---------
            */
            {
                name: 'ucat_display',
                path: 'ucat_display',
                props: {
                    ip: getIp()
                },
                component: ucat_display
            },
            {
                name: 'ucat_nuevo',
                path: 'ucat_nuevo',
                props: {
                    ip: getIp()
                },
                component: ucat_nuevo
            },
            {
                name: 'ucat_editar',
                path: 'ucat_editar:id',
                props: {
                    ip: getIp()
                },
                component: ucat_editar
            },
        ]
    }]
}];


/*
 **********************************************
 * APP
 **********************************************
 */
const router = new VueRouter({
    mode: 'history',
    routes: routes
});

new Vue(Vue.util.extend({
    router
}, master)).$mount('#app');