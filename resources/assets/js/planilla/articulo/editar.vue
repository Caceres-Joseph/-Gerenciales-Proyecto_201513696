<template>


    <v-progress-linear
            v-if="cargando"
            :indeterminate="true"
    ></v-progress-linear>

    <formulario
            v-else
            :clckAceptar="clckAceptar"
            :color="colorDefecto"
            :configuracion="fConfiguracion"
            :jsonPreguntas="fJsonPreguntas"
            :titulo="fTitulo"
            ref="form"
    ></formulario>

</template>

<script>

    import nuevo from './nuevo.vue'

    export default {
        mixins:[nuevo],

        data: () => ({
            fTitulo: "Editar empleado",
            cargando:true,
            dataTemp:{}
        }),

        created() {
            this.inicializar();
        },
        updated(){

            if(!this.cargando){
                this.$refs.form.itemRetorno = this.dataTemp;
            }
        },


        methods: {
            /*
            |-------------------------
            | Inicio
            |-------------------------
            */
            inicializar(){
                window.scrollTo(0, 0);
                this.fJsonPreguntas = this.getPreguntas();
                let uri = `/proveedor_item/${
                    this.$route.params.id
                    }`;

                this.axios.get(uri).then(response => {
                    this.dataTemp=response.data;
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
                if(this.validaciones(item))
                    return;


                let uri =`/proveedor_update/${
                    this.$route.params.id
                    }`;

                this.axios
                    .post(uri, item)
                    .then(response => {
                        this.mensajeInfo("Proveedor modificado correctamente");
                        this.$refs.form.clckCancelar();
                    })
                    .catch(error => {
                        this.mensajeError("Ocurrió un error al modificar");
                    });

            },

        }
    }
</script>
