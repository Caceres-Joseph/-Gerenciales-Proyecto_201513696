
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
import master from './planilla/master.vue'
import home from './planilla/home.vue'



import articulo from './planilla/articulo/articulo.vue'



import asistencia from './planilla/asistencia/asistencia.vue'



/*
 **********************************************
 * LAS RUTAS
 **********************************************
 */
const routes = [{
    name: 'master',
    path: '/',
    component: master,
    children: [{
        name: 'planilla',
        path: 'planilla',
        component: home,
        children: [
            {
                name: 'articulo',
                path: 'articulo',
                component: articulo,
            },
            {
                name: 'asistencia',
                path: 'asistencia:id:nombre',
                component: asistencia,
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