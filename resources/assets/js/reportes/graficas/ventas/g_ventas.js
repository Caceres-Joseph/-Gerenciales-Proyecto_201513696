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

            txtTitulo:"Grafica",


            search: "",

            // Array will be automatically processed with visualization.arrayToDataTable function
            chartData: [
                ['--', '--', '--', '--'],
                ['--', 0, 0, 0]
            ],
            chartOptions: {
                /* chart: {
                    title: '--',
                    subtitle: '--, --, --',
                }, */
                legend: { position: 'bottom' }
                , height: 900
                /* hAxis: { maxValue: 7 },
                vAxis: { maxValue: 13 },  
                lineWidth: 10 */
            },

            typeColumn:"ColumnChart",


            //boton toggle

            toggle_exclusive: null,
            toggle_exclusive2: null,


            /* MESERO */

            checkMesero: false,

            /* fasf */
            usuarios: [],
            idUsuarioPadre: null,
            txtPropina :"",
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
            return this.improperFractionToMixedNumber(ele.s * ele.n, ele.d);

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

            let uri = this.ip + "grafica_ventasDia";
            this.txtTitulo = "Gráfica de ventas por día";

            this.axios.post(uri, enviar).then(response => {
                //this.println(response.data);
                //this.rows = response.data;
                this.println(response.data);
                //this.chartData = new google.visualization.DataTable(response.data);
                this.chartData = response.data;
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
            this.txtPropina = "";
        },

        clckAbonosGastos() {

            if (this.day == null || this.day2 == null) {
                this.mensajeAdvertencia("Seleccione una fecha");
                return;
            }
 
            //enviando la fecha
            var enviar = {
                'fecha': this.day,
                'fecha2': this.day2
            };

            let uri = this.ip + "grafica_abonoGastoDia";
            this.txtTitulo = "Gráfica de abonos y gastos por día";

            this.axios.post(uri, enviar).then(response => {  
                this.chartData = response.data;
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
            this.txtPropina = "";
        },



        clckMeseros() {
            if (this.idUsuarioPadre==null) {
                this.mensajeAdvertencia("Seleccione un mesero");
                return;
            }

            if (this.day == null || this.day2 == null) {
                this.mensajeAdvertencia("Seleccione una fecha");
                return;
            }
 
            //enviando la fecha
            this.println(this.idUsuarioPadre);
            var enviar = {
                'fecha': this.day,
                'fecha2': this.day2,
                'idMesero': this.idUsuarioPadre.idUsuario
            };

            let uri = this.ip + "grafica_meserosDia";
            this.txtTitulo = "Gráfica de venta de meseros por día";

            this.axios.post(uri, enviar).then(response => {  
                this.chartData = response.data;
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
            this.txtPropina = "";
        },

        clckMeseros2() {
            if (this.day == null || this.day2 == null) {
                this.mensajeAdvertencia("Seleccione una fecha");
                return;
            }
 
            //enviando la fecha
            var enviar = {
                'fecha': this.day,
                'fecha2': this.day2
            };

            let uri = this.ip + "grafica_meserosDia2";
            this.txtTitulo = "Gráfica de meseros por rango de fecha";

            this.axios.post(uri, enviar).then(response => {  
                this.chartData = response.data;
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
            this.txtPropina = "";
            
        },

        clckMerma() {
            
            if (this.day == null || this.day2 == null) {
                this.mensajeAdvertencia("Seleccione una fecha");
                return;
            }
 
            //enviando la fecha
            var enviar = {
                'fecha': this.day,
                'fecha2': this.day2
            };

            let uri = this.ip + "grafica_mermasDia";
            this.txtTitulo = "Gráfica de mermas por artículo";

            this.axios.post(uri, enviar).then(response => {  
                this.chartData = response.data;
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
            this.txtPropina = "";
        },

        clckDiferencia() {
            
            if (this.day == null || this.day2 == null) {
                this.mensajeAdvertencia("Seleccione una fecha");
                return;
            }
 
            //enviando la fecha
            var enviar = {
                'fecha': this.day,
                'fecha2': this.day2
            };

            let uri = this.ip + "grafica_diferenciaDia";
            this.txtTitulo = "Gráfica de diferencias en el cierre por día";

            this.axios.post(uri, enviar).then(response => {  
                this.chartData = response.data;
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
                });
            
            this.txtPropina = ""; 
        },
        clckPropina() {
            if (this.day == null || this.day2 == null) {
                this.mensajeAdvertencia("Seleccione una fecha");
                return;
            }
 
            //enviando la fecha
            var enviar = {
                'fecha': this.day,
                'fecha2': this.day2
            };

            let uri = this.ip + "grafica_propinaMesero";
            this.txtTitulo = "Gráfica de propinas por mesero";

            this.axios.post(uri, enviar).then(response => {  
                this.chartData = response.data[0];
                this.txtPropina = "Total de propina: Q" + response.data[1];
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
            
        },


        /*
        +------------------------------------------------+
        |   Grafica opciones
        +------------------------------------------------+
        */
        clckVertical() { 
            
            this.typeColumn = "BarChart";
        },
        clckHorizontal() {  
                this.typeColumn = "ColumnChart";
         
            
        },
        clckBarra() {
            this.typeColumn = "ColumnChart";
        },
        clckLinea() {
            this.typeColumn = "LineChart";
        },

        /*
        +------------------------------------------------+
        |   Chcek box
        +------------------------------------------------+
        */
        checkBoxMesero(e) {

            if (!e) {
                this.usuarios = [];
                //si es falso
                /* this.MedidaModel = null;
                this.idMedidaPadre = null; */
                this.idUsuarioPadre = null;
            } else {
                this.cargarMeseros();
            }
        },
        /*
        +------------------------------------------------+
        |   Cargar combo box
        +------------------------------------------------+
        */
        cargarMeseros() {
            let uri = this.ip + "Usuario_itemsId";
            this.axios.get(uri).then(response => {
                this.usuarios = response.data;
            });
        },
        /*
        +------------------------------------------------+
        |   Cambio combo box
        |   Aqui cargo tambien las vistas si es que ya existe
        +------------------------------------------------+
        */

        cbCambioUsuario(e) {
            if (e.idUsuario != null) {
                this.idUsuarioPadre = e;
                //this.println(e.idUsuario);
            }
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