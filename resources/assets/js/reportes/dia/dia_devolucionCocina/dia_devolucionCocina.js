export default {
    props: ['ip'],
    data() {
        return {
            /* SnackBar */
            snackColor: "teal darken-4",
            snackStatus: false,
            sanckText: " ",
 

            /* TABLA */

            headers: [
                {
                    text: "Artículo",
                    value: "nombre",
                },
                /* {
                    text: "Stock Bodega",
                    value: "stockBodega",
                }, */
                {
                    text: "Stock Barra",
                    value: "stockBarra",
                }

            ],
            ventas: [],

            search: "",
        };
    },
    computed: {

    },
    created() {
        this.inicializar();
    },
    methods: {
        inicializar() {
            let uri = this.ip + "stock_items";
            var ele;
            this.axios.get(uri).then(response => {
                //this.println(response.data); 
                this.ventas = response.data; 
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

            let uri = this.ip + "Imprimir_Stock_Barra";
            this.axios.get(uri).then(response => {

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