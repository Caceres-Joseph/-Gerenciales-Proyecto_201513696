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

/*
 **********************************************
 * LAS VISTAS
 **********************************************
 */
import master from './peoples/peoples_master.vue'
import home from './peoples/peoples_home.vue'

import roles from './peoples/roles/roles.vue'

import personas from './peoples/personas/personas_display.vue'
import personas_editar from './peoples/personas/personas_editar.vue'
import personas_nuevo from './peoples/personas/personas_nuevo.vue'




import usuarios from './peoples/usuarios/usuario_display.vue'
import usuarios_editar from './peoples/usuarios/usuario_editar.vue'
import usuarios_nuevo from './peoples/usuarios/usuario_nuevo.vue'



import sueldo from './peoples/sueldo/usuario_display.vue'
import sueldo_editar from './peoples/sueldo/usuario_editar.vue'
import sueldo_nuevo from './peoples/sueldo/usuario_nuevo.vue'


import configuracion from './peoples/configuracion/nuevo.vue'


/*
 **********************************************
 * LAS RUTAS
 **********************************************
 */
const routes = [{
    name: 'master',
    path: '/',
    props: {ip: getIp()},
    component: master,
    children: [{
        name: 'peoples',
        path: 'peoples',
        props: {ip: getIp()},
        component: home,
        children: [
            {
                name: 'roles', 
                path: 'roles',
                props: {ip: getIp()},
                component: roles
            },
            {
                name: 'personas',
                path: 'personas',
                component: personas
            },
            {
                name: 'personas_editar',
                path: 'personas_editar:id',
                component: personas_editar
            },
            {
                name: 'personas_nuevo',
                path: 'personas_nuevo',
                component: personas_nuevo
            },
            {
                name: 'usuarios', 
                path: 'usuarios',
                component: usuarios
            },
            {
                name: 'usuarios_editar',
                path: 'usuarios_editar:id',
                component: usuarios_editar
            },
            {
                name: 'usuarios_nuevo',
                path: 'usuarios_nuevo',
                component: usuarios_nuevo
            },


            {
                name: 'sueldo',
                path: 'sueldo',
                component: sueldo
            },
            {
                name: 'sueldo_editar',
                path: 'sueldo_editar:id',
                component: sueldo_editar
            },
            {
                name: 'sueldo_nuevo',
                path: 'sueldo_nuevo',
                component: sueldo_nuevo
            },

            {
                name: 'configuracion',
                path: 'configuracion',
                component: configuracion
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