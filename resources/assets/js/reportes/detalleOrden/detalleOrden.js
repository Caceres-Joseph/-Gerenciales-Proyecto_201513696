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
                    text: "Cantidad",
                    value: "cantidad",
                },
                {
                    text: "Articulo",
                    value: "nombreArticulo",
                },


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


            /* Total */
            detalleOrden: {
                propina: "0.00",
                subTotal: "0.00",
                total: "0.00",
                nombreLugar: "",
                nombreMesa: "",
                nombreUsuario: "",
                fechaHora: ""
            }

        };
    },
    computed: {

    },
    created() {
        this.inicializar();
    },
    methods: {

        inicializar() {
            let uri = this.ip + `DetalleOrdenIndividual_idOrdenAgrupados/${
                this.$route.params.id 
                }`;

            this.axios.get(uri).then(response => {
                //this.println(response.data);
                this.listado = response.data[0];
                this.detalleOrden = response.data[1];
                /*   if (response.data[0].total!=null) {
                    this.mostrar = response.data[0];
                    
                }   */
                //this.ventas = response.data;
                //this.println(this.detalleOrden);
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
        },

        /*
        +------------------------------------------------+
        |   Click
        +------------------------------------------------+
        */
        clckImprimir() {
            let uri = this.ip + `Reimprimir_Cuenta/${this.$route.params.id}`;
             
            this.axios
                .get(uri)
                .then(response => { 
                    this.mensajeInfo("Enviando a imprimir");
                })
                .catch(error => {
                    this.mensajeError("Error al imprimir");
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