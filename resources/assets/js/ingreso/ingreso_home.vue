<template>
  <v-app id="inspire">
    <v-navigation-drawer
      fixed
      clipped
      class="grey lighten-5"
      app
      v-model="drawer"
    >
      <v-list
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
      </v-list>
    </v-navigation-drawer>

    <!--  -->
    <v-toolbar
      color="grey darken-3"
      dark
      app
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      fixed
    >
      <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
        <!-- <v-btn fab    color = "blue darken-3" @click="drawer = !drawer" ><v-icon>add</v-icon></v-btn> -->
        <v-toolbar-side-icon @click="drawer = !drawer"></v-toolbar-side-icon>
        
        <span  >-&nbsp;<span class="text">El Gamer</span></span>
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
                src="/storage/images/categorias/logoGamer.jpeg"
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
            
    </v-content> 
  </v-app>
</template>

<script>
  export default {
    props: ['ip'],
    data: () => ({
      dialog: false,
      drawer: null,
      items: [
        { heading: 'Bodega' },
        { icon: 'assignment', text: 'Ingreso', path: '/ingreso/bodega/' },  
        { icon: 'add', text: 'Nuevo Ingreso', path: '/ingreso/bodega_nuevo/' },  
        { divider: true }, 
/*         { icon: 'lightbulb_outline', text: 'caja' },
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

    }),  methods:{
    salir(){ 
      //haciendo logout
        let uri = this.ip + "session_remove/";

        this.axios
          .get(uri)
          .catch(error => {
            this.$log.info("Error al cerrar session");
          });
          
      var href = this.ip + "login"//find url
      window.location=href; 

    },
    inicio(){
      //lendo a home
      var href = this.ip + "bienvenido"//find url
      window.location=href; 
    }
  }
  }
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