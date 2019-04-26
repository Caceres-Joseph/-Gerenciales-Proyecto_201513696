import {
    indigo
} from "vuetify/es5/util/colors";

export default {
    props: ['ip'],
    data() {
        return {

            /* Grupo de botons */

            toggle_exclusive2: null,
            /*  */
            text: 'center',
            icon: 'justify',
            toggle_none: null,
            toggle_one: 0,
            toggle_exclusive: 2,
            toggle_multiple: [0, 1, 2],
            /* La tabla 1 */
            rowsPerPageItems: [8, 15],
            rowsPerPageItems3: [8, 15],
            rowsPerPageItems2: [4, 8, 12, 15],
            pagination: {
                rowsPerPage: 8
            },
            pagination3: {
                rowsPerPage3: 8
            },
            items: [{
                value: false,
                name: 'Frozen Yogurt',
                calories: 159,
                fat: 6.0,
                carbs: 24,
                protein: 4.0,
                sodium: 87,
                calcium: '14%',
                iron: '1%'
            },],
            /* MASTER */
            dialog: false,
            drawer: null,
            items2: [{
                heading: 'Lugares'
            },
                {
                    icon: 'assignment',
                    text: 'Lugar',
                    path: '/ordenes/lugar/'
                },
                {
                    icon: 'add_shopping_cart',
                    text: 'Orden',
                    path: '/ordenes/orden/'
                },
                {
                    divider: true
                },
                {
                    heading: 'Imprimir'
                },
                {
                    icon: 'add_shopping_cart',
                    text: 'Imprimir',
                    path: '/ordenes/orden/'
                },
                {
                    heading: 'Imprimir'
                },
                {
                    icon: 'add_shopping_cart',
                    text: 'Cocina',
                    path: '/ordenes/orden/'
                },
                {
                    icon: 'add_shopping_cart',
                    text: 'Barra',
                    path: '/ordenes/orden/'
                },
            ],
            /*
            |------------------
            | INICIALIZAR
            |-------------------
            */
            categorias: [],
            articulos: [],
            /*
            |------------------
            | MENSAJES
            |-------------------
            */
            snackColor: "teal darken-4",
            snackStatus: false,
            sanckText: " ",
            /*
            |------------------
            | SUBIR DE CARPETA
            |-------------------
            */
            categoriaActualIdPadre: null,
            /*
            |------------------
            | LA CUENTA
            |-------------------
            */
            arrayCuenta: [],
            headersCuenta: [{
                text: "Cant.",
                value: "cantidad"
            },
                {
                    text: "Producto",
                    value: "producto"
                },
                {
                    text: "P.Unit",
                    value: "precio_unitario"
                },
                {
                    text: "P.Total",
                    value: "precio_total"
                },
                {
                    text: "Acciones",
                    sortable: false
                }, {
                    text: "Observacion",
                    value: "observacion"
                }
            ],
            headersCuentaIndividual: [{
                text: "Producto",
                value: "nombre"
            },
                {
                    text: "P.Unit",
                    value: "precio"
                },
                {
                    text: "Desc.",
                    value: "descuento"
                },
                {
                    text: "Acciones",
                    sortable: false
                },
                {
                    text: "Observacion",
                    value: "observacion"
                }
            ],

            headersCuentaEliminar: [{
                text: "Producto",
                value: "nombre"
            },
                {
                    text: "Acciones",
                    sortable: false
                }
            ],

            totalOrdenMostrar: 0,
            /*
            |------------------
            | NUEVA OBSERVACIÓN
            |-------------------
            */
            dlgObservacion: false,
            modelObservacion: null,
            actualItemObservacion: {},
            /*
            |------------------
            | NUEVA OBSERVACIÓN
            |-------------------
            */
            dlgCantidad: false,
            modelCantidad: null,
            /*
            |------------------
            | IMPRIMIR
            |-------------------
            */
            contImprimir: 0,

            /*
            |------------------
            | CUENTA INDIVIDUAL
            |-------------------
            */
            arrayCuentaIndividual: [],
            /*
            |------------------
            | CALCULADORA
            |-------------------
            */
            modelEntradaCalculadora: "",
            tabModel: 0,

            operacionActual: {},
            /*
            |------------------
            | ORDEN ACTUAL
            |-------------------
            */

            actualNombreMesero: "",
            actualMesa: "",
            actualNivel: "",
            actualIdOrden: 0,
            /*
            |------------------
            | Sin propina
            |-------------------
            */
            sinPropina: false,
            porcentajePropina: 0.10,

            /*
            |------------------
            | Desactivar
            |-------------------
            */
            desacBtnActualizar: true,
            desacBtnCobrar: true,
            desacBtnEnviar: true,
            /*
            |------------------
            | OBservaciones
            |-------------------
            */
            chips: ['sin queso'],
            txtObservaciones: "",
            actualTab: "",
            /*
            |------------------
            | Eliminar articulos de las cuenta
            |-------------------
            */
            arrayCuentaEliminar: [],
            tabs: null,
            text2: 'Lorem n ullamco laboris nisi ut aliquip ex ea commodo consequat.'


        }
    },

    destroyed() {
        document.removeEventListener("keyup", this.atajos);
    },
    mounted() {
        this.openCity('orden');
        document.addEventListener("keyup", this.atajos);
    },

    created() {
        this.inicializar();
        //this.println(this.$route.params.id);
    },
    methods: {
        atajos(e) {
            if (e.ctrlKey && e.shiftKey && e.code == "KeyL") {
                if (this.desacBtnEnviar) {
                    this.clckEnviar();
                }
            } else if (e.ctrlKey && e.shiftKey && e.code == "KeyK") {
                if (this.desacBtnCobrar) {
                    this.println("si se puede");
                    this.imprimir();
                }else{
                    this.println("no se puede");
                }
            } else if (e.ctrlKey && e.shiftKey && e.code == "KeyU") {
                this.clckSubirDeCarpeta();
            }
        },
        /*
        |===========================================================================
        | MASTER
        |
        */

        salir() {
            //haciendo logout
            let uri = this.ip + "session_remove/";


            this.axios
                .get(uri)
                .catch(error => {
                    this.$log.info("Error al cerrar session");
                });

            var href = this.ip + "login" //find url
            window.location = href;

        },
        inicio() {
            //lendo a home
            var href = this.ip + "bienvenido" //find url
            window.location = href;
        },
        /*
        |
        | MASTER
        |===========================================================================
        */
        inicializar() {
            this.moverCarpeta(-1, 1);
            this.cargarInfoOrden();
            this.cargarOrden();
            this.cargarObservaciones();
            //llenado los arreglos
        },
        cargarObservaciones() {
            let uri = this.ip + "Observacion_items";
            this.axios.get(uri).then(response => {

                this.chips = response.data;
            }); /* */
        },
        cargarInfoOrden() {
            let uri = this.ip + `Orden_itemId/${this.$route.params.id}`;
            this.axios
                .get(uri)
                .then(response => {
                    this.actualNombreMesero = response.data.nombre;
                    this.actualMesa = response.data.nombreMesa;
                    this.actualNivel = response.data.nombreLugar;
                    this.actualIdOrden = response.data.idOrden;
                    if (response.data.subTotal == response.data.total) {
                        if (response.data.total != 0) {
                            this.porcentajePropina = 0.0;
                        }

                    }
                })
                .catch(error => {
                    this.println(error);
                });
        },
        cargarOrden() {


            let uri = this.ip + `DetalleOrdenIndividual_getOrden/${this.$route.params.id}`;
            this.axios
                .get(uri)
                .then(response => {
                    //this.println(response.data);
                    this.arrayCuentaIndividual = response.data;
                    /* LLenando los grupos */
                    for (let index = this.arrayCuentaIndividual.length - 1; index > -1; index--) {
                        var elemento = this.arrayCuentaIndividual[index];

                        var itemCuenta = {
                            cantidad: 1,
                            producto: elemento.nombre,
                            precio_unitario: elemento.precio,
                            precio_total: 0,
                            idProducto: elemento.idArticulo,
                            observacion: elemento.observacionGrupal,

                        };

                        this.verificarSiEstaRepetido(itemCuenta);

                    }

                    //this.arrayCuenta.push(itemCuenta);
                    this.totalOrden();


                })
                .catch(error => {
                    this.mensajeError("Error al cargar la orden");
                    this.println(error);
                });

        },

        /*
        |--------------------------------------------------------------------------
        | SUB-BOTONES
        |--------------------------------------------------------------------------
        */

        subOrdenAdd() {

        },
        subOrdenObservacion() {
            //DetalleOrdenIndividual_updateObservacionGrupal
            //hay que buscar los items con ese id
            for (let index = 0; index < this.arrayCuentaIndividual.length; index++) {
                const element = this.arrayCuentaIndividual[index];
                if (this.actualItemObservacion.idProducto == element.idArticulo) {
                    this.arrayCuentaIndividual[index].observacionGrupal = this.txtObservaciones;
                    let uri = this.ip + `DetalleOrdenIndividual_updateObservacionGrupal/${element.idOrdenDetalleIndividual}`;
                    this.axios
                        .post(uri, this.txtObservaciones)
                        .then(response => {
                            var index = this.arrayCuenta.indexOf(this.actualItemObservacion);
                            if (index > -1) {
                                this.arrayCuenta[index].observacion = this.txtObservaciones;
                            }
                        })
                        .catch(error => {
                            this.mensajeError("Error al modificar");
                        });
                }
            }
        },

        subIndividualObservacion() {
            //hay que ir a la base de datos
            let uri = this.ip + `DetalleOrdenIndividual_updateObservacion/${this.actualItemObservacion.idOrdenDetalleIndividual}`;

            this.axios
                .post(uri, this.txtObservaciones)
                .then(response => {
                    var index = this.arrayCuentaIndividual.indexOf(this.actualItemObservacion);
                    if (index > -1) {
                        this.arrayCuentaIndividual[index].observacion = this.modelObservacion;
                    }
                })
                .catch(error => {
                    this.mensajeError("Error al modificar");
                });
        },

        /*
        |--------------------------------------------------------------------------
        | DISPONIBILIDAD
        |--------------------------------------------------------------------------
        */
        hayProductoEnExistencia(articulo) {
            var idArticulo = articulo.idArticulo;
            let uri = this.ip + `Articulo_hayExistenciaId/${idArticulo}`;
            this.axios
                .get(uri)
                .then(response => {
                    this.println(response.data);

                    if (response.data != "") {
                        this.mensajeAdvertencia("El artículo " + articulo.nombre + " se encuentra en stock mínimo \n Stock Actual : " + response.data);
                    }

                }).catch(error => {
                this.println("Error al Realizar HyaProductosEnExistencia :(");
            });


        },

        /*
        |--------------------------------------------------------------------------
        | CLICK
        |--------------------------------------------------------------------------
        */
        clckCategoria(categoria) {
            //this.println(categoria);
            this.moverCarpeta(categoria.idCategoria, categoria.idCategoria);
        },
        clckArticulo(articulo) {
            this.hayProductoEnExistencia(articulo);
            this.insertarArticulo(articulo);
            //this.println(articulo);
        },
        clckSubirDeCarpeta() {
            //this.println(this.categoriaActualIdPadre);
            if (this.categoriaActualIdPadre == null) { //estoy en la parte superior

            } else if (this.categoriaActualIdPadre == -1) {
                this.moverCarpeta(-1, 1);
            } else {
                this.moverCarpeta(this.categoriaActualIdPadre, this.categoriaActualIdPadre);
            }
        },
        clckNuevaObservacion() {
            if (this.actualItemObservacion.idOrdenDetalleIndividual != null) {
                this.subIndividualObservacion();
            } else if (this.actualItemObservacion.precio_total != null) {
                this.subOrdenObservacion();

            }
            /* else {
                    var index = this.arrayCuenta.indexOf(this.actualItemObservacion);
                    //this.$log.info(index);
                    if (index > -1) {
                      this.arrayCuenta[index].observacion = this.modelObservacion;
                    }
                  } */
            this.dlgObservacion = false;
            this.actualizarOrdenDetalle();
        },
        clckNuevaCantidad() {
            var index = this.arrayCuenta.indexOf(this.actualItemObservacion);
            //this.$log.info(index);
            if (index > -1) {
                var temp = this.arrayCuenta[index];
                temp.cantidad = this.modelCantidad;
                temp.precio_total = temp.cantidad * temp.precio_unitario;
                this.arrayCuenta[index] = temp;
                this.totalOrden();
            }
            this.dlgCantidad = false;
        },
        clckBlock() {

            let uri =  "/session_remove/";

            this.axios
                .get(uri)
                .catch(error => {
                    this.$log.info("Error al cerrar session");
                });
            this.$router.push({
                name: "login"
            });
        },
        clckTeclado(numero) {
            if (this.actualTab == "observaciones") {
                this.txtObservaciones = this.txtObservaciones + " (" + String(numero) + ") ";
            } else {
                this.modelEntradaCalculadora = this.modelEntradaCalculadora + String(numero);
            }


        },
        clckTecladoEnter() {
            //this.println(this.operacionActual);
            this.openCity('orden')
            this.toggle_exclusive = 0;
            //this.println(this.toggle_exclusive);
            if (this.operacionActual.precio_total != null && this.modelEntradaCalculadora != "") {
                //item al que hay que sumarle
                // this.$log.info(this.operacionActual);
                //hay que buscar el item articulo y sumarle

                //hay que ir a traer a la base de datos

                var articulo = {
                    'precioVentaDefecto': this.operacionActual.precio_unitario,
                    'nombre': this.operacionActual.producto,
                    'idArticulo': this.operacionActual.idProducto
                };
                this.insertarVarios(articulo, this.modelEntradaCalculadora);
            } else {
                this.println("no hay seleccion");
            }
            this.tabModel = String("0");
            this.operacionActual = {};
            this.modelEntradaCalculadora = "";
        },
        clckTecladoBorrar() {
            if (!this.modelEntradaCalculadora.length < 1) { //no borro
                this.modelEntradaCalculadora = this.modelEntradaCalculadora.slice(0, -1);
            }
        },
        clckTecladoBorrarTodo() {
            this.txtObservaciones = "";
        },
        clckTecladoBorrarObservacion() {
            if (!this.txtObservaciones.length < 1) { //no borro
                this.txtObservaciones = this.txtObservaciones.slice(0, -1);
            }
        },
        clckVerOrdenes() {
            this.$router.push({
                name: "sirviendo"
            });
        },
        clckQuitarPropina() {
            if (this.porcentajePropina == 0.0) {
                this.porcentajePropina = 0.10;
            } else {
                this.porcentajePropina = 0.0;
            }
            this.actualizarOrdenTotal();

        },
        /* Enviando las opciones a la cocina y a la barara */
        clckEnviar() {
            this.desacBtnEnviar = false;
            setTimeout(() => {
                this.desacBtnEnviar = true;
            }, 1500);


            //ImprimirCocinaBarra_orden/{id}
            let uri = this.ip + `Imprimir_CocinaBarraOrden/${this.$route.params.id}`;
            var imprim = [];
            this.axios
                .get(uri)
                .then(response => {
                    this.mensajeInfo("Enviado exitosamente");
                })
                .catch(error => {
                    this.mensajeError("Error al enviar");
                });

            //tengo     que enviarlo a una ruta de enviar a la cocina y a la barra.

        },
        clckActualizar() {
            this.desacBtnActualizar = false;
            setTimeout(() => {
                this.desacBtnActualizar = true;
            }, 1500);


            this.arrayCuenta = [];
            this.cargarOrden();
        },

        clckChip(item) {
            this.txtObservaciones = this.txtObservaciones + String(item) + ",";
            //this.println(item);
        },
        clckTecladoEnterObservacion() {
            if (this.actualItemObservacion.idOrdenDetalleIndividual != null) {
                this.subIndividualObservacion();
            } else if (this.actualItemObservacion.precio_total != null) {
                this.subOrdenObservacion();

            }
            //this.clckActualizar();
            this.openCity('orden')
        },

        /*
        |--------------------------------------------------------------------------
        | PRINT
        |--------------------------------------------------------------------------
        */
        println(mensaje) {
            this.$log.info(mensaje);
        },
        /*
        |--------------------------------------------------------------------------
        | MOVER CARPETA
        |--------------------------------------------------------------------------
        */
        moverCarpeta(idCategoria, idCategoriaArticulo) { //hay que actualizar el categoria actual
            //traer todas las carpetas con ruta 0
            let uri = this.ip + `categoria_getItemIdPadre/${
                idCategoria
                }`;
            this.axios.get(uri).then(response => {
                this.categorias = response.data;
                this.moverArticulo(idCategoriaArticulo);
                this.actualizarCategoriaPadre(idCategoria);
            });


        },
        moverArticulo(idCategoriaArticulo) {
            //Articulo_itemIdCategoria
            let uri2 = this.ip + `Articulo_itemIdCategoria/${
                idCategoriaArticulo
                }`;
            this.axios.get(uri2).then(response => {
                this.articulos = response.data;
            });
        },
        actualizarCategoriaPadre(idCategoria) {
            let uri = this.ip + `categoria_getIdCategoriaPadre/${
                idCategoria
                }`;
            this.axios.get(uri).then(response => {
                this.categoriaActualIdPadre = response.data.idCategoriaPadre;
            });
        },
        /*
        +--------------------------------------------------------------------------
        |   MENSAJES
        +--------------------------------------------------------------------------
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

        /*
        |--------------------------------------------------------------------------
        | CUENTA
        |--------------------------------------------------------------------------
        */
        insertarVarios(articulo, num) {
            for (let index = 0; index < num; index++) {
                this.insertarArticulo(articulo);
            }
        },
        insertarArticulo(articulo) {
            var itemInsertar = {};
            var precio = articulo.precioVentaDefecto;
            itemInsertar.idOrden = this.$route.params.id;
            itemInsertar.idArticulo = articulo.idArticulo;
            itemInsertar.nombre = articulo.nombre;
            itemInsertar.precio = parseFloat(precio);
            itemInsertar.descuento = 0;
            itemInsertar.observacion = "";
            itemInsertar.observacionGrupal = "";

            //verificando si hay mas grupales

            for (let index = 0; index < this.arrayCuentaIndividual.length; index++) {
                const element = this.arrayCuentaIndividual[index];
                if (articulo.idArticulo == element.idArticulo) {
                    itemInsertar.observacionGrupal = element.observacionGrupal;
                    break;
                }
            }


            itemInsertar.cortesia = false;
            itemInsertar.impreso = false;


            let uri = this.ip + "DetalleOrdenIndividual_insert";
            this.axios
                .post(uri, itemInsertar)
                .then(response => {
                    response.data.nombre = articulo.nombre;
                    this.arrayCuentaIndividual.splice(0, 0, response.data);
                    /* GENERAL */
                    var itemCuenta = {
                        cantidad: 1,
                        producto: articulo.nombre,
                        precio_unitario: articulo.precioVentaDefecto,
                        precio_total: 0,
                        idProducto: articulo.idArticulo,
                        observacion: itemInsertar.observacionGrupal,
                    };
                    this.verificarSiEstaRepetido(itemCuenta);
                    //this.arrayCuenta.push(itemCuenta);
                    this.totalOrden();
                    /*  */
                })
                .catch(error => {
                    this.mensajeError("Error al insertar");
                });

            return;
            // this.println(articulo);

        },
        totalOrden() {
            var totalOrden = 0;
            this.arrayCuenta.forEach(itemOrden => {
                totalOrden = totalOrden + itemOrden.precio_total;
            });
            //redondeando a dos decimales
            this.totalOrdenMostrar = parseFloat(totalOrden.toFixed(2));

            //hay que modificar los prudcots en la base de datos
            this.actualizarOrdenDetalle();
            //this.actualizarOrden();
            this.actualizarOrdenTotal();
        },
        verificarSiEstaRepetido(item) {

            var loEncontro = false;
            for (let index = 0; index < this.arrayCuenta.length; index++) {
                const itemOrden = this.arrayCuenta[index];
                if (item.idProducto == itemOrden.idProducto) { //se repitte
                    itemOrden.cantidad++;
                    itemOrden.precio_total = itemOrden.precio_unitario * itemOrden.cantidad;

                    this.arrayCuenta[index] = itemOrden;
                    loEncontro = true;
                    break;
                }
            }
            //
            if (!loEncontro) {
                //this.println(item);
                item.precio_total = item.precio_unitario * item.cantidad;
                //this.arrayCuenta.push(item);
                this.arrayCuenta.splice(0, 0, item);
            }
        },


        /*
        |--------------------------------------------------------------------------
        | CUENTA
        |--------------------------------------------------------------------------
        */

        accObservacion(item) {
            this.actualItemObservacion = item;

            this.println(item);
            if (this.actualItemObservacion.idOrdenDetalleIndividual != null) {

                if (item.observacion == null) {
                    item.observacion = "";
                }
                this.txtObservaciones = item.observacionGrupal + "," + item.observacion;
                //{{ props.item.observacionGrupal }},{{ props.item.observacion }}
            } else if (this.actualItemObservacion.precio_total != null) {
                this.txtObservaciones = item.observacion;

            }

            /* this.println(item); */
            this.openCity('observaciones', item.observacion);


            /*
                  this.modelObservacion = item.observacion;
                  this.dlgObservacion = true;
                   */


        },

        accDelete(item) {
            var index = this.arrayCuenta.indexOf(item);
            //this.$log.info(index);
            if (index > -1) {
                this.arrayCuenta.splice(index, 1);
                this.totalOrden();
            }
        },

        accDecrement(item) {
            var index = this.arrayCuenta.indexOf(item);
            this.arrayCuenta[index];
            var tempItem = this.arrayCuenta[index];
            tempItem.cantidad = tempItem.cantidad - 1;
            if (tempItem.cantidad == 0) { //lo voy a eliminar
                this.arrayCuenta.splice(index, 1);
                this.totalOrden();
            } else {
                tempItem.precio_total = tempItem.precio_unitario * tempItem.cantidad;
                this.arrayCuenta[index] = tempItem;
                this.totalOrden();
            }
        },
        accIncrement(item) {
            this.toggle_exclusive = 2;
            this.operacionActual = item;
            this.modelEntradaCalculadora = "";
            const active = parseInt(this.tabModel)
            this.tabModel = String("2");


            //this.println(this.tabModel=2);
            //this.tabModel = 2;
            /* this.modelCantidad = item.cantidad;
            this.dlgCantidad = true;
            this.actualItemObservacion = item; */
        },


        accEliminarProductoIndividual(item) {

            let uri3 = this.ip + `DetalleOrdenIndividual_delteItemDetalleIndividual/${item.idOrdenDetalleIndividual}`;
            this.axios
                .get(uri3).then(response => {
                this.cargarProductosAEliminar();
                this.clckActualizar();
                //moviendo a la pagina
                this.openCity('orden');

                this.mensajeInfo("Producto eliminado exitosamente");
            })
                .catch(error => {
                    this.mensajeError("No se pudo eliminar el producto seleccionado.");

                    this.$log.info(error);
                });


        },

        /*
        |--------------------------------------------------------------------------
        | IMPRIMIR
        |--------------------------------------------------------------------------
        */
        imprimir() {

            this.desacBtnCobrar = false;
            setTimeout(() => {
                this.desacBtnCobrar = true;
            }, 1500);


            //ImprimirCocinaBarra_orden/{id}
            let uri = this.ip + `Imprimir_Cuenta/${this.$route.params.id}`;
            var imprim = [];
            this.axios
                .get(uri)
                .then(response => {
                    imprim = response.data;
                    this.mensajeInfo("Imprimiendo");
                })
                .catch(error => {
                    this.mensajeError("Error al imprimir");
                });

        },
        enviarcadena(mensaje) {
            var cadenaEnviar = ". . . . .\n";
            cadenaEnviar = cadenaEnviar + "------------------\n";
            cadenaEnviar = cadenaEnviar + String(this.contImprimir) + "\n";
            cadenaEnviar = cadenaEnviar + String(mensaje) + "\n";
            cadenaEnviar = cadenaEnviar + "------------------\n";
            this.enviarJava(cadenaEnviar);
            this.contImprimir++;
        },
        enviarJava(mensaje) {


            /* var mensaje2 = {
              'imprimir':
               [
                  { 'interestKey': 'Dogs' },
                  { 'interestKey': 'Cats' },
             ]
            }; */

            /* var mensaje2 = {
              'hola':34
            } */
            //var obj = JSON.parse('{ "name":"John", "age":30, "city":"New York"}');


            let uri3 = this.ip + "Escribir_orden";
            this.axios
                .post(uri3, mensaje).then(response => {
                //this.println(response.data);
                var enviar = "&-&\n"
                enviar = enviar + String(response.data);
                try {
                    let uri = "http://192.168.0.101:1234/";
                    this.axios.post(uri, enviar);
                } catch (error) {
                    //this.println(error);
                }

            })
                .catch(error => {
                    this.$log.info("error al momento de escribir orden");
                });
        },
        /*
        |--------------------------------------------------------------------------
        | GUARDANDO LA ORDEN DETALLE
        |--------------------------------------------------------------------------
        */
        actualizarOrdenTotal() {

            var enviar = {
                'subTotal': this.totalOrdenMostrar,
                'propina': this.totalOrdenMostrar * this.porcentajePropina,
                'total': (this.totalOrdenMostrar) + (this.totalOrdenMostrar * this.porcentajePropina),
            }
            let uri3 = this.ip + `Orden_updateTotal/${this.$route.params.id}`;
            this.axios
                .post(uri3, enviar).then(response => {
            })
                .catch(error => {
                    this.$log.info("error al momento de escribir orden");
                });


        },

        actualizarOrdenDetalle() {
            //detalle_orden_insertMultiple
            return;
            let uri3 = this.ip + `detalle_orden_insertMultiple/${this.$route.params.id}`;

            this.axios
                .post(uri3, this.arrayCuenta).then(response => {

            })
                .catch(error => {
                    this.$log.info("error al momento de escribir detalle orden");
                });
        },
        actualizarOrden() {
            var enviar = {
                'subTotal': this.totalOrdenMostrar,
                'propina': this.totalOrdenMostrar * 0.1,
                'total': (this.totalOrdenMostrar) + (this.totalOrdenMostrar * 0.1),
            }
            let uri3 = this.ip + `Orden_update/${this.$route.params.id}`;
            this.axios
                .post(uri3, enviar).then(response => {
            })
                .catch(error => {
                    this.$log.info("error al momento de escribir orden");
                });
        },
        /*
        |--------------------------------------------------------------------------
        | ACCTUALIZANNDO CUANOD  HAY CAMBIO DE CHECK
        |--------------------------------------------------------------------------
        */
        checkCambioItem() {
            this.actualizarOrdenDetalle();
        },
        getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        },
        /*     openCity(evt, cityName) {
              var i, tabcontent, tablinks;
              tabcontent = document.getElementsByClassName("tabcontent");
              for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
              }
              tablinks = document.getElementsByClassName("tablinks");
              for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
              }
              document.getElementById(cityName).style.display = "block";
              evt.currentTarget.className += " active";
            }, */

        openCity(cityName, itemActual) {
            //clckNuevaCantidad
            this.actualTab = cityName;
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            /*  tablinks = document.getElementsByClassName("tablinks");
             for (i = 0; i < tablinks.length; i++) {
               tablinks[i].className = tablinks[i].className.replace(" active", "");
             } */
            document.getElementById(cityName).style.display = "block";
            //openCity( 'observaciones')
            /* if (cityName == "observaciones") {
              this.txtObservaciones = itemActual.observacion;
            } */


        },

        openCity(cityName) {

            this.actualTab = cityName;
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            /*  tablinks = document.getElementsByClassName("tablinks");
             for (i = 0; i < tablinks.length; i++) {
               tablinks[i].className = tablinks[i].className.replace(" active", "");
             } */
            document.getElementById(cityName).style.display = "block";
            //openCity( 'observaciones')
            if (cityName == "observaciones") {
                if (this.txtObservaciones == null) {
                    this.txtObservaciones = "";
                }
            } else if (cityName == "eliminarCuenta") {
                //hay que cargar la pantalla de eliminar
                this.cargarProductosAEliminar();

            }
        },
        /*
        |--------------------------------------------------------------------------
        | Eliminar productos no impresos, jejejeje
        |--------------------------------------------------------------------------
        */

        cargarProductosAEliminar() {

            let uri3 = this.ip + `DetalleOrdenIndividualEliminar_getOrden/${this.$route.params.id}`;
            this.axios
                .get(uri3).then(response => {
                this.arrayCuentaEliminar = response.data;
            })
                .catch(error => {
                    this.$log.info("error al momento de escribir orden");
                });

        }


    }
}