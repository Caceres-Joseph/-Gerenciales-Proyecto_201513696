<template>


    <tabla
            :clckEditar="clckEditar"
            :clckEliminar="clckEliminar"
            :clckVer="clckVer"
            :clckVerCancelado="clckVerCancelado"
            :color="colorDefecto"
            :encabezado="fEncabezado"
            :items="fItems"
            :titulo="fTitulo"
            :buscar="buscar"
    ></tabla>


</template>

<script>
    import tabla from '../../modules/Tabla2/eTabla.vue'
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
            fTitulo: "Proveedores",
            fEncabezado: []

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

                let uri = "/proveedor_getItems";
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
                        id: item.idPersona
                    }
                });
            },
            clckVer(item) {

                this.$router.push({
                    name: "ingreso_listado",
                    params: { id: item.idPersona}
                });
            },
            clckVerCancelado(item){

                this.$router.push({
                    name: "ingreso_listadoC",
                    params: { id: item.idPersona}
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
            }

        }
    }
</script>