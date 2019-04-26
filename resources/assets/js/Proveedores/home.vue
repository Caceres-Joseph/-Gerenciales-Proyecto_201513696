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

            fColorBarra:"light-green darken-4",
            fSubmodulos:[],
            fAtajos:[],
            fChip:{
                nombre:"Proveedores",
                icono:"perm_identity"
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

                submodulos.tituloSimple("Proveedores","/proveedores/articulo", "KeyO", "CTRL + ALT + O")
                submodulos.tituloSimple("Deudas","/proveedores/articulo2", "KeyI","CTRL + ALT + I")

                this.fAtajos=submodulos.getAtajos();
                this.fSubmodulos=submodulos.getJson();

            },


        }
    }
</script>