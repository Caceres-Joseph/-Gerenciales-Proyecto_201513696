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

//************************
//  Vistas
//************************

import master from './ordenes/ordenes_master.vue'
import ordenes from './ordenes/ordenes_home.vue'

import lugar from './ordenes/lugares/lugar.vue'
import mesas from './ordenes/mesas/ordenes_mesas.vue'
import orden from './ordenes/orden/ordenes_orden.vue'

import sirviendo from './ordenes/sirviendo/sirviendo_orden.vue'

/* import eliminarOrden from './ordenes/eliminar/ordenes_eliminar.vue' */

import login from './ordenes/login/login.vue'

import opciones from './ordenes/opciones/opciones.vue'

import dividir from './ordenes/dividir/dividir.vue'

import cuarentena from './ordenes/cuarentena/cuarentena.vue'

import detalleOrden from './ordenes/detalleOrden/detalleOrden.vue'
//************************
//  Rutas
//************************
const routes = [

    {
        name: 'login',
        path: 'login ',
        props: {ip: getIp()},
        component: login,
    },
    {
        name: 'master',
        path: '/',
        props: {ip: getIp()},
        component: master,
        children: [{
            name: 'ordenes',
            path: 'ordenes',
            props: {ip: getIp()},
            component: ordenes,
            children: [{
                name: 'lugar',
                path: 'lugar',
                props: {ip: getIp()},
                component: lugar,
            },
                {
                    name: 'mesas',
                    path: 'mesas:id:color',
                    props: {ip: getIp()},
                    component: mesas,
                },
                {
                    name: 'sirviendo',
                    path: 'sirviendo',
                    props: {ip: getIp()},
                    component: sirviendo,
                },
                {
                    name: 'opciones',
                    path: 'opciones',
                    props: {ip: getIp()},
                    component: opciones,
                },
                {
                    name: 'dividir',
                    path: 'dividir:id',
                    props: {ip: getIp()},
                    component: dividir,
                },
                {
                    name: 'cuarentena',
                    path: 'cuarentena',
                    props: {ip: getIp()},
                    component: cuarentena,
                },
                {
                    name: 'detalleOrden',
                    path: 'detalleOrden:id',
                    props: {ip: getIp()},
                    component: detalleOrden,
                },
                {
                    name: 'orden',
                    path: 'orden:id',
                    props: {ip: getIp()},
                    component: orden,
                },

            ]
        }
        ]
    }

];


const router = new VueRouter({
    mode: 'history',
    routes: routes
});


new Vue(Vue.util.extend({
    router
}, master)).$mount('#app');