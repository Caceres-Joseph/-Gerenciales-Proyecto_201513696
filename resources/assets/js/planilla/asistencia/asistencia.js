import getDefaultData from "./asistenciaD.js";

export default {


    props: {
        colorDefecto: String,
        buscar: String
    },
    data: getDefaultData,

    created() {

    },
    methods: {

        /*
        +------------------------------------------------+
        |   INICIALIZAR
        +------------------------------------------------+
        */

        Inicializar() {

        },

        /* 
        |--------------------------------------------------------------------------
        | FUNCIONES
        |--------------------------------------------------------------------------
        */

        /*
        +------------------------------------------------+
        |   CLICK
        +------------------------------------------------+
        */

        clckAceptar() {

            if (this.day == null || this.day2 == null) {
                this.mensajeAdvertencia("Seleccione una fecha");
                return;
            }


            //enviando la fecha
            var enviar = {
                'fecha': this.day,
                'fecha2': this.day2,
                'id':this.$route.params.id
            };

            let uri = "/planilla_asistencia";


            this.axios.post(uri, enviar).then(response => {


                this.mensajeInfo(response.data[0]);
                this.ventas=response.data[1];
                this.itemEnviar.horas=response.data[2];
                this.println(response.data);
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });

        },


        imprimir() {


            if (this.day == null || this.day2 == null) {
                this.mensajeAdvertencia("Seleccione una fecha");
                return;
            }


            //enviando la fecha
            var enviar = {
                'fecha': this.day,
                'fecha2': this.day2,
                'id':this.$route.params.id,
                'nombre':this.$route.params.nombre
            };

            let uri = "/planilla_asistenciaImprimir";


            this.axios.post(uri, enviar).then(response => {
                this.println(response.data);
                this.mensajeInfo("Imprimiendo");
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });

        },


        /*
        +------------------------------------------------+
        |   MENSAJES
        +------------------------------------------------+
        */
        println(mensaje) {
            this.$log.info(mensaje);
        },
        mensajeError(mensaje) {
            this.snackColor = "red";
            this.sanckText = "[Error] " + mensaje;
            this.snackStatus = true;
        },
        mensajeInfo(mensaje) {
            this.snackColor = "light-blue darken-4";
            this.sanckText = mensaje;
            this.snackStatus = true;
        },
        mensajeAdvertencia(mensaje) {
            this.snackColor = "amber darken-4";
            this.sanckText = "[Advertencia] " + mensaje;
            this.snackStatus = true;
        },

    }

}