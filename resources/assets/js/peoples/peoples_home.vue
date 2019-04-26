<template>


  <toolbar
          :colorBarra="fColorBarra"
          :subModulos="fSubmodulos"
          :atajos1="fAtajos"
          :chip="fChip"
  >

  </toolbar>

</template>

<script>
  import toolbar from '../modules/ToolBar/eToolvar.vue'
  import {submodulo} from '../modules/ToolBar/submodulo'


  export default {



    components: {
      toolbar
    },

    data: () => ({

      fColorBarra:"teal darken-3",
      fSubmodulos:[],
      fAtajos:[],
      fChip:{
        nombre:"Personas",
        icono:"people"
      }


    }),

    created() {

      this.inicializar();
    },

    methods: {

      /*
      |-------------------------
      | Inicio
      |-------------------------
      */
      inicializar() {
        this.getEncabezado();
        window.scrollTo(0, 0);
      },


      /*
      |-------------------------
      | Encabezado
      |-------------------------
      */
      getEncabezado() {
        var submodulos = new submodulo(this.$router);

        //submodulos.tituloSimple("Roles","/peoples/roles/", "KeyR", "CTRL + ALT + R")
        submodulos.tituloSimple("Personas","/peoples/personas/", "KeyP","CTRL + ALT + P")
        submodulos.tituloSimple("Usuarios","/peoples/usuarios/", "KeyU","CTRL + ALT + U")
        submodulos.tituloSimple("Biométrico","/peoples/sueldo/", "KeyS","CTRL + ALT + S")
        submodulos.tituloSimple("Configuracion","/peoples/configuracion/", "KeyC","CTRL + ALT + C")

        this.fAtajos=submodulos.getAtajos();
        this.fSubmodulos=submodulos.getJson();

      },


    }
  }
</script>