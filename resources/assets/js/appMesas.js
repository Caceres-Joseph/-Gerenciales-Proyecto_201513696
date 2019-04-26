/*
------------------------------------
Direccion ip 
------------------------------------
*/
  
import  getIp  from './modules/globales.js'; 
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

import master from './mesas/master.vue'
import mesas from './mesas/home.vue'

import lugar from './mesas/lugar/lugar.vue'


import mesa3 from './mesas/mesa_silla/mesa3.vue'

import mesa from './mesas/mesas/mesas.vue'
//************************
//  Rutas
//************************
const routes = [{
        name: 'master',
        path: '/',
        props: {ip: getIp()},
        component: master,
        children: [{
            name: 'mesas',
            path: 'mesas',
            props: {ip: getIp()},
            component: mesas,
            children: [
                {
                    name: 'lugar',
                    path: 'lugar',
                    props: {ip: getIp()},
                    component: lugar
                },
                {
                    name: 'mesa3',
                    path: 'mesa3',
                    props: {ip: getIp()},
                    component: mesa3
                },
                {
                    name: 'mesa',
                    path: 'mesa',
                    props: {ip: getIp()},
                    component: mesa
                }
            ]
        }]
    }

];


const router = new VueRouter({
    mode: 'history',
    routes: routes
  });
 
 
  new Vue(Vue.util.extend({
    router
  }, master)).$mount('#app');