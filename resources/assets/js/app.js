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
Para las fracciones
------------------------------------
*/

import * as math from 'mathjs'
Vue.use(math);

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
import master from './home/master.vue'
import home from './home/home.vue'

import medida from './home/medida/medida.vue'


import categoria from './home/categoria/categoria.vue'
import categoria_nuevo from './home/categoria/nuevo.vue'
import categoria_display from './home/categoria/display.vue'
import categoria_editar from './home/categoria/editar.vue'

import articulo from './home/articulo/articulo.vue'
import articulo_editar from './home/articulo/editar.vue'
import articulo_nuevo from './home/articulo/nuevo.vue'


import ingreso_nuevo from './home/ingreso/nuevo.vue' 

/* import ingreso_listado from './home/ingreso/listado.vue'
import ingreso_detalle from './home/ingreso/ingreso_detalle.vue'
 */
//import stock from './home/stock/stock.vue'
import inventario from './home/inventario/inventario.vue'

import ingredientes from './home/ingredientes/ingredientes.vue'

import observaciones from './home/observaciones/observaciones.vue'
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
        name: 'home',
        path: 'home',
        component: home,
        props: {ip: getIp()},
        children: [{
                name: 'categoria',
                path: 'categoria',
                component: categoria,
                props: {ip: getIp()},
                children: [{
                        name: 'categoria_nuevo',
                        path: 'categoria_nuevo',
                        props: {ip: getIp()},
                        component: categoria_nuevo,
                    },
                    {
                        name: 'categoria_display',
                        path: 'categoria_display',
                        props: {ip: getIp()},
                        component: categoria_display
                    },
                    {
                        name: 'categoria_editar',
                        path: 'categoria_editar:id',
                        props: {ip: getIp()},
                        component: categoria_editar
                    }
                ]
            },
            {
                name: 'medida',
                path: 'medida',
                props: {ip: getIp()},
                component: medida
            },
            {
                name: 'articulo',
                path: 'articulo',
                props: {ip: getIp()},
                component: articulo,
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
                name: 'observaciones',
                path: 'observaciones',
                props: {ip: getIp()},
                component: observaciones,
            },
            {
                name: 'ingreso_nuevo',
                path: 'ingreso_nuevo',
                props: {ip: getIp()},
                component: ingreso_nuevo,
            }
            , 
            {
                name: 'inventario',
                path: 'inventario',
                props: {ip: getIp()},
                component: inventario,
            }
            , 
            {
                name: 'ingredientes',
                path: 'ingredientes:id',
                props: {ip: getIp()},
                component: ingredientes,
            }
            
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