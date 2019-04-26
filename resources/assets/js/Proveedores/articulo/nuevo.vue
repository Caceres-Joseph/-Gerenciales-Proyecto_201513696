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

        mixins:[mensajes],

        components: {
            formulario
        },

        data: () => ({
            fTitulo: "Nuevo proveedor",
            fJsonPreguntas: [],
            fConfiguracion: {
                'rutaCancelar': 'articulo',
            },

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
            inicializar(){
                this.fJsonPreguntas = this.getPreguntas();
                window.scrollTo(0, 0);

            },
            inicializar2(){

                this.inicializar();
                this.$refs.form.reset();
            },

            getPreguntas(){
                var preg = new preguntas();
                preg.preguntaSimple('nombre', 'Nombre', true);
                preg.preguntaSimple('tipo_documento', 'Tipo de documento', false);
                preg.preguntaSimple('num_documento', 'No. Documento', false);
                preg.preguntaSimple('direccion', 'Dirección', false);
                preg.preguntaSimple('telefono', 'Teléfono', false);
                preg.preguntaSimple('correo', 'Correo', false);


                /*let uri = "/uCategoria_getItems2";
                this.axios.get(uri).then(categorias => {
                    preg.preguntaMultipleCheck('idCategoria', 'Categoría', categorias.data, false);
                });*/
                return preg.getJson();
            },

            /*
            |-------------------------
            | Click
            |-------------------------
            */
            clckAceptar() {

                var item = this.$refs.form.itemRetorno;
                if(this.validaciones(item))
                    return;


                let uri ="/proveedor_insert";
                this.axios
                    .post(uri, item)
                    .then(response => {
                        this.$log.info(response.data);
                        this.mensajeInfo("Proveedor registrado correctamente");
                        this.inicializar2();
                    })
                    .catch(error => {
                        this.$log.info(error);
                        this.mensajeError("Ocurrió un error al registrar el proveedor");
                    });

            },

            /*
            |-------------------------
            | Select
            |-------------------------
            */
            validaciones(item){
                if(item.nombre==null||item.nombre==""){
                    this.mensajeAdvertencia("Tiene que colocar el nombre");
                    return true;
                }
                return false;
            }
        }
    }
</script>