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
import master from './Utensilios/master.vue'
import home from './Utensilios/home.vue'


import categoria from './Utensilios/categoria/categoria.vue'
import categoria_nuevo from './Utensilios/categoria/nuevo.vue'
import categoria_display from './Utensilios/categoria/display.vue'
import categoria_editar from './Utensilios/categoria/editar.vue'


import articulo from './Utensilios/articulo/articulo.vue'
import articulo_editar from './Utensilios/articulo/editar.vue'
import articulo_nuevo from './Utensilios/articulo/nuevo.vue'


import ingreso_nuevo from './Utensilios/ingreso2/ingreso.vue'
import inventario from './Utensilios/inventario/inventario.vue'

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
    children: [
        {
            name: 'utensilios',
            path: 'utensilios',
            component: home,
            props: {ip: getIp()},
            children: [
                {
                    name: 'categoria',
                    path: 'categoria',
                    component: categoria,
                    props: {ip: getIp()},
                    children: [
                        {
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