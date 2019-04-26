import * as math from 'mathjs' 
export default {
    props: ['ip'],
    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    */

    data: () => ({ 
        /* 
         *Funciones
         */
        campoObligatorio: [v => !!v || "Este campo es obligatorio"],

        snackColor: "teal darken-4",
        snackStatus: false,
        sanckText: " ",


        /* Para la tabla */
        headers: [{
                text: "Cant.",
                sortable: false

            },
            {
                text: "Articulo",
                value: "nombre"
            },
            {
                text: "idArticulo",
                value: "idArticulo"
            },
            {
                text: "Acciones",
                sortable: false
            }
        ],
        subProductosItems: [],

        /* RADIO */
        radioGroup: 0,
        radioButtons2: [{
                nombre: "Movimiento en la semana",
                id: 0
            },
            {
                nombre: "Todos",
                id: 1
            }
            /* ,
                        {
                            nombre: "Inventario Anterior",
                            id: 2
                        }, */
        ],
        /* TABLA DE BUSQUEDA */
        search: '',
        pagination: {
            sortBy: 'name'
        },
        mbProductos: null,
        headers2: [{
                text: 'Id',
                align: 'left',
                value: 'idArticulo'
            },
            {
                text: 'Artículo',
                value: 'nombre'
            },
            {
                text: 'Stock-Sistema',
                value: 'nombre'
            }
        ],
        desserts: [],

        /*
        |------------------ 
        | Password
        |------------------- 
        */
        dlgConfirmar: false,

        dlgFraccion: false,
        fracNombreArticulo: ""

    }),

    created() {
        this.inicializar();

    },
    /*
|--------------------------------------------------------------------------
| Metodos
|--------------------------------------------------------------------------
    */
    methods: {
        inicializar() {
            this.selected = [];
            let uri = this.ip + `ingredientes_getItems/${
                this.$route.params.id
            }`;
            this.axios.get(uri).then(response => {
                this.println(response.data);
                this.desserts = response.data[1];
                this.subProductosItems = response.data[0];
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            }); 
        },

        /* 
        |--------------------------------------------------------------------------
        | CLICK
        |--------------------------------------------------------------------------
        */

        deleteItem(item) {

            var index = this.subProductosItems.indexOf(item);
            if (index > -1) {
                this.subProductosItems.splice(index, 1);
                this.desserts.splice(0, 0, item);
                 item.entero = "";
            }
        },

        clckAceptarInventario() {
            this.dlgConfirmar = true;
        },

        clckDlgAceptar() { 
            
            this.println(this.subProductosItems); 
            var enviar = {
                'items': this.subProductosItems,
                'idArticulo': this.$route.params.id
            };

            let uri = this.ip + "ingredientes_insertItems";

            this.axios.post(uri, enviar).then(response => {
                this.mensajeInfo("Realizando operación :)");
                this.subProductosItems = [];
                this.selected = [];

                setTimeout(() => {
                    this.$router.push({
                        name: "articulo" 
                    });
                }, 1500);

            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            }); 



            this.dlgConfirmar = false;
        },

        clckCancelar() {
            this.$router.push({
                name: "articulo" 
            }); 
        },

        esDecimalEntero(e) {
            var retorno = false;
            if (e.entero == parseInt(e.entero, 10)) { //es numero

                return true;
            } else if (e.entero == parseFloat(e.entero, 10)) {

                return true;
            } else if (e.entero == "") {
                e.entero = 0;
                return true;
            } else {
                return false;
            }
        },
        clckDlgAceptarFraccion() {

            var e = this.fracNombreArticulo;

            if (e.denominador == "0") {
                e.denominador = 1;
                this.mensajeAdvertencia("No puede dejar el denominador con valor cero");
            } else if (!this.esDecimalEntero(e)) {
                this.mensajeAdvertencia("Debe de ingresar un valor valido");
            } else {
                if (e.entero == "")
                    e.entero = 0;
                if (e.denominador == "")
                    e.denominador = 1;
                if (e.numerador == "")
                    e.numerador = 0;
                
                math.config({
                    number: 'Fraction'
                })
            
                // use the expression parser
                var ele = math.eval(e.entero+"+"+e.numerador+"/"+e.denominador)   // Fraction, 2/5
          
                this.fracNombreArticulo.numerador = ele.n; 
                this.fracNombreArticulo.denominador = ele.d;
                
                
                this.subProductosItems.splice(0, 0, e);
                //Quitar el ingrediente del vectori inicial
                var index = this.desserts.indexOf(e);
                if (index > -1) {
                    this.desserts.splice(index, 1);
                }

                this.dlgFraccion = false;

            }
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
                retorno = String(i)+" " ;
            }  
            if (n!=0) {
                retorno+=String(n)+"/"+String(d);
            }  
 
            return retorno;
        },   
        


        /* 
        |--------------------------------------------------------------------------
        | METODOS DE LA TABLA
        |--------------------------------------------------------------------------
        */
        cbCambioProducto(e) {
            if (e != null) {
                if (e.idArticulo != null) {
                    this.fracNombreArticulo = e;
                    this.dlgFraccion = true;
                    setTimeout(() => {
                        this.$nextTick(this.$refs.txtFraccion.focus);
                    }, 500);
                }
            }

        },
        /* 
        |--------------------------------------------------------------------------
        | METODOS DE LA TABLA
        |--------------------------------------------------------------------------
        */
        toggleAll() {
            if (this.selected.length) this.selected = []
            else this.selected = this.desserts.slice()
        },
        changeSort(column) {
            if (this.pagination.sortBy === column) {
                this.pagination.descending = !this.pagination.descending
            } else {
                this.pagination.sortBy = column
                this.pagination.descending = false
            }
        },


        /* 
        |--------------------------------------------------------------------------
        | MENSAJES
        |--------------------------------------------------------------------------
        */
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
        println(data) {
            this.$log.info(data);
        },


    }
};