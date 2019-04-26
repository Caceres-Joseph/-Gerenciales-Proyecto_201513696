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
                    text: "#Orden",
                    value: "idOrden", 
                },                
                {
                    text: "#Caja",
                    value: "idCaja", 
                },                
                {
                    text: "Efectivo",
                    value: "efectivo", 
                    align: 'right',
                },
                {
                    text: "Tarjeta",
                    value: "tarjeta", 
                    align: 'right',
                },
                {
                    text: "Total",
                    value: "total", 
                    align: 'right',
                }, 
                {
                    text: "Fecha/Hora Orden",
                    value: "ordenFecha",  
                }, 
                {
                    text: "Hora Cobro",
                    value: "constanciaFecha",
                }, 
                {
                    text: "Mesero",
                    value: "mesero",
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

            let uri = this.ip + "dia_ventaGeneral";
            var ele;
            this.axios.post(uri, enviar).then(response => {
                //this.println(response.data);
                  if (response.data[0].total!=null) {
                    this.mostrar = response.data[0];
                    this.ventas = response.data[1];
                }  
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
            /* t his.println(this.reporteActual);
             if (this.reporteActual.accion == "diaConUsuario") {
                 let uri = this.ip + "Imprimir_reporteDiaConUsuarios";
                 this.axios
                     .post(uri, this.reporteActual)
                     .then(response => {

                         this.println(response.data);
                     })
                     .catch(error => {
                         this.mensajeError("Error al realizar la consulta");
                     });
             } */
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