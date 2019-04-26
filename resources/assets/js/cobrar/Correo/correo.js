export default {
    props: ['ip'],
    data() {
        return {
            /* SnackBar */
            snackColor: "teal darken-4",
            snackStatus: false,
            sanckText: " ",


            /* ID de la caja*/
            txtIdCaja: "",

            estadoBoton:true

        };
    },


    created() {

        window.scrollTo(0, 0);

        //this.inicializar();
    },
    methods: {

        inicializar() {
            let uri = this.ip + "cuarentena_getItems";
            var ele;
            this.axios.get(uri).then(response => {
                //this.println(response.data); 
                this.listado = response.data;
                /*   if (response.data[0].total!=null) {
                    this.mostrar = response.data[0];
                    
                }   */
                //this.ventas = response.data;
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
        },
        /*
        +------------------------------------------------+
        |   Click
        +------------------------------------------------+
        */

        clckEnviar() {
            this.estadoBoton=false;

            let uri = `/Correo_IdCaja/${
                this.txtIdCaja
                }`;

            this.axios.get(uri).then(response => {
                this.mensajeInfo("Se envió el correo");
                this.estadoBoton=true;
            })
            .catch(error => {
                this.mensajeError("No se pudo enviar el correo, probablemente no exista el Id especificado");
                this.estadoBoton=true;
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
};