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
                    text: "id Ingreso",
                    value: "idBodega_ingreso",
                },
                {
                    text: "Fecha/Hora Ingreso",
                    value: "fechaIngreso",
                },
                {
                    text: "Fecha Comp.",
                    value: "fechaComprobante",
                },
                {
                    text: "Tipo Comprobante",
                    value: "tipoComprobante",
                },
                {
                    text: "No. Comprobante",
                    value: "numComprobante",
                },
                {
                    text: "Proveedor",
                    value: "proveedor",
                },
                {
                    text: "Usuario",
                    value: "usuario",
                },
                {
                    text: "Total",
                    value: "total",
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
        this.inicializar();
    },
    methods: {
        inicializar() {
            let uri ="/Bodega_items2";
            var ele={
                idPersona:this.$route.params.id,
                cancelado:true
            };

            this.axios.post(uri,ele).then(response => {
                //this.println(response.data);
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

        clckAceptar() {




        },
        clckVer(item) {
            this.$router.push({
                name: "ingreso_detalleC",
                params: { id: item.idBodega_ingreso, proveedor:item.proveedor,total:item.total,tipo:item.tipoComprobante,num:item.numComprobante, fecha:item.fechaComprobante}
            });
        },
        /*
        +------------------------------------------------+
        |   IMPRIMIR
        +------------------------------------------------+
        */

        imprimir() {



            let uri = this.ip + "Imprimir_DiaOrdenCortesia";
            var ele;
            this.axios.post(uri, enviar).then(response => {

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

    }
};