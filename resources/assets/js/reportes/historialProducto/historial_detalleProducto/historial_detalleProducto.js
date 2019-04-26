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
                    text: " ",
                    value: "operacion",
                    sortable: false
                },
            
                {
                    text: "D",
                    value: "domingo",
                    sortable: false
                },
                {
                    text: "L",
                    value: "lunes",
                    sortable: false
                },
                {
                    text: "M",
                    value: "martes",
                    sortable: false
                },
                {
                    text: "Mi",
                    value: "miercoles",
                    sortable: false
                },
                {
                    text: "J",
                    value: "jueves",
                    sortable: false
                },
                {
                    text: "V",
                    value: "viernes",
                    sortable: false
                },
                {
                    text: "S",
                    value: "sabado",
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

            /* FECHA */

            delFecha: "",
            alFecha:"",
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
            var enviar = {
                'idArticulo': this.$route.params.id, 
                'fecha': this.day
            };
 
            let uri = this.ip + "semana_historialProductoDetalle";
            var ele;
            this.axios.post(uri, enviar).then(response => {
                this.println(response.data); 
                this.ventas = response.data[0];
                this.delFecha = response.data[1][0];
                this.alFecha = response.data[1][6];
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
                'nombre': this.$route.params.nombre,
                'idArticulo': this.$route.params.id, 
                'fecha': this.day
            };

            let uri = this.ip + "reportesImprimir_historialProductoDetalle";
            
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