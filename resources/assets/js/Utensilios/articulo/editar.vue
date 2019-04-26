<template>


    <v-progress-linear
            :indeterminate="true"
            v-if="cargando"
    ></v-progress-linear>

    <formulario
            :clckAceptar="clckAceptar"
            :color="colorDefecto"
            :configuracion="fConfiguracion"
            :jsonPreguntas="fJsonPreguntas"
            :titulo="fTitulo"
            ref="form"
            v-else
    ></formulario>

</template>

<script>

    import nuevo from './nuevo.vue'

    export default {
        mixins: [nuevo],

        data: () => ({
            fTitulo: "Editar utensilio",
            cargando: true,
            tempData: {}
        }),

        created() {
            this.inicializar();

        },
        updated() {

            if (!this.cargando) {
                this.$refs.form.itemRetorno = this.tempData;
            }
        },

        methods: {
            /*
            |-------------------------
            | Inicio
            |-------------------------
            */
            inicializar() {
                window.scrollTo(0, 0);
                this.fJsonPreguntas = this.getPreguntas();
                let uri = `/uUtensilio_getItem2/${
                    this.$route.params.id
                    }`;

                this.axios.get(uri).then(response => {
                    this.tempData = response.data;
                    if (response.data.idCategoria != null) {
                        this.fJsonPreguntas[5].check = true;
                    }

                    this.cargando = false;
                });

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


                let uri = `/uUtensilio_update/${
                    this.$route.params.id
                    }`;

                this.axios
                    .post(uri, item)
                    .then(response => {
                        this.mensajeInfo("Utensilio modificado correctamente");
                        this.$refs.form.clckCancelar();
                    })
                    .catch(error => {
                        this.mensajeError("Ocurrió un error al modificar el utensilio");
                    });

            },

        }
    }
</script>
