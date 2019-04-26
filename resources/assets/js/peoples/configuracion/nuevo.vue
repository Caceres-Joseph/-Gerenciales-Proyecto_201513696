<template>


    <formulario
            :clckAceptar="clckAceptar"
            :color="colorDefecto"
            :configuracion="fConfiguracion"
            :jsonPreguntas="fJsonPreguntas"
            :titulo="fTitulo"
            ref="form"
    ></formulario>



</template>

<script>
    import formulario from '../../modules/Formulario/eFormulario.vue'
    import {preguntas} from '../../modules/Formulario/preguntas'
    import mensajes from '../../modules/SnackBar/mensajes.js'

    export default {
        props: {
            colorDefecto: String
        },

        mixins: [mensajes],

        components: {
            formulario,
        },

        data: () => ({
            fTitulo: "Nuevo utensilio",
            fJsonPreguntas: [],
            fConfiguracion: {
                'rutaCancelar': 'articulo',
            },


            time: '11:15'

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
                this.fJsonPreguntas = this.getPreguntas();
                window.scrollTo(0, 0);

            },
            inicializar2() {

                this.inicializar();
                this.$refs.form.reset();
            },

            getPreguntas() {
                var preg = new preguntas();
                preg.preguntaSimple('nombre', 'Nombre', true);
                preg.preguntaSimple('descripcion', 'Descripción', false);
                preg.preguntaSimple('codigo', 'Codigo', false);
                preg.preguntaMonetaria('precioCompra', 'Precio de compra', true);
                preg.preguntaMonetaria('precioVenta', 'Precio de venta', false);


                let uri = "/uCategoria_getItems2";
                this.axios.get(uri).then(categorias => {
                    preg.preguntaMultipleCheck('idCategoria', 'Categoría', categorias.data, false);
                });
                return preg.getJson();
            },

            /*
            |-------------------------
            | Click
            |-------------------------
            */
            clckAceptar() {

                var item = this.$refs.form.itemRetorno;
                if (this.validaciones(item))
                    return;


                let uri = "/uUtensilio_insertItem";
                this.axios
                    .post(uri, item)
                    .then(response => {
                        this.$log.info(response.data);
                        this.mensajeInfo("Utensilio registrado correctamente");
                        this.inicializar2();
                    })
                    .catch(error => {
                        this.$log.info(error);
                        this.mensajeError("Ocurrió un error al registrar el utensilio");
                    });

            },

            /*
            |-------------------------
            | Select
            |-------------------------
            */
            validaciones(item) {
                if (item.nombre == null || item.nombre == "") {
                    this.mensajeAdvertencia("Tiene que colocar el nombre");
                    return true;
                }
                if (item.precioCompra == null || item.precioCompra == "") {
                    this.mensajeAdvertencia("Tiene que colocar el precio de compra");
                    return true;
                }
                return false;
            }
        }
    }
</script>