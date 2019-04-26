<template>


    <tabla
            :clckEditar="clckEditar"
            :clckEliminar="clckEliminar"
            :color="colorDefecto"
            :encabezado="fEncabezado"
            :items="fItems"
            :titulo="fTitulo"
            :clckNuevo="clckNuevo"
            :buscar="buscar"
    ></tabla>


</template>

<script>
    import tabla from '../../modules/Tabla/eTabla.vue'
    import mensajes from '../../modules/SnackBar/mensajes.js'
    import {encabezado} from '../../modules/Tabla/encabezado.js'

    export default {
        props: {
            colorDefecto: String,
            buscar: String
        },

        mixins: [mensajes],

        components: {
            tabla
        },

        data: () => ({

            fItems: [],
            fTitulo: "Utensilios",
            fEncabezado: []

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

            atajos() {

                if (event.ctrlKey && event.code == "KeyN") {
                    this.clckNuevo();
                }
            },
            /*
            |-------------------------
            | Inicio
            |-------------------------
            */
            inicializar() {
                this.fEncabezado = this.getEncabezado();
                this.iniItems();
                window.scrollTo(0, 0);
            },


            getEncabezado() {
                var encabezados = new encabezado();


                encabezados.tituloSimple("Id", "idUtensilio")
                encabezados.tituloSimple("Nombre", "nombre")
                encabezados.tituloSimple("Descripción", "descripcion")
                encabezados.tituloSimpleRight("Código", "codigo")
                encabezados.tituloSimpleRight("Compra", "precioCompra")
                encabezados.tituloSimple("Venta", "precioVenta")
                encabezados.tituloSimple("Ubicación", "ruta")
                encabezados.tituloAccion();

                return encabezados.getJsonEncabezado();
            },

            iniItems() {

                let uri = "/uUtensilio_getItems";
                this.axios
                    .get(uri)
                    .then(response => {
                        this.fItems = response.data;

                    })
                    .catch(error => {
                        this.$log.info(error);
                        this.mensajeError("Ocurrió un error");
                    });
            },

            /*
            |-------------------------
            | Click
            |-------------------------
            */

            clckEditar(item) {

                this.$router.push({
                    name: "articulo_editar",
                    params: {
                        id: item.idUtensilio
                    }
                });
            },

            clckEliminar(itemEliminar) {

                let uri = `/uUtensilio_delete/${
                    itemEliminar.idUtensilio
                    }`;

                this.axios
                    .get(uri)
                    .then(response => {
                        this.mensajeInfo("Eliminado exitosamente");
                        var index = this.fItems.indexOf(itemEliminar);
                        if (index > -1) {
                            this.fItems.splice(index, 1);
                        }
                    })
                    .catch(error => {
                        this.mensajeError("Ocurrió un error");
                    });
            },
            clckNuevo() {
                this.$router.push({name: "articulo_nuevo"});
            }

        }
    }
</script>