import getDefaultData from "./nuevoD.js";

export default {
    props: ['ip'],
    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    */

    data: getDefaultData,

    computed: {},

    watch: {
        dialog(val) {
            val || this.close();
        }
    },

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
            //
            this.date = this.getToday();
            this.cargarArticuloCombo();
            this.focoTipoComprobante();

            window.scrollTo(0, 0);
        },
        insertar() {
            this.item.fechaComprobante = this.date;
 
            let uri = this.ip + "Bodega_insert";

            this.axios
                .post(uri, this.item)
                .then(response => {

                    let uri2 = this.ip + `DetalleIngreso_insertMultiple/${
                        response.data
                        }`; 
                    var envio = {
                        'arreglo': this.subProductosItems,
                        'bodega':this.modelChekBodega,
                        'cancelado':this.item.checkGasto
                    }
                    this.$log.info(envio);
                    this.axios.post(uri2,envio ).then(response => {

                        this.mensajeInfo("Insertado exitosamente");
                        /*this.item = {};
                        this.subProductosItems = [];
                        this.modelChekBodega = false;
                        this.modelChekProveedor = false;*/

                        Object.assign(this.$data, getDefaultData());
                        this.inicializar();

                         
                    }).catch(error => {
                        this.mensajeError("Error al insertar detalle");
                    });
 
                    //this.mensajeInfo("Item agregado exitosamente");

                })
                .catch(error => {
                    this.mensajeError("Error al insertar");
                });
            this.dlgConfirmar = false;
        },
        insertarSubProducto() {

            //antes validar que no haya sido agregado


            //validando si son nulos 
            if (this.itemSubProducto.cantidad == "") {
                this.itemSubProducto.cantidad = "0";
                this.itemSubProducto.total = "0";
            }
            if (this.itemSubProducto.cantidad == "0") {
                this.itemSubProducto.total = "0";
            }
            if (this.itemSubProducto.compra == "") {
                this.itemSubProducto.cantidad = "0";
                this.itemSubProducto.total = "0";
                this.itemSubProducto.compra = "0";
            }

            var temp = {
                idArticulo: this.itemSubProductoActual.idArticulo,
                cantidad: this.itemSubProducto.cantidad,
                nombre: this.itemSubProductoActual.nombre,
                compra: this.itemSubProducto.compra,
                total: this.itemSubProducto.total,
                vencimiento: this.date2,
            };



            this.subProductosItems.push(temp);
            this.dialogNuevoProducto = false;
            this.focoProductos();

            //haciendo la operacion 
            var total = 0;
            for (let index = 0; index < this.subProductosItems.length; index++) {
                const element = this.subProductosItems[index];
                total = total + this.formatDecimalMascara(element.total);
            }
            this.item.totalCompleto = parseFloat(total.toFixed(2));

        },

        formatDecimalMascara(entrada) {
            var entrada2 = String(entrada);
            var array = entrada2.split('.');
            var join1 = array.join('');
            var array2 = join1.split(',');
            var retorno = array2[0] + "." + array2[1];
            var retorno1 = parseFloat(retorno);
            return retorno1;
        },

        /*
        +------------------------------------------------+
        |   CLICK
        +------------------------------------------------+
        */
        clckDlgAceptar() {
            

            this.dlgConfirmar = true;
        },

        
        /*
        +------------------------------------------------+
        |   Productos repetidos
        +------------------------------------------------+
        */
        estaRepetidoElSubProducto(idProducto) {
            var retorno = false;

            this.subProductosItems.forEach(element => {
                if (element.idArticulo==idProducto) {
                    retorno = true;
                }
            });

            return retorno;
       } ,
       
        
        /*
        +------------------------------------------------+
        |   Cargando los combos
        +------------------------------------------------+
        */

        cargarArticuloCombo() {
            let uri = this.ip + "Articulo_items";
            this.axios.get(uri).then(response => {
                this.articulosCombo = response.data;
            });
        },
        cargarProveedores() {
            let uri = this.ip + "Persona_proveedores";
            this.axios.get(uri).then(response => {
                //this.println(response.data);
                this.proveedores = response.data;
            });
        },

        /*
        +------------------------------------------------+
        |   Check
        +------------------------------------------------+
        */

        checkBoxProveedor(e) {
            if (!e) {
                //si es falso
                this.cbModelProveedor = null;
                this.item.idPersona = null;
            } else {
                this.cargarProveedores();
            }
        },
        checkBoxVencimiento(e) {
            if (!e) {
                //si es falso
                this.date2 = null;
                this.menu2 = false;
            }
        },
        /*
        +------------------------------------------------+
        |   Check
        +------------------------------------------------+
        */
        addSubproducto() {
            var productoHijo = {
                modelCantidad: null,
                modelArticuloHijo: null,
                idArticulo: 0
            };
            this.subProductos.push(productoHijo);

            this.numTabsProductoHijo++;
            if (this.numTabsProductoHijo == 0) {
                this.cargarArticuloCombo();
            }
            //
            this.modelTabs = this.numTabsProductoHijo.toString();
        },

        /*
        +------------------------------------------------+
        |   Cambios del combo
        +------------------------------------------------+
        */

        cbCambioProveedor(e) {

            if(e==null)
                return;

            if (e.idPersona == parseInt(e.idPersona, 10)) { //es numero
                this.item.idPersona = e.idPersona;
            }
        },
        cbCambioProducto(e) {
            if(e==null)
                return;

            if (e.idArticulo == parseInt(e.idArticulo, 10)) {

                 if (this.estaRepetidoElSubProducto(e.idArticulo)) {
                    this.mensajeAdvertencia("El producto ya esta ingresado, eliminelo para poder agregar otro con diferentes datos");
                    return;
                }
                this.focoEmergente();
                this.itemSubProductoActual = e;
                this.cbModelProductos = null;
                this.dialogNuevoProducto = true;
                this.itemSubProducto.compra = e.precioCompraDefecto;
                this.itemSubProducto.cantidad = "";
                this.itemSubProducto.total = "";
                this.date2 = null;
                this.modelChekVencimiento = false;
            }
            //mostradndo el dialog shoy

        },

        /*
        +------------------------------------------------+
        |   Limpiando campos
        +------------------------------------------------+
        */
        limpiarCampos() {
            this.item.nombre = null;
            this.item.descripcion = null;
            this.item.codigo = null;


            this.modelChekMedida = false;
            this.MedidaModel = null;
            this.idMedidaPadre = null

            this.modelChekSubProducto = false;
            this.subProductosModel = [];
            this.subProductoTemp = [];


        },
        cancelar() {
            Object.assign(this.$data, getDefaultData());
            this.inicializar();

        },
        getLatestItem() {
            let uri = this.ip + "Articulo_latest";
            this.axios.get(uri).then(response => {
                this.getSearchItem = response.data;
                //this.$log.info(this.getSearchItem.idMedida);
            });
        },
        /*
        +------------------------------------------------+
        |   Eliminando subProductos
        +------------------------------------------------+
        */

        deleteItem(item) {
            var index = this.subProductosItems.indexOf(item);
            //this.$log.info(index);
            if (index > -1) {
                this.subProductosItems.splice(index, 1);
            }
            var total = 0;
            for (let index = 0; index < this.subProductosItems.length; index++) {
                const element = this.subProductosItems[index];
                total = total + this.formatDecimalMascara(element.total);
            }
            this.item.totalCompleto = parseFloat(total.toFixed(2));
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
        | CHIP
        |--------------------------------------------------------------------------
        */
        clickChip(e) {
            this.$log.info(e);
        },
        /* 
        |--------------------------------------------------------------------------
        | Refrescando subproductos
        |--------------------------------------------------------------------------
        */
        refrescarSubProductos() {
            this.cargarArticuloCombo();
        },
        getToday() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }

            if (mm < 10) {
                mm = '0' + mm
            }

            today = yyyy + '-' + mm + '-' + dd;
            return today;
        },
        /* 
        |--------------------------------------------------------------------------
        | KEYUP
        |--------------------------------------------------------------------------
        */
        keyUpSubProductoCantidad(item) {
            //el modelo es item 
            //itemSubProducto.cantidad
            var regexp = /^\d+\.?\d{0,3}$/; //expersion regular para decimales
            if (regexp.test(this.itemSubProducto.cantidad)) {

            } else {
                if (item.keyCode > 32) { //hay que borar 
                    //this.itemSubProducto.cantidad = this.eliminarUltimaLetra(this.itemSubProducto.cantidad);
                    this.itemSubProducto.cantidad = this.itemSubProducto.cantidad.slice(0, -1);
                }
            }
            //ahora hay que hacer los calculos




            var tempTotal = parseFloat(this.itemSubProducto.cantidad) * this.formatDecimalMascara(this.itemSubProducto.compra);
            var str = String(tempTotal);
            //validando si no tiene el punto 
            var regexp3 = /^\d+\.\d+$/; //mas de un decimal 

            if (regexp3.test(str)) {
                var redondeado = parseFloat(tempTotal.toFixed(2));
                redondeado = String(redondeado);

                var splitRedondeado = redondeado.split('.');
                if (splitRedondeado[1].length < 2) { //le concateno un cero
                    redondeado = redondeado + "0";
                }
                this.itemSubProducto.total = redondeado;

            } else {
                str = str + "00";
                this.itemSubProducto.total = str;
            }

        },
        keyUpSubProductoCompra() {

            var tempTotal = parseFloat(this.itemSubProducto.cantidad) * this.formatDecimalMascara(this.itemSubProducto.compra);
            var str = String(tempTotal);
            //validando si no tiene el punto 
            var regexp3 = /^\d+\.\d+$/; //mas de un decimal 

            if (regexp3.test(str)) {
                var redondeado = parseFloat(tempTotal.toFixed(2));
                redondeado = String(redondeado);

                var splitRedondeado = redondeado.split('.');
                if (splitRedondeado[1].length < 2) { //le concateno un cero
                    redondeado = redondeado + "0";
                }
                this.itemSubProducto.total = redondeado;

            } else {
                str = str + "00";
                this.itemSubProducto.total = str;
            }
        },
        /* 
        |--------------------------------------------------------------------------
        | Mascara de las teclas
        |--------------------------------------------------------------------------
        */
        isLetter(c) {
            return c.toLowerCase() != c.toUpperCase();
        },
        eliminarUltimaLetra(string) {
            var el = string.split(''); //convirtiendo a array
            var retorno = "";
            for (let index = 0; index < string.length - 1; index++) {
                const element = el[index];
                retorno = retorno + element;
            }
            return retorno;
        },


        /*
        |--------------------------------------------------------------------------
        | Mascara de las teclas
        |--------------------------------------------------------------------------
        */


        focoEmergente() {

            setTimeout(() => {
                this.$nextTick(this.$refs.txtCantidad.focus);
            }, 500);

        },
        focoTipoComprobante() {

            setTimeout(() => {
                this.$nextTick(this.$refs.txtTipoComprobante.focus);
            }, 500);

        },

        focoProveedor() {


            this.$nextTick(() => this.$refs.checkProveedor.$el.focus());
            this.$refs.checkProveedor.tabFocused=true;

        },

        focoProductos(){


            /*this.cbModelProductos=null;
            //this.$nextTick(()=>this.$refs.focoProductos.focus());

            this.$nextTick(() => {
                const input = this.$refs.focoProductos.$el.querySelector('input')
                input.focus()
            })*/


            this.$nextTick(() => {
                this.$refs.focoProductos.clearableCallback();
            });



        },

        focoFinalizar(){
            this.$log.info("Activado foco");
            this.$nextTick(() => this.$refs.focoFinalizar.$el.focus())
        },



    }
};