/*
------------------------------------
Direccion ip
------------------------------------
*/

import getIp from './modules/globales.js';

//var getIp() = 'http://192.168.43.189:8000/';
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
import master from './Proveedores/master.vue'
import home from './Proveedores/home.vue'



import articulo from './Proveedores/articulo/articulo.vue'
import articulo2 from './Proveedores/articulo/articulo2.vue'
import articulo_editar from './Proveedores/articulo/editar.vue'
import articulo_nuevo from './Proveedores/articulo/nuevo.vue'

import ingreso_listadoC from './Proveedores/cancelados/listado.vue'
import ingreso_detalleC from './Proveedores/cancelados/ingreso_detalle.vue'


import ingreso_listado from './Proveedores/deudas/listado.vue'
import ingreso_detalle from './Proveedores/deudas/ingreso_detalle.vue'

import ingreso from './Proveedores/ingreso/nuevo.vue'


/*
 **********************************************
 * LAS RUTAS
 **********************************************
 */
const routes = [{
    name: 'master',
    path: '/',
    component: master,
    props: {ip: getIp()},
    children: [{
        name: 'proveedores',
        path: 'proveedores',
        component: home,
        props: {ip: getIp()},
        children: [
            {
                name: 'articulo',
                path: 'articulo',
                props: {ip: getIp()},
                component: articulo,
            },
            {
                name: 'articulo2',
                path: 'articulo2',
                props: {ip: getIp()},
                component: articulo2,
            },
            {
                name: 'articulo_nuevo',
                path: 'articulo_nuevo',
                props: {ip: getIp()},
                component: articulo_nuevo,
            },
            {
                name: 'articulo_editar',
                path: 'articulo_editar:id',
                props: {ip: getIp()},
                component: articulo_editar,
            },

            {
                name: 'ingreso_listado',
                path: 'ingreso_listado:id',
                props: {ip: getIp()},
                component: ingreso_listado,
            },
            {
                name: 'ingreso_detalle',
                path: 'ingreso_detalle:id:proveedor:total:tipo:num:fecha',
                props: {ip: getIp()},
                component: ingreso_detalle,
            },,

            {
                name: 'ingreso_listadoC',
                path: 'ingreso_listadoC:id',
                props: {ip: getIp()},
                component: ingreso_listadoC,
            },
            {
                name: 'ingreso_detalleC',
                path: 'ingreso_detalleC:id:proveedor:total:tipo:num:fecha',
                props: {ip: getIp()},
                component: ingreso_detalleC,
            },
            {
                name: 'ingreso',
                path: 'ingreso',
                props: {ip: getIp()},
                component: ingreso,
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