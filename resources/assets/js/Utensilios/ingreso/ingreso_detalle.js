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
    computed: {

    },
    created() {
        this.inicializar();
    },
    methods: {
        inicializar() {
            this.cargarTabla();
        },

        cargarTabla() {
            let uri = this.ip + `DetalleIngreso_getItemsIdIngreso/${
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