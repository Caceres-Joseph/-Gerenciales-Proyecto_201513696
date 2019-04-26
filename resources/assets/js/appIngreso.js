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

import master from './ingreso/ingreso_master.vue'
import ingreso from './ingreso/ingreso_home.vue'

 
import bodega from './ingreso/bodega/bodega.vue'
import bodega_editar from './ingreso/bodega/editar.vue'
import bodega_nuevo from './ingreso/bodega/nuevo.vue'
//************************
//  Rutas
//************************
const routes = [{
        name: 'master',
        path: '/',
        props: {ip: getIp()},
        component: master,
        children: [{
            name: 'ingreso',
            path: 'ingreso',
            props: {ip: getIp()},
            component: ingreso,
             children: [
                {
                    name: 'bodega',
                    path: 'bodega',
                    props: {ip: getIp()},
                    component: bodega,
                },
                {
                    name: 'bodega_nuevo',
                    path: 'bodega_nuevo',
                    props: {ip: getIp()},
                    component: bodega_nuevo,
                },
                {
                    name: 'bodega_editar',
                    path: 'bodega_editar:id',
                    props: {ip: getIp()},
                    component: bodega_editar,
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