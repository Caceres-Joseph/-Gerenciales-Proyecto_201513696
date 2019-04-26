<template>


    <tabla
            :clckAsistencia="clckAsistencia"
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
    import tabla from '../../modules/Tabla3/eTabla.vue'
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

        destroyed() {
            document.removeEventListener("keyup", this.atajos);
        },
        mounted() {
            document.addEventListener("keyup", this.atajos);
        },

        data: () => ({

            fItems: [],
            fTitulo: "Proveedores",
            fEncabezado: []

        }),

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


                encabezados.tituloSimple("Id", "idPersona")
                encabezados.tituloSimple("Nombre", "nombre")
                encabezados.tituloSimple("Documento", "tipo_documento")
                encabezados.tituloSimple("No. Doc", "num_documento")
                encabezados.tituloSimple("Direccion", "direccion")
                encabezados.tituloSimple("Telefono", "telefono")
                encabezados.tituloSimple("Correo", "correo")
                encabezados.tituloAccion();

                return encabezados.getJsonEncabezado();
            },

            iniItems() {

                let uri = "/planilla_getItems";
                this.axios
                    .get(uri)
                    .then(response => {
                        this.fItems = response.data;
                        this.$log.info(response.data);

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

            clckAsistencia(item) {

                this.$router.push({
                    name: "asistencia",
                    params: {
                        id: item.idPersona,
                        nombre:item.nombre
                    }
                });
            },

            clckEliminar(itemEliminar) {

                let uri = `/proveedor_delete/${
                    itemEliminar.idPersona
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