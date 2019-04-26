export default {
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
                text: "Cant.",
                value: "cantidad"
            },
                {
                    text: "Nombre",
                    value: "nombre"
                },
                {
                    text: "Compra",
                    value: "compra"
                },
                {
                    text: "Total",
                    value: "total"
                },
                {
                    text: "Vencimiento",
                    value: "fecha_vencimiento"
                }/* ,
                {
                    text: "Acciones",
                    sortable: false
                } */
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
    computed: {},
    created() {
        this.inicializar();
    },
    methods: {
        inicializar() {
            this.cargarTabla();
        },

        cargarTabla() {
            let uri = `/DetalleIngreso_getItemsIdIngreso/${
                this.$route.params.id
                }`;
            this.axios.get(uri).then(response => {
                this.ventas = response.data;
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
        },
        /*
        +------------------------------------------------+
        |   Click
        +------------------------------------------------+
        */

        imprimir() {
            var enviar = {
                'idIngreso': this.$route.params.id
            };

            let uri = "/ingresoImprimir_reimprimirIngresoId";

            this.axios.post(uri, enviar).then(response => {
                this.mensajeInfo("Realizando operación :)");
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
        },


        imprimirCancelado() {
            var enviar = {
                'idIngreso': this.$route.params.id
            };

            let uri = "/ingresoImprimir_reimprimirIngresoIdCancelado";

            this.axios.post(uri, enviar).then(response => {
                this.mensajeInfo("Realizando operación :)");
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


        dineroCaja() {


            let uri = `/Bodega_update2/${
                this.$route.params.id
                }`;

            this.axios
                .get(uri)
                .then(response => {

                    this.imprimirCancelado();

                    this.$router.push({
                        name: "articulo",
                    });

                })
                .catch(error => {
                    this.mensajeError("Ocurrió un error al modificar");
                });
        },


        clckCancelar() {


            var item = {
                nombre: "Pago proveedor:" + this.$route.params.proveedor + "  id-Ingreso:" + this.$route.params.id,
                monto: this.$route.params.total.replace(".", ","),
                observacion: "Pago desde proveedores: idIngreso:" + this.$route.params.id
            };
            //Abono_insertItem
            //
            let uri = "/Gasto_insertItem";

            this.axios
                .post(uri, item)
                .then(response => {

                    this.$log.info(response.data);
                    this.dineroCaja();


                })
                .catch(error => {
                    this.mensajeError("Error al registrar, revise si hay caja abierta");
                    this.$log.info(error);
                });

        },

    }
};