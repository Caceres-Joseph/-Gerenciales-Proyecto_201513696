


export default {


    methods: {

        /*
        |--------------------------------------------------------------------------
        | Botones
        |--------------------------------------------------------------------------
        */
        mensajeInfo(mensaje) {
            this.$emit("mensajeInfo", mensaje);
        },
        mensajeError(mensaje) {

            this.$emit("mensajeError", mensaje);
        },
        mensajeAdvertencia(mensaje) {

            this.$emit("mensajeAdvertencia", mensaje);
        },

        println(mensaje){
            this.$log.info(mensaje);
        }
    }

}