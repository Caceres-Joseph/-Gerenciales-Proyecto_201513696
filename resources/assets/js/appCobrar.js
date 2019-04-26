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
------------------------------------
Mascara de las entradas
------------------------------------
*/

Vue.use(require('vue-shortkey'));
 
//************************
//  Vistas
//************************

import master from './cobrar/cobrar_master.vue'
import cobrar from './cobrar/cobrar_home.vue'

import lugar from './cobrar/lugares/cobrar_lugar.vue'
import mesas from './cobrar/mesas/cobrar_mesas.vue'
import orden from './cobrar/orden/cobrar_orden.vue'
import ordenesMesa from './cobrar/ordenesMesas/cobrar_ordenesMesas.vue';

import sirviendo from './cobrar/sirviendo/cobrar_sirviendo.vue'

import constancia from './cobrar/constancia/cobrar_constancia.vue';

import caja from './cobrar/caja/caja.vue'

import opciones from './cobrar/caja/opciones/opciones.vue'
 import nuevo_gasto from './cobrar/caja/opciones/gasto/nuevo_gasto.vue' 
import nuevo_abono from './cobrar/caja/opciones/abono/nuevo_abono.vue' 

import detalles from './cobrar/caja/detalles/detalles.vue'
import detalle_abono from './cobrar/caja/detalles/detalle_abono/detalle_abono.vue'
import detalle_gasto from './cobrar/caja/detalles/detalle_gasto/detalle_gasto.vue' 
import detalle_venta from './cobrar/caja/detalles/detalle_ventas/detalle_ventas.vue' 

import caja_operacion from './cobrar/caja/caja/caja.vue'
import abrir_caja from './cobrar/caja/caja/abrir_caja/abrir_caja.vue'
import cerrar_caja from './cobrar/caja/caja/cerrar_caja/cerrar_caja.vue'

import dividir from './cobrar/dividir/dividir.vue'

import cuarentena from './cobrar/cuarentena/cuarentena.vue'

import detalleOrden from './cobrar/detalleOrden/detalleOrden.vue'

import correo from './cobrar/Correo/correo.vue'


//************************
//  Rutas
//************************
const routes = [{
        name: 'master',
        path: '/',
        props: {ip: getIp()},
        component: master,
        children: [{
                name: 'cobrar',
                path: 'cobrar',
                props: {ip: getIp()},
                component: cobrar,
                children: [

                    {
                        name: 'correo',
                        path: 'correo',
                        component: correo,
                    },
                    {
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
                        name: 'dividir',
                        path: 'dividir:id',
                        props: {ip: getIp()},
                        component: dividir,
                    },
                    {
                        name: 'sirviendo',
                        path: 'sirviendo',
                        props: {ip: getIp()},
                        component: sirviendo,
                    },
                    {
                        name: 'ordenesMesa',
                        path: 'ordenesMesa',
                        props: {ip: getIp()},
                        component: ordenesMesa,
                    },
                    {
                        name: 'constancia',
                        path: 'constancia:id',
                        props: {ip: getIp()},
                        component: constancia,
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
                        name: 'caja',
                        path: 'caja',
                        props: {ip: getIp()},
                        component: caja,
                        children: [
                            {
                                name: 'caja_operacion', 
                                path: 'caja_operacion', 
                                props: {ip: getIp()},
                                component: caja_operacion,
                                children: [
                                       {
                                        name: 'abrir_caja', 
                                        path: 'abrir_caja', 
                                        props: {ip: getIp()},
                                        component: abrir_caja
                                    },  
                                     {
                                        name: 'cerrar_caja', 
                                        path: 'cerrar_caja', 
                                        props: {ip: getIp()},
                                        component: cerrar_caja
                                    },  

                                ]
                            },
                            {
                                name: 'opciones', 
                                path: 'opciones', 
                                props: {ip: getIp()},
                                component: opciones,
                                children: [
                                       {
                                        name: 'nuevo_abono', 
                                        path: 'nuevo_abono', 
                                        props: {ip: getIp()},
                                        component: nuevo_abono
                                    },  
                                     {
                                        name: 'nuevo_gasto', 
                                        path: 'nuevo_gasto', 
                                        props: {ip: getIp()},
                                        component: nuevo_gasto
                                    },  

                                ]
                            },
                            {
                                name: 'detalles', 
                                path: 'detalles', 
                                props: {ip: getIp()},
                                component: detalles,
                                children: [
                                    {
                                        name: 'detalle_gasto', 
                                        path: 'detalle_gasto', 
                                        props: {ip: getIp()},
                                        component: detalle_gasto
                                    },
                                    {
                                        name: 'detalle_abono', 
                                        path: 'detalle_abono', 
                                        props: {ip: getIp()},
                                        component: detalle_abono 
                                    },    
                                    {
                                        name: 'detalle_venta', 
                                        path: 'detalle_venta', 
                                        props: {ip: getIp()},
                                        component: detalle_venta 
                                    },                                    
                                ]
                            },  
                        ]
                    },
                    {
                        name: 'orden',
                        path: 'orden:id',
                        props: {ip: getIp()},
                        component: orden,
                    }
                ]
            },
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