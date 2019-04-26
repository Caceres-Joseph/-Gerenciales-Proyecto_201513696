import getDefaultData from "./gastoD.js";

export default {
    props: ['ip'],

    data: getDefaultData,

    created() {
        this.inicializar();
    },
    methods: {

        inicializar() {

            this.date = this.getToday();
            this.focus();
            window.scrollTo(0, 0);

        },
        focus() {
            setTimeout(() => {
                this.$nextTick(this.$refs.fcTxtNombre2.focus);
            }, 500);

        },

        focus2() {
            setTimeout(() => {
                this.$nextTick(this.$refs.fcTxtNombre.focus);
            }, 500);

        },
        /*
        +------------------------------------------------+
        |   CLICK
        +------------------------------------------------+
        */
        clckAceptar() {

            this.$log.info(this.item);
            //Abono_insertItem
            //

            var enviar={
                nombre:"["+this.item.comprobante+":"+this.item.numComprobante+":"+this.date.toString()+"]"+this.item.nombre
                ,
                observacion:this.item.observacion,
                monto:this.item.monto
            }

            let uri = this.ip + "Gasto_insertItem";

            this.axios
                .post(uri, enviar)
                .then(response => {
                    this.mensajeInfo("Gasto ingresado a caja exitosamente");

                    Object.assign(this.$data, getDefaultData());
                    this.inicializar();

                })
                .catch(error => {
                    this.mensajeError("Error al registrar, revise si hay caja abierta");
                    this.$log.info(error);
                });
            this.focus();
        },

        clckCancelarStepper(){
            Object.assign(this.$data, getDefaultData());
            this.inicializar();
        },
        /*
        +------------------------------------------------+
        |   Mensajes
        +------------------------------------------------+
        */
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

        /*
        +------------------------------------------------+
        |   Mensajes
        +------------------------------------------------+
        */

        getToday() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }

            if (mm < 10) {
                mm = '0' + mm
            }

            today = yyyy + '-' + mm + '-' + dd;
            return today;
        },


    }
};