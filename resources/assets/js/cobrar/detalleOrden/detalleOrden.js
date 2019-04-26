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
            },

            /*
            |------------------ 
            | Password
            |------------------- 
            */
            dlgPassword: false,
            txtPassword: "",
            itemPassword: null,
            accionPassword: "",


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

        clckDevolucion() {

            //this.println(this.$route.params.idCuarentena);

            let uri = this.ip + "cuarentena_setDevolucion";
            this.axios.post(uri, this.$route.params).then(response => {
                this.$router.push({
                    name: "cuarentena"
                });
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });

        },

        clckRecuperar() {

            this.dlgPassword = true;

        },
 
        clckPasswordAceptar() {


                let uri = this.ip + "Orden_setRecuperar";
                this.axios.post(uri, this.$route.params).then(response => {
                    this.$router.push({
                        name: "cuarentena"
                    });
                }).catch(error => {
                    this.mensajeError("Error al realizar la consulta");
                });

            this.txtPassword = "";
            this.dlgPassword = false;
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