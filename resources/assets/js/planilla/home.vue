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

            fColorBarra:"cyan darken-4",
            fSubmodulos:[],
            fAtajos:[],
            fChip:{
                nombre:"Planilla",
                icono:"assignment_ind"
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

                submodulos.tituloSimple("Planilla","/planilla/articulo", "KeyO", "CTRL + ALT + O")

                this.fAtajos=submodulos.getAtajos();
                this.fSubmodulos=submodulos.getJson();

            },


        }
    }
</script>