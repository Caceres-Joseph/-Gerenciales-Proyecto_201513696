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

            fColorBarra:"indigo darken-3",
            fSubmodulos:[],
            fAtajos:[],
            fChip:{
                nombre:"Utensilios",
                icono:"restaurant"
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

                submodulos.tituloSimple("Categorías","/utensilios/categoria/categoria_display", "KeyC", "CTRL + ALT + C")
                submodulos.tituloSimple("Utensilios","/utensilios/articulo", "KeyU","CTRL + ALT + U")
                submodulos.tituloSimple("Ingreso","/utensilios/ingreso_nuevo", "KeyI","CTRL + ALT + I")
                submodulos.tituloSimple("Inventario","/utensilios/inventario", "KeyR","CTRL + ALT + R")


                this.fAtajos=submodulos.getAtajos();
                this.fSubmodulos=submodulos.getJson();

            },


        }
    }
</script>