export default {
    props: ['ip'],
    data() {
        return {
            /* SnackBar */
            snackColor: "teal darken-4",
            snackStatus: false,
            sanckText: " ",


            /* Dia */
            day: null,
            menu: false,


            /* TABLA */

            headers: [
            
                {
                    text: "#Ventas",
                    value: "numVentas", 
                },                
                {
                    text: "Articulo",
                    value: "nombreArticulo", 
                },       
                
            ],
            ventas: [],
             
            search: "",

            /* MOSTRAR */
            mostrar: {
                fecha: "",
                efectivo: 0.0,
                tarjeta: 0.0,
                total: 0.0,
            }, 

        };
    },
    computed: {

    },
    created() {

    },
    methods: {
 
        /*
        +------------------------------------------------+
        |   Click
        +------------------------------------------------+
        */

        clckAceptar() {

            if (this.day == null) {
                this.mensajeAdvertencia("Seleccione una fecha");
                return;
            }
            //enviando la fecha
            var enviar = {
                'fecha': this.day
            }; 

            let uri = this.ip + "dia_ventaBarra";
            var ele;
            this.axios.post(uri, enviar).then(response => {
                //this.println(response.data);
                this.ventas = response.data;
                /*   if (response.data[0].total!=null) {
                    this.mostrar = response.data[0];
                    this.ventas = response.data[1];
                }   */
                //this.ventas = response.data;
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
        }, 

        /*
        +------------------------------------------------+
        |   IMPRIMIR
        +------------------------------------------------+
        */
        
        imprimir() {
            
            if (this.day == null) {
                this.mensajeAdvertencia("Seleccione una fecha");
                return;
            }
            //enviando la fecha
            var enviar = {
                'fecha': this.day
            }; 

            let uri = this.ip + "Imprimir_DiaVentaBarra";
           
            this.axios.post(uri, enviar).then(response => { 


            }).catch(error => {
                this.mensajeError("");
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