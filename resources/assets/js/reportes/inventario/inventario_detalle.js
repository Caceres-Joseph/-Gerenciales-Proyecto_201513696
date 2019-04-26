import * as math from 'mathjs' 
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
                    text: "id Articulo",
                    value: "idArticulo"
                },
                {
                    text: "Articulo",
                    value: "nombre"
                },
                {
                    text: "S. Sistema",
                    value: "stock_Sistema"
                },
                {
                    text: "S. Físico",
                    value: "stock_Fisico"
                },
                {
                    text: "Diferencia",
                    value: "diferencia"
                },
                /* {
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
            let uri = this.ip + `detalleInventario_getItemsId/${
                this.$route.params.id
            }`;
            this.axios.get(uri).then(response => {
                this.ventas = response.data;
                this.println(response.data);
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
                'idInventario': this.$route.params.id
            };

            let uri = this.ip + "inventarioImprimir_reimpresion";

            this.axios.post(uri, enviar).then(response => {
                this.mensajeInfo("Realizando operación :)");
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
        },


        /* 
        |--------------------------------------------------------------------------
        | FUNCIONES
        |--------------------------------------------------------------------------
        */
        improperFractionToMixedNumber(n, d) {
            var retorno = "";
            var i = parseInt(n / d);
            n -= i * d;
            //return [i, n, d];

            if (i != 0) {
                retorno = String(i) + " ";
            }
            if (n != 0) {
                retorno += String(n) + "/" + String(d);
            }

            return retorno;
        },
        improperFractionToMixedNumber1(s,n, d) {
            var retorno = "";

            if (s==-1) {
                retorno = "-";
            }
            var i = parseInt(n / d);
            n -= i * d;
            //return [i, n, d];

            if (i != 0) {
                retorno += String(i) + " ";
            }
            if (n != 0) {
                retorno += String(n) + "/" + String(d);
            }

            return retorno;
        },

        substractFrac(item) {
            

            var n1 = item.stockFisico_numerador;
            var d1 = item.stockFisico_denominador;


            var n2 = item.stockSistema_numerador;
            var d2 = item.stockSistema_denominador;


            
            
            math.config({
                number: 'Fraction'
            })
         
            var result = math.subtract(math.fraction(n1, d1), math.fraction(n2, d2));
            


            this.println(result);

            result = this.improperFractionToMixedNumber1(result.s,result.n,result.d);
            return result;
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