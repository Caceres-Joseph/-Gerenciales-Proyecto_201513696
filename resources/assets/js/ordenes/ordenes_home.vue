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

            fColorBarra:"light-blue darken-4",
            fSubmodulos:[],
            fAtajos:[],
            fChip:{
                nombre:"",
                icono:"monetization_on"
            }
        }),

        destroyed() {

            document.removeEventListener("keyup", this.atajos);
        },
        mounted() {
            document.addEventListener("keyup", this.atajos);
        },
        created() {

            this.inicializar();
        },

        methods: {

            atajos(e) {
                if (e.ctrlKey && e.code == "KeyN") {
                    this.clkNueva();
                }else if (e.ctrlKey && e.shiftKey && e.code == "KeyP") {
                    this.clckBlock();
                }else if (e.ctrlKey && e.altKey && e.code === "KeyO") {
                    //Clientes
                    this.$router.push({
                        path: "/ordenes/sirviendo"
                    });
                }else if (e.ctrlKey && e.altKey && e.code === "KeyP") {
                    //Clientes
                    this.$router.push({
                        path: "/ordenes/opciones"
                    });
                }else if (e.ctrlKey && e.altKey && e.code === "KeyC") {
                    //Clientes
                    this.$router.push({
                        path: "/ordenes/cuarentena"
                    });
                }
            },
            /*
            |-------------------------
            | Inicio
            |-------------------------
            */
            inicializar() {
                this.getEncabezado();
                window.scrollTo(0, 0);
                this.clckInicio();
            },


            /*
            |-------------------------
            | Encabezado
            |-------------------------
            */
            getEncabezado() {
                var submodulos = new submodulo(this.$router);

                submodulos.tituloSimple("Ordenes","/ordenes/sirviendo", "", "");
                submodulos.tituloSimple("Nuevo","/ordenes/lugar", "", "");
                submodulos.tituloSimple("Opciones.","/ordenes/opciones", "", "");
                submodulos.tituloSimple("Cuarentena.","/ordenes/cuarentena", "", "");


                submodulos.crearAtajo("Ordenes","CTRL + ALT + O");
                submodulos.crearAtajo("Opciones","CTRL + ALT + P");
                submodulos.crearAtajo("Cuarentena","CTRL + ALT + C");

                submodulos.crearAtajo("Enviar","CTRL + SHIFT + L");
                submodulos.crearAtajo("Cobrar","CTRL + SHIFT + K");
                submodulos.crearAtajo("Bloquear","CTRL + SHIFT + P");
                submodulos.crearAtajo("Subir","CTRL + SHIFT + U");

                this.fAtajos=submodulos.getAtajos();
                this.fSubmodulos=submodulos.getJson();

            },
            clkNueva(){
                this.$router.push({ name: "lugar" });
            },
            clckInicio(){
                this.$router.push({ name: "sirviendo" });
            },
            clckBlock() {


                let uri =  "/session_remove/";

                this.axios
                    .get(uri)
                    .catch(error => {
                        this.$log.info("Error al cerrar session");
                    });

                this.$router.push({
                    name: "login"
                });

            },

        }
    }
</script>