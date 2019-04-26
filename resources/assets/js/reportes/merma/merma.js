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


            /* Dia2 */
            day2: null,
            menu2: false,

            /* TABLA */

            headers: [

                {
                    text: "idArticulo",
                    value: "idArticulo",
                },
                {
                    text: "Nombre",
                    value: "nombre",
                },
                {
                    text: "Stock Fisico",
                    value: "stockFisico",
                },
                {
                    text: "Stock Sistema",
                    value: "stockSistema",
                    align: 'right',
                },
                {
                    text: "Diferencia",
                    value: "stockDiferencia",
                    align: 'right',
                }
            ],
            rows: [],

            search: ""


        }
    },
    created() {

    },
    methods: {

        /*
        +------------------------------------------------+
        |   INICIALIZAR
        +------------------------------------------------+
        */

        Inicializar() {

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

        decimalToFraction(numero) {
            math.config({
                number: 'Fraction'
            })

            // use the expression parser
            var ele = math.fraction(numero);
            /* this.println(ele);
            this.println(numero);
            this.println("---"); */
            return this.improperFractionToMixedNumber(ele.s*ele.n,ele.d);
 
        },
        /*
        +------------------------------------------------+
        |   CLICK
        +------------------------------------------------+
        */

        clckAceptar() {

            if (this.day == null || this.day2 == null) {
                this.mensajeAdvertencia("Seleccione una fecha");
                return;
            }



            //enviando la fecha
            var enviar = {
                'fecha': this.day,
                'fecha2': this.day2
            };

            let uri = this.ip + "detalleInventario_getItemsMerma";

            this.axios.post(uri, enviar).then(response => {
                //this.println(response.data);
                this.rows = response.data;
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

}