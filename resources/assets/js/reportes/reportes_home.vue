<template>
  <v-app id="inspire">
    <v-navigation-drawer
      fixed
      clipped
      class="grey lighten-5"
      app
      v-model="drawer"
    >
      <!-- <v-list
        dense
        class="grey lighten-5"
      >
        <template v-for="(item, i) in items">
          <v-layout
            row
            v-if="item.heading"
            align-center
            :key="i"
          >
            <v-flex xs6>
              <v-subheader v-if="item.heading">
                {{ item.heading }}
              </v-subheader>
            </v-flex>
            <v-flex xs6 class="text-xs-right"> 
            </v-flex>
          </v-layout>
          <v-divider
            dark
            v-else-if="item.divider"
            
            class="my-3"
            :key="i"
          ></v-divider>
          <v-list-tile
            :key="i"
            v-else
            :to="item.path" 
          >
            <v-list-tile-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title class="grey_lighten-1--text">
                {{ item.text }}
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </template>
      </v-list> -->

    <v-list dense>
        <template v-for="item in items">
          <v-layout
            v-if="item.heading"
            :key="item.heading"
            row
            align-center
          >
            <v-flex xs6>
              <v-subheader v-if="item.heading">
                {{ item.heading }}
              </v-subheader>
            </v-flex> 
          </v-layout> 
          <v-divider
            dark
            v-else-if="item.divider" 
            class="my-3"
            :key="item.heading"
          ></v-divider> 


          <v-list-group
            v-else-if="item.children"
            v-model="item.model"
            :key="item.text"
            :prepend-icon="item.model ? item.icon : item['icon-alt']"
            append-icon=""
          >
           
            
              <v-list-tile slot="activator">
                <v-list-tile-content>
                  <v-list-tile-title>
                    {{ item.text }}
                  </v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
              <v-list-tile
                v-for="(child, i) in item.children"
                :key="i" 
                :to="child.path"
              >
                <v-list-tile-action v-if="child.icon">
                  <v-icon>{{ child.icon }}</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                  <v-list-tile-title>
                    {{ child.text }}
                  </v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile> 
          </v-list-group>
          <v-list-tile v-else :key="item.text" :to="item.path">
            <v-list-tile-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                {{ item.text }}
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </template>
      </v-list>

    </v-navigation-drawer>

    <!--  -->
    <v-toolbar
      color="teal darken-4"
      dark
      app
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      fixed
    >
      <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
        <!-- <v-btn fab    color = "blue darken-3" @click="drawer = !drawer" ><v-icon>add</v-icon></v-btn> -->
        <v-toolbar-side-icon @click="drawer = !drawer"></v-toolbar-side-icon>
        
        <span  >Restaurante&nbsp;<span class="text">El Mirador</span></span>
      </v-toolbar-title>
      <v-text-field
        flat
        solo-inverted
        prepend-icon="search"
        label="Ingreso"
        class="hidden-sm-and-down" 
      ></v-text-field>
      <v-spacer></v-spacer>
      <v-menu bottom left>
            <v-avatar size="40px"  slot="activator" class="mr-3" >
              <img
                src="/storage/images/categorias/logoMirador.jpeg"
                alt=""
              >
            </v-avatar>
        <v-list>
          <v-list-tile   @click="inicio">
            <v-list-tile-title>Inicio</v-list-tile-title> 
          </v-list-tile>
          <v-list-tile   @click="salir">
            <v-list-tile-title>Salir</v-list-tile-title> 
          </v-list-tile>
        </v-list>
      </v-menu>
    </v-toolbar>
<!--       <v-toolbar color="blue darken-3" app absolute  dark clipped-left>
      <v-toolbar-side-icon @click.native="drawer = !drawer"></v-toolbar-side-icon>
      <span class="title ml-3 mr-5">Google&nbsp;<span class="text">Keep</span></span>
      <v-text-field
        solo-inverted
        flat
        label="Search"
        prepend-icon="search"
        class="hidden-sm-and-down"
      ></v-text-field>
      <v-spacer></v-spacer>
    </v-toolbar> -->
    
    <v-content> 
      <router-view></router-view>
      <v-flex xs12 height="250">
        <v-card  flat  >
              <v-parallax src="/storage/images/categorias/fondoHome.png" :height="800"  >
              </v-parallax>
        </v-card>
      </v-flex> 
    </v-content> 

            <!-- <img
                src="/storage/images/categorias/logoMirador3.jpeg"
                alt=""
              > -->
  </v-app>
</template>

<script>
export default {
    props: ['ip'],
  data: () => ({
    dialog: false,
    drawer: null,
    items: [
      /* { heading: 'Propina' },
        { icon: 'equalizer', text: 'Propina', path: '/reporte/propina/' },   */
      /* { icon: 'add', text: 'Nuevo Ingreso', path: '/ingreso/bodega_nuevo/' },   */
      { divider: true },

      { heading: "Diaria" },

      /* {
        icon: "equalizer",
        text: "Venta Detallada por empleado",
        path: "/reporte/dia_ventaDetalladaEmpleado/"
      },
      {
        icon: "equalizer",
        text: "Resumen ventas por empleados",
        path: "/reporte/dia_ventasPorEmpleado/"
      },
      {
        icon: "equalizer",
        text: "Ventas detalladas",
        path: "/reporte/dia_ventasGeneral/"
      },
      { divider: true },
      { icon: "equalizer", text: "Gastos", path: "/reporte/dia_gastos/" },
      { icon: "equalizer", text: "Abonos", path: "/reporte/dia_abonos/" },
      { divider: true },
      {
        icon: "equalizer",
        text: "Ordenes generales",
        path: "/reporte/dia_ordenesGeneral/"
      }, 
      {
        icon: "equalizer",
        text: "Ordenes de cortesía",
        path: "/reporte/dia_ordenesCortesia/"
      },
      { divider: true },
      { heading: "Productos de Barra" },
      {
        icon: "equalizer",
        text: "Impresos",
        path: "/reporte/dia_barra_impresos/"
      },
      {
        icon: "equalizer",
        text: "No impresos",
        path: "/reporte/dia_barra_no_impresos/"
      },
      { divider: true },
      {
        icon: "equalizer",
        text: "Cobrados",
        path: "/reporte/dia_barra_cobrados/"
      },
      {
        icon: "equalizer",
        text: "Cortesias",
        path: "/reporte/dia_barra_cortesias/"
      },
      {
        icon: "equalizer",
        text: "Cobrados y Cortesias",
        path: "/reporte/dia_barra_cobrados_cortesia/"
      },
      { divider: true },
      {
        icon: "equalizer",
        text: "Impresos eliminados",
        path: "/reporte/dia_barra_impresos_eliminados/"
      },
      {
        icon: "equalizer",
        text: "No impresos eliminados",
        path: "/reporte/dia_barra_no_impresos_eliminados/"
      },
      { divider: true },
      {
        icon: "equalizer",
        text: "Ordenes eliminadas",
        path: "/reporte/dia_barra_ordenes_eliminadas/"
      },
      {
        icon: "equalizer",
        text: "Ordenes no eliminadas",
        path: "/reporte/dia_barra_ordenes_no_eliminadas/"
      },
      {
        icon: "equalizer",
        text: "Ordenes Generales",
        path: "/reporte/dia_barra_ordenes_generales/"
      },
      { divider: true },
      {
        icon: "equalizer",
        text: "Productos impresos en cocina",
        path: "/reporte/dia_ventaCocina/"
      }, */
      /* {
        icon: "keyboard_arrow_up",
        "icon-alt": "keyboard_arrow_down",
        text: "More",
        model: false,
        children: [
          {
            icon: "equalizer",
            text: "Import",
            path: "/reporte/dia_ventaCocina/"
          },
          {
            icon: "equalizer",
            text: "Export",
            path: "/reporte/dia_ventaCocina/"
          },
          { text: "Print" },
          { text: "Undo changes" },
          { text: "Other contacts" }
        ]
      }, */

      /*
        +------------------------------------------------+
        |   DIARIA
        +------------------------------------------------+
        */

      /*
         ********************* 
         * Ventas
         *********************
        */

      {
        icon: "keyboard_arrow_up",
        "icon-alt": "keyboard_arrow_down",
        text: "Ventas",
        model: false,
        children: [
          {
            icon: "equalizer",
            text: "Venta Detallada por empleado",
            path: "/reporte/dia_ventaDetalladaEmpleado/"
          },
          {
            icon: "equalizer",
            text: "Resumen ventas por empleados",
            path: "/reporte/dia_ventasPorEmpleado/"
          },
          {
            icon: "equalizer",
            text: "Ventas detalladas",
            path: "/reporte/dia_ventasGeneral/"
          }
        ]
      },

      /*
         ********************* 
         * Gastos y Abonos
         *********************
        */

      {
        icon: "keyboard_arrow_up",
        "icon-alt": "keyboard_arrow_down",
        text: "Gastos y Abonos",
        model: false,
        children: [
          { icon: "equalizer", text: "Gastos", path: "/reporte/dia_gastos/" },
          { icon: "equalizer", text: "Abonos", path: "/reporte/dia_abonos/" }
        ]
      },

      /*
         ********************* 
         * Ordenes
         *********************
        */

      {
        icon: "keyboard_arrow_up",
        "icon-alt": "keyboard_arrow_down",
        text: "Ordenes",
        model: false,
        children: [
          {
            icon: "equalizer",
            text: "Ordenes generales",
            path: "/reporte/dia_ordenesGeneral/"
          },
          {
            icon: "equalizer",
            text: "Ordenes de cortesía",
            path: "/reporte/dia_ordenesCortesia/"
          }
        ]
      },

      /*
         ********************* 
         * Cajas
         *********************
        */

      /* {
        icon: "keyboard_arrow_up",
        "icon-alt": "keyboard_arrow_down",
        text: "Cajas",
        model: false,
        children: [
          {
            icon: "equalizer",
            text: "Productos impresos en cocina",
            path: "/reporte/dia_ventaCocina/"
          }
        ]
      }, */

      /*
         ********************* 
         * BARRA
         *********************
        */

      {
        icon: "keyboard_arrow_up",
        "icon-alt": "keyboard_arrow_down",
        text: "Barra",
        model: false,
        children: [
          {
            icon: "equalizer",
            text: "Barra",
            path: "/reporte/dia_barra/"
          }
          /* {
            icon: "equalizer",
            text: "No impresos",
            path: "/reporte/dia_barra_no_impresos/"
          }, 
          {
            icon: "equalizer",
            text: "Cobrados",
            path: "/reporte/dia_barra_cobrados/"
          }, 
          {
            icon: "equalizer",
            text: "Cortesias",
            path: "/reporte/dia_barra_cortesias/"
          },
          {
            icon: "equalizer",
            text: "Cobrados y Cortesias",
            path: "/reporte/dia_barra_cobrados_cortesia/"
          }, 
          {
            icon: "equalizer",
            text: "Impresos eliminados",
            path: "/reporte/dia_barra_impresos_eliminados/"
          },
          {
            icon: "equalizer",
            text: "No impresos eliminados",
            path: "/reporte/dia_barra_no_impresos_eliminados/"
          }, 
          {
            icon: "equalizer",
            text: "Ordenes eliminadas",
            path: "/reporte/dia_barra_ordenes_eliminadas/"
          },
          {
            icon: "equalizer",
            text: "Ordenes no eliminadas",
            path: "/reporte/dia_barra_ordenes_no_eliminadas/"
          },
          {
            icon: "equalizer",
            text: "Ordenes Generales",
            path: "/reporte/dia_barra_ordenes_generales/"
          },  */
        ]
      },

      /*
         ********************* 
         * Cocina
         *********************
        */

      {
        icon: "keyboard_arrow_up",
        "icon-alt": "keyboard_arrow_down",
        text: "Cocina",
        model: false,
        children: [
          {
            icon: "equalizer",
            text: "Productos impresos en cocina",
            path: "/reporte/dia_ventaCocina/"
          }
        ]
      },

      /*
         ********************* 
         * Devoluciones
         *********************
        */

      {
        icon: "keyboard_arrow_up",
        "icon-alt": "keyboard_arrow_down",
        text: "Devoluciones",
        model: false,
        children: [
          /* {
            icon: "equalizer",
            text: "Ordenes en Cuarentena",
            path: "/reporte/dia_cuarentena/"
          },  */
          {
            icon: "equalizer",
            text: "Devoluciones",
            path: "/reporte/dia_devolucion/"
          }
          /* , 
          {
            icon: "equalizer",
            text: "Devoluciones de Barra",
            path: "/reporte/dia_devolucionBarra/"
          }
          , 
          {
            icon: "equalizer",
            text: "Devoluciones de Cocina",
            path: "/reporte/dia_devolucionCocina/"
          } */
        ]
      },

      /*
         ********************* 
         * Ingresos
         *********************
        */
      { heading: "Ingresos" },

      {
        icon: "equalizer",
        text: "Ingreso",
        path: "/reporte/ingreso_listado/"
      },

      /*
         ********************* 
         * historialProducto
         *********************
        */
      { heading: "Historial" },

      {
        icon: "equalizer",
        text: "Historial de Productos",
        path: "/reporte/historialProducto/"
      },

      /*
         ********************* 
         * Inventario
         *********************
        */
      { heading: "Inventarios" },

      {
        icon: "equalizer",
        text: "Inventario",
        path: "/reporte/inventario_listado/"
      },
      {
        icon: "equalizer",
        text: "Merma",
        path: "/reporte/merma/"
      },

      /*
         ********************* 
         * Graficas
         *********************
        */
      { heading: "Graficas" },

      {
        icon: "equalizer",
        text: "Gráficas",
        path: "/reporte/g_ventas/"
      }, 

      

      /* { heading: 'Caja' },
        { icon: 'equalizer', text: 'Ventas general', path: '/reporte/propina/' },
        { icon: 'equalizer', text: 'Gastos', path: '/reporte/propina/' },
        { icon: 'equalizer', text: 'Abonos', path: '/reporte/propina/' }, */

      /*      { icon: 'lightbulb_outline', text: 'caja' },
        { icon: 'touch_app', text: 'mesas' },
        { divider: true },
        { heading: 'Usuarios' },
        { icon: 'add', text: 'nuevo usuario' }, */
      /*        { divider: true },
        { icon: 'archive', text: 'Archive' },
        { icon: 'delete', text: 'Trash' },
        { divider: true },
        { icon: 'settings', text: 'Settings' }, */
      /*  { icon: 'chat_bubble', text: 'Trash' },
        { icon: 'help', text: 'Help' },
        { icon: 'phonelink', text: 'App downloads' },
        { icon: 'keyboard', text: 'Keyboard shortcuts' } */
    ]
  }),
  
  methods: {
    salir() {
      //haciendo logout
      let uri = this.ip + "session_remove/";

      this.axios.get(uri).catch(error => {
        this.$log.info("Error al cerrar session");
      });

      var href = this.ip + "login"; //find url
      window.location = href;
    },
    inicio() {
      //lendo a home
      var href = this.ip + "bienvenido"; //find url
      window.location = href;
    }
  }
};
</script>

<style>
#keep main .container {
  height: 660px;
}
.navigation-drawer__border {
  display: none;
}
.text {
  font-weight: 400;
}
</style>