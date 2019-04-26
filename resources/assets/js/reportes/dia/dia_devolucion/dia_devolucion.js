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

            headers: [{
                    text: "idCaja \n Agregada",
                    value: "idCaja",
                },
                {
                    text: "Cajero \n Agregada",
                    value: "cajero",
                },
                {
                    text: "Fecha/hora \n Agregada",
                    value: "fecha_horaAgregada",
                },
                {
                    text: "idCaja \n Aceptada",
                    value: "idCajaAceptar",
                },
                {
                    text: "Cajero \n Aceptada",
                    value: "cajeroAceptar",
                },
                {
                    text: "Fecha/hora \n Aceptada",
                    value: "fecha_horaAceptada",
                },
                {
                    text: "#Orden",
                    value: "idOrden",
                },
                {
                    text: "Observacion",
                    value: "observacion",
                },
                {
                  text: "Acciones",
                  sortable: false
                }

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
 
            let uri = this.ip + "dia_devolucion";
            var ele;
            this.axios.post(uri, enviar).then(response => {
                //this.println(response.data); 
                this.ventas = response.data;
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

            let uri = this.ip + "reportesImprimir_diaDevolucion";
            
            this.axios.post(uri, enviar).then(response => {
                
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
        },


        /*
        +------------------------------------------------+
        |   ACCION
        +------------------------------------------------+
        */
        accVerItem(item) {
            //this.println(item);
            this.$router.push({
                name: "detalleOrden",
                params: { id: item.idOrden}
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