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

      fColorBarra:"blue darken-3",
      fSubmodulos:[],
      fAtajos:[],
      fChip:{
        nombre:"Productos",
        icono:"add"
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

        submodulos.tituloSimple("Categorías","/home/categoria/categoria_display", "KeyC", "CTRL + ALT + C")
        submodulos.tituloSimple("Medidas","/home/medida/", "KeyM","CTRL + ALT + M")
        submodulos.tituloSimple("Articulos","/home/articulo", "KeyA","CTRL + ALT + A")
        submodulos.tituloSimple("Observaciones","/home/observaciones", "KeyO","CTRL + ALT + O")
        submodulos.tituloSimple("Ingreso","/home/ingreso_nuevo", "KeyI","CTRL + ALT + I")
        submodulos.tituloSimple("Inventario","/home/inventario", "KeyN","CTRL + ALT + N")


        this.fAtajos=submodulos.getAtajos();
        this.fSubmodulos=submodulos.getJson();

      },


    }
  }
</script>