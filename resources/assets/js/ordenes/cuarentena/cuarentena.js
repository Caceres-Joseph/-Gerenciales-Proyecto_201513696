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
                    text: "#Caja",
                    value: "idCaja",
                },
                {
                    text: "Cajero",
                    value: "cajero",
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
                    text: "Fecha/Hora",
                    value: "fecha_Hora",
                },
                {
                    text: "Acciones",
                    sortable: false
                }

            ],
            listado: [],

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
        this.inicializar();
    },
    methods: {

        inicializar() {
            let uri = this.ip + "cuarentena_getItemsActualUsuario";

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

        itemsTable() {
            /* setTimeout(() => {
                this.insertar();
            }, 400); */
            var retorno = [];
            let uri = this.ip + "cuarentena_getItemsActualUsuario";
            this.axios.get(uri).then(response => {
                retorno = response.data;
                this.println(retorno);
                return retorno;
                //this.println(retorno);
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
                });
            
            setTimeout(() => {
                this.println("llego aqui");
                this.println(retorno);
                return retorno;
                }, 400);
            
                
            /* this.println(retorno);
            return retorno; */
        },
        /*
        +------------------------------------------------+
        |   Click
        +------------------------------------------------+
        */


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

            let uri = this.ip + "Imprimir_DiaOrdenCortesia";
            var ele;
            this.axios.post(uri, enviar).then(response => {

            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
        },


        /*
        +------------------------------------------------+
        |   TABLA
        +------------------------------------------------+
        */

        accVerItem(item) {
            //this.println(item);
            this.$router.push({
                name: "detalleOrden",
                params: {
                    id: item.idOrden
                }
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