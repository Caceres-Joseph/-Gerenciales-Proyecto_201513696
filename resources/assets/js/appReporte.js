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
------------------------------------
Graficas
------------------------------------
*/
 
import VueGoogleCharts from 'vue-google-charts'

Vue.use(VueGoogleCharts)

//************************
//  Vistas
//************************
import master from './reportes/reportes_master.vue'
import reporte from './reportes/reportes_home.vue'


import propina from './reportes/propina/propina.vue'


import g_ventas from './reportes/graficas/ventas/g_ventas.vue'
//diaros

import dia_ventasPorEmpleado from './reportes/dia/dia_ventasPorEmpleado/dia_ventasPorEmpleado.vue'
import dia_ventaDetalladaEmpleado from './reportes/dia/dia_ventaDetalladaEmpleado/dia_ventaDetalladaEmpleado.vue'
import dia_ventasGeneral from './reportes/dia/dia_ventasGeneral/dia_ventasGeneral.vue'
import dia_ordenesGeneral from './reportes/dia/dia_ordenesGeneral/dia_ordenesGeneral.vue'
import dia_vendidoBarra from './reportes/dia/dia_vendidosBarra/dia_vendidoBarra.vue'
import dia_ventaCocina from './reportes/dia/dia_ventaCocina/dia_ventaCocina.vue'
import dia_ordenesCortesia from './reportes/dia/dia_ordenesCortesia/dia_ordenesCortesia.vue'
import dia_gastos from './reportes/dia/dia_gastos/dia_gastos.vue'
import dia_abonos from './reportes/dia/dia_abonos/dia_abonos.vue'

import dia_barra from './reportes/dia/dia_barra/dia_barra.vue'

import dia_cuarentena       from './reportes/dia/dia_cuarentena/dia_cuarentena.vue'
import dia_devolucion from './reportes/dia/dia_devolucion/dia_devolucion.vue'
import dia_devolucionCocina from './reportes/dia/dia_devolucionCocina/dia_devolucionCocina.vue'
import dia_devolucionBarra       from './reportes/dia/dia_devolucionBarra/dia_devolucionBarra.vue'

import historialProducto from './reportes/historialProducto/historialProducto.vue'
import historial_detalleProducto from './reportes/historialProducto/historial_detalleProducto/historial_detalleProducto.vue'

import ingreso_listado from './reportes/ingreso/listado.vue'
import ingreso_detalle from './reportes/ingreso/ingreso_detalle.vue'



import inventario_listado from './reportes/inventario/listado.vue'
import inventario_detalle from './reportes/inventario/inventario_detalle.vue'

import merma from './reportes/merma/merma.vue'


import detalleOrden from './reportes/detalleOrden/detalleOrden.vue'




/* import dia_barra_cobrados               from './reportes/dia/dia_barra/cobrados/cobrados.vue'
import dia_barra_cobrados_cortesia      from './reportes/dia/dia_barra/cobrados_cortesia/cobrados_cortesia.vue'
import dia_barra_cortesias              from './reportes/dia/dia_barra/cortesias/cortesias.vue'
import dia_barra_impresos               from './reportes/dia/dia_barra/impresos/impresos.vue'
import dia_barra_impresos_eliminados    from './reportes/dia/dia_barra/impresos_eliminados/impresos_eliminados.vue'
import dia_barra_no_impresos            from './reportes/dia/dia_barra/no_impresos/no_impresos.vue'
import dia_barra_no_impresos_eliminados from './reportes/dia/dia_barra/no_impresos_eliminados/no_impresos_eliminados.vue'
import dia_barra_ordenes_eliminadas     from './reportes/dia/dia_barra/ordenes_eliminadas/ordenes_eliminadas.vue'
import dia_barra_ordenes_generales      from './reportes/dia/dia_barra/ordenes_generales/ordenes_generales.vue'
import dia_barra_ordenes_no_eliminadas  from './reportes/dia/dia_barra/ordenes_no_eliminadas/ordenes_no_eliminadas.vue'
 */

//************************
//  Rutas
//************************
const routes = [{
    name: 'master',
    path: '/',
    props: {ip: getIp()},
    component: master,
    children: [{
        name: 'reporte',
        path: 'reporte',
        props: {ip: getIp()},
        component: reporte,
        children: [
            {
                name: 'propina',
                path: 'propina',
                props: {ip: getIp()},
                component: propina,
            },
            {
                name: 'dia_ventasPorEmpleado',
                path: 'dia_ventasPorEmpleado',
                props: {ip: getIp()},
                component: dia_ventasPorEmpleado,
            },
            {
                name: 'dia_ventaDetalladaEmpleado',
                path: 'dia_ventaDetalladaEmpleado',
                props: {ip: getIp()},
                component: dia_ventaDetalladaEmpleado,
            },
            {
                name: 'dia_ventasGeneral',
                path: 'dia_ventasGeneral',
                props: {ip: getIp()},
                component: dia_ventasGeneral,
            },
            {
                name: 'dia_ordenesGeneral',
                path: 'dia_ordenesGeneral',
                props: {ip: getIp()},
                component: dia_ordenesGeneral,
            },
            {
                name: 'dia_vendidoBarra',
                path: 'dia_vendidoBarra',
                props: {ip: getIp()},
                component: dia_vendidoBarra,
            },
            {
                name: 'dia_ventaCocina',
                path: 'dia_ventaCocina',
                props: {ip: getIp()},
                component: dia_ventaCocina,
            },
            {
                name: 'dia_ordenesCortesia',
                path: 'dia_ordenesCortesia',
                props: {ip: getIp()},
                component: dia_ordenesCortesia,
            },
            {
                name: 'dia_gastos',
                path: 'dia_gastos',
                props: {ip: getIp()},
                component: dia_gastos,
            },
            {
                name: 'dia_abonos',
                path: 'dia_abonos',
                props: {ip: getIp()},
                component: dia_abonos,
            }

            //BARRA
            ,
            {
                name: 'dia_barra',
                path: 'dia_barra',
                props: {ip: getIp()},
                component: dia_barra,
            }, 


            //CUARENTENA
            {
                name: 'dia_cuarentena',
                path: 'dia_cuarentena',
                props: {ip: getIp()},
                component: dia_cuarentena,
            },
            {
                name: 'dia_devolucion',
                path: 'dia_devolucion',
                props: {ip: getIp()},
                component: dia_devolucion,
            }, 
            {
                name: 'dia_devolucionCocina',
                path: 'dia_devolucionCocina',
                props: {ip: getIp()},
                component: dia_devolucionCocina,
            }, 
            {
                name: 'dia_devolucionBarra',
                path: 'dia_devolucionBarra',
                props: {ip: getIp()},
                component: dia_devolucionBarra,
            }, 
            //DETALLE ORDEN

            {
                name: 'detalleOrden',
                path: 'detalleOrden:id',
                props: {ip: getIp()},
                component: detalleOrden,
            },
           
            //Historial Producto
            {
                name: 'historialProducto',
                path: 'historialProducto',
                props: {ip: getIp()},
                component: historialProducto,
            },
            {
                name: 'historial_detalleProducto',
                path: 'historial_detalleProducto:id',
                props: {ip: getIp()},
                component: historial_detalleProducto,
            },

            //Ingresos

            {
                name: 'ingreso_listado',
                path: 'ingreso_listado',
                props: {ip: getIp()},
                component: ingreso_listado,
            },
            {
                name: 'ingreso_detalle',
                path: 'ingreso_detalle:id:proveedor:total:tipo:num:fecha',
                props: {ip: getIp()},
                component: ingreso_detalle,
            }, 


            //INVENTARIO

            {
                name: 'inventario_listado',
                path: 'inventario_listado',
                props: {ip: getIp()},
                component: inventario_listado,
            },
            {
                name: 'inventario_detalle',
                path: 'inventario_detalle:id:proveedor:total:tipo:num:fecha',
                props: {ip: getIp()},
                component: inventario_detalle,
            }, 

            {
                name: 'merma',
                path: 'merma',
                props: {ip: getIp()},
                component: merma,
            }, 


            //Graficas

            {
                name: 'g_ventas',
                path: 'g_ventas',
                props: {ip: getIp()},
                component: g_ventas,
            }, 

        ]
    }]
}];



/* 
 ,
            {
                name: 'dia_barra_cobrados',
                path: 'dia_barra_cobrados',
                props: {ip: getIp()},
                component: dia_barra_cobrados,
            }
            ,
            {
                name: 'dia_barra_cobrados_cortesia',
                path: 'dia_barra_cobrados_cortesia',
                props: {ip: getIp()},
                component: dia_barra_cobrados_cortesia,
            }
            ,
            {
                name: 'dia_barra_cortesias',
                path: 'dia_barra_cortesias',
                props: {ip: getIp()},
                component: dia_barra_cortesias,
            }
            ,
            {
                name: 'dia_barra_impresos',
                path: 'dia_barra_impresos',
                props: {ip: getIp()},
                component: dia_barra_impresos,
            }
            ,
            {
                name: 'dia_barra_impresos_eliminados',
                path: 'dia_barra_impresos_eliminados',
                props: {ip: getIp()},
                component: dia_barra_impresos_eliminados,
            }
            ,
            {
                name: 'dia_barra_no_impresos',
                path: 'dia_barra_no_impresos',
                props: {ip: getIp()},
                component: dia_barra_no_impresos,
            }
            ,
            {
                name: 'dia_barra_no_impresos_eliminados',
                path: 'dia_barra_no_impresos_eliminados',
                props: {ip: getIp()},
                component: dia_barra_no_impresos_eliminados,
            }
            ,
            {
                name: 'dia_barra_ordenes_eliminadas',
                path: 'dia_barra_ordenes_eliminadas',
                props: {ip: getIp()},
                component: dia_barra_ordenes_eliminadas,
            }
            ,
            {
                name: 'dia_barra_ordenes_generales',
                path: 'dia_barra_ordenes_generales',
                props: {ip: getIp()},
                component: dia_barra_ordenes_generales,
            }
            ,
            {
                name: 'dia_barra_ordenes_no_eliminadas',
                path: 'dia_barra_ordenes_no_eliminadas',
                props: {ip: getIp()},
                component: dia_barra_ordenes_no_eliminadas,
            } 
            
            */
const router = new VueRouter({
    mode: 'history',
    routes: routes
});


new Vue(Vue.util.extend({
    router
}, master)).$mount('#app');