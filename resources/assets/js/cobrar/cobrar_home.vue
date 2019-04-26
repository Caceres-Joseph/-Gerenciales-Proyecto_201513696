<template>


    <toolbar
            :atajos1="fAtajos"
            :chip="fChip"
            :colorBarra="fColorBarra"
            :subModulos="fSubmodulos"
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

            fColorBarra: "light-blue darken-4",
            fSubmodulos: [],
            fAtajos: [],
            fChip: {
                nombre: "",
                icono: "layers"
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
                if (e.ctrlKey && e.shiftKey && e.code === "KeyB") {
                    this.$router.push({name: "cuarentena"});
                } else if (e.ctrlKey && e.shiftKey && e.code === "KeyA") {
                    this.$router.push({name: "nuevo_abono"});
                } else if (e.ctrlKey && e.shiftKey && e.code === "KeyG") {
                    this.$router.push({name: "nuevo_gasto"});
                } else if (e.ctrlKey && e.shiftKey && e.code === "KeyO") {
                    this.$router.push({name: "sirviendo"});
                } else if (e.ctrlKey && e.shiftKey && e.code === "KeyS") {
                    this.$router.push({name: "ordenesMesa"});
                } else if (e.ctrlKey  && e.shiftKey && e.code === "KeyN") {
                    this.$router.push({name: "lugar"});
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
                //this.$router.push({name: "sirviendo"});
            },


            /*
            |-------------------------
            | Encabezado
            |-------------------------
            */
            getEncabezado() {
                var submodulos = new submodulo(this.$router);


                submodulos.tituloSimple("Ordenes", "/cobrar/sirviendo", "", "")
                submodulos.tituloSimple("Caja", "/cobrar/caja", "", "")
                submodulos.tituloSimple("Nueva", "/cobrar/lugar", "", "")
                submodulos.tituloSimple("Salones", "/cobrar/ordenesMesa", "", "")
                submodulos.tituloSimple("Cuarentena", "/cobrar/cuarentena", "", "")
                submodulos.tituloSimple("Correo","/cobrar/correo", "KeyT","CTRL + ALT + T")


                submodulos.crearAtajo("Ordenes", "CTRL + SHIFT + O");
                submodulos.crearAtajo("Nuevo Abono", "CTRL + SHIFT + A");
                submodulos.crearAtajo("Nuevo Gasto", "CTRL + SHIFT + G");
                submodulos.crearAtajo("Salones", "CTRL + SHIFT + S");
                submodulos.crearAtajo("Cuarentena", "CTRL + SHIFT + B");

                submodulos.crearAtajoTitulo("PAGO")

                submodulos.crearAtajo("Borrar", "SUPR");
                submodulos.crearAtajo("Tarjeta", "CTRL + T");
                submodulos.crearAtajo("Efectivo", "CTRL + E");
                submodulos.crearAtajo("Auto-Tarjeta", "CTRL + L");
                submodulos.crearAtajo("Listo", "ENTER");
                submodulos.crearAtajo("Cortesía", "CTRL + S");


                submodulos.crearAtajoTitulo("DETALLE ORDENES")
                submodulos.crearAtajo("Cobrar", "CTRL + C");
                submodulos.crearAtajo("Quitar/Agregar Propina", "CTRL + SHIFT + R");

                this.fAtajos = submodulos.getAtajos();
                this.fSubmodulos = submodulos.getJson();

            },
        }
    }
</script>