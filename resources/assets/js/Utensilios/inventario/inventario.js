
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
        subProductosItems: [],
        headers: [{
            text: "Id",
            value: "idArticulo"
        },
            {
                text: "Articulo",
                value: "nombre"
            },
            {
                text: "Stock-Sistema",
                value: "stock",
                align: "center"
            },
            {
                text: "Stock-Fisico",
                value: "Stock",
                align: "center"
            },
            {
                text: "Acciones",
                sortable: false,
                align: "center"
            }
        ],

        /* RADIO */
        radioGroup: 1,
        radioButtons2: [/* {
                nombre: "Movimiento en la semana",
                id: 0
            }, */
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
        selected: [],
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

        /*
        |------------------ 
        | Combo Productos
        |------------------- 
        */
        cbModelProductos: null,

        /*
        |------------------ 
        | Dialogo Fraccion
        |------------------- 
        */

        dlgFraccion: false,
        dlgFracDatos: {
            'nombre': '',
            'idArticulo': 0
        },
        dlgFracItems: {
            'numerador': "",
            'denominador': "",
            'entero': ""
        },
        dlgFracPointer: null,

        /*
        |------------------ 
        | get idInventario
        |------------------- 
        */
        txtIdInventario: null
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
            this.clckAceptar();

        },

        /* 
        |--------------------------------------------------------------------------
        | CLICK
        |--------------------------------------------------------------------------
        */

        clckAceptar() {

            window.scrollTo(0, 0);
            this.selected = [];
            var enviar = {
                'opcion': this.radioGroup,
                'select': this.subProductosItems

            };

            let uri = "/uInventario_getItems";

            this.axios.get(uri).then(response => {
                //this.println(response.data);
                this.desserts = response.data;
                this.focoCombo();
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });

        },
        clckInsertar() {
            this.subProductosItems = this.selected.concat(this.subProductosItems);
            this.desserts = this.desserts.filter(el => {
                return this.selected.indexOf(el) < 0;
            });

            this.selected = [];
        },

        clckImprimir() {
            this.println(this.desserts);
        },

        clckImprimirPreTicket() {
            var enviar = {
                'items': this.subProductosItems
            };

            let uri = this.ip + "inventarioImprimir_preTicket";

            this.axios.post(uri, enviar).then(response => {

            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
        },

        deleteItem(item) {

            var index = this.subProductosItems.indexOf(item);
            if (index > -1) {
                this.desserts.push(item);
                this.subProductosItems.splice(index, 1);
            }
        },

        clckAceptarInventario() {
            this.dlgConfirmar = true;
        },

        clckDlgAceptar() {
            var enviar = {
                'items': this.subProductosItems
            };

            let uri = "/uInventario_insertItems";

            this.axios.post(uri, enviar).then(response => {
                this.mensajeInfo("Realizando operación :)");
                this.subProductosItems = [];
                this.selected = [];

                this.inicializar();
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });


            this.dlgConfirmar = false;
        },

        clckCancelar() {
            var enviar = {
                'items': this.subProductosItems
            };
            let uri = this.ip + "inventario_consultaPruebaConteo";

            this.axios.post(uri, enviar).then(response => {
                this.println(response.data);
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
        },

        clckInventarioAnterior() {
            var enviar = {
                'select': this.subProductosItems,
                'idInventario': this.txtIdInventario
            };

            let uri ="/uInventario_getItemsInvAnte";
            this.axios.post(uri, enviar).then(response => {

                this.selected = response.data;
                this.limpiarArrreglo(response.data);
                this.subProductosItems = this.selected.concat(this.subProductosItems);
                //hay que arreglar esto prro
                //this.inicializar();



                this.println(response.data);
            }).catch(error => {
                this.mensajeError("Pude que el inventario no exista-Error al realizar la consulta");
            });
        },

        limpiarArrreglo(items){

            for(var i in items){
                //this.println(i);
                //this.println(items[i].idArticulo);
                for(var j in this.desserts){
                    if(this.desserts[j].idArticulo==items[i].idArticulo){
                        //delete this.desserts[j];
                        this.desserts.splice(j,1);
                        break;
                    }
                    //this.println(j);
                }
            }

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
        improperFractionToMixedNumber(n, d) {

            if (n == "" || d == "") {
                return "";
            }
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


        clckDlgAceptarFraccion() {

            var e = this.dlgFracItems;

            if (e.denominator == "0") {
                e.denominator = 1;
                this.mensajeAdvertencia("No puede dejar el denominador con valor cero");
            } else if (!this.esDecimalEntero(e)) {
                this.mensajeAdvertencia("Debe de ingresar un valor valido");
            } else {
                if (e.entero == "")
                    e.entero = 0;
                if (e.denominator == "")
                    e.denominator = 1;
                if (e.numerator == "")
                    e.numerator = 0;


                var ele={
                    n:e.entero,
                    d:1
                }

                this.dlgFracItems.numerator = ele.n;
                this.dlgFracItems.denominator = ele.d;
                this.dlgFracItems.entero = "";

                this.dlgFraccion = false;

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
        editItem(item) {
            this.dlgFracDatos.idArticulo = item.idArticulo;
            this.dlgFracDatos.nombre = item.nombre;
            this.dlgFracItems = item.fraccionStockFisico;

            //this.dlgFracPointer = item;  
            this.dlgFraccion = true;

            this.focoDialogoCantidad();
        },

        /* 
        |--------------------------------------------------------------------------
        | COMBO BOX
        |--------------------------------------------------------------------------
        */

        cbCambioProducto(e) {
            if (e != null) {
                if (e.idArticulo != null) {

                    this.subProductosItems.push(e);

                    var index = this.desserts.indexOf(e);
                    //this.$log.info(index);
                    if (index > -1) {
                        this.desserts.splice(index, 1);
                        //this.println(this.cbModelProductos);

                        //this.cbModelProductos.searchValue = null;

                    }

                    this.focoCombo();

                }
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

        /*
        |--------------------------------------------------------------------------
        | MENSAJES
        |--------------------------------------------------------------------------
        */

        focoCombo() {

            this.$nextTick(() => {
                this.$refs.borrarProducto.clearableCallback();
            });
        },
        focoDialogoCantidad() {

            this.$nextTick(() => {
                this.$refs.txtFraccion.focus();
            });
        }

    }
};