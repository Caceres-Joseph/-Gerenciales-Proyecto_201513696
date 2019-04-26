import {
  indigo
} from "vuetify/es5/util/colors";

export default {
  props: ['ip'],
  data() {
    return {
      text: 'center',
      icon: 'justify',
      toggle_none: null,
      toggle_one: 0,
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
      }, ],
      /* MASTER */
      dialog: false,
      drawer: null,
      items2: [
        {
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
        }, {
          text: "Observacion",
          value: "observacion"
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
      /*
      |------------------ 
      | NUEVA OBSERVACIÓN
      |------------------- 
      */
      dlgCantidad: false,
      modelCantidad: null,
      actualItemObservacion: {},
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
      operacionActualItem: null,
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
      toggle_exclusive: 2,
      toggle_exclusiveImprimir:0,
      toggle_exclusiveAtras: 0,



      sinPropina: false,
      porcentajePropina: 0.10,
      /*
      |------------------ 
      | COBRAR
      |------------------- 
      */
      cobrarEfectivo: 0,
      cobrarTarjeta: 0,

      /*
      |------------------ 
      | Desactivar
      |------------------- 
      */
     desacBtnActualizar:true,
     desacBtnCobrar:true,
      desacBtnEnviar: true,

      /*
      |------------------ 
      | Password
      |------------------- 
      */
      dlgPassword:false,
      txtPassword: "",
      itemPassword: null,
      accionPassword:"",

     
    }
  },
  destroyed() {

    document.removeEventListener("keyup", this.atajos);
  },
  mounted() {
    document.addEventListener("keyup", this.atajos);
  },
  created() {
    this.inicializar();
    //this.println(this.$route.params.id);
  },

  methods: {
    atajos(e) {
      if (e.ctrlKey && e.code == "KeyC") {
        this.clckConstancia();
      }else if (e.ctrlKey && e.shiftKey && e.code == "KeyR") {
        this.clckQuitarPropina();
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
      this.selectTabDefault();
      //llenado los arreglos
    },
    selectTabDefault() {

      this.porcentajePropina = 0.10
      //this.openCity('London');
      // this.$refs.myBtn.click();
      /* const elem = this.$refs.myBtn
            elem.click() */
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
          this.arrayCuentaIndividual[index].observacionGrupal = this.modelObservacion;
          let uri = this.ip + `DetalleOrdenIndividual_updateObservacionGrupal/${element.idOrdenDetalleIndividual}`;
          this.axios
            .post(uri, this.modelObservacion)
            .then(response => {
              var index = this.arrayCuenta.indexOf(this.actualItemObservacion);
              if (index > -1) {
                this.arrayCuenta[index].observacion = this.modelObservacion;
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
        .post(uri, this.modelObservacion)
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
    | CLICK
    |--------------------------------------------------------------------------
    */
    clckCategoria(categoria) {
      //this.println(categoria);
      this.moverCarpeta(categoria.idCategoria, categoria.idCategoria);
    },
    clckArticulo(articulo) {
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
      this.$router.push({
        name: "login"
      });
    },
    clckTeclado(numero) {
      this.modelEntradaCalculadora = this.modelEntradaCalculadora + String(numero);

    },
    clckTecladoEnter() {
      //this.println(this.operacionActual);
      this.openCity('orden')
      this.toggle_exclusive = 0;
      //this.println(this.toggle_exclusive);
      this.println(this.operacionActual);
      if (this.operacionActual == "calcAddGrupo" && this.modelEntradaCalculadora != "") {
        //hay que ir a traer a la base de datos

        var articulo = {
          'precioVentaDefecto': this.operacionActualItem.precio_unitario,
          'nombre': this.operacionActualItem.producto,
          'idArticulo': this.operacionActualItem.idProducto
        };


        this.insertarVarios(articulo, this.modelEntradaCalculadora);


      } else if (this.operacionActual == "calcPrecioIndividual") {
        //this.enterPrecioIndividual(this.operacionActualItem.idOrdenDetalleIndividual);       
      } else if (this.operacionActual == "calcPrecioGrupal") {
        for (let index = 0; index < this.arrayCuentaIndividual.length; index++) {
          const element = this.arrayCuentaIndividual[index];
          if (element.idArticulo == this.operacionActualItem.idProducto) {
            //this.operacionActualItem = element;
            //this.println("entro");
            this.enterPrecioIndividual(element.idOrdenDetalleIndividual, element);
          }
        }
        this.println(this.operacionActualItem);
      } else if (this.operacionActual == "calcDecrementoGrupal") {

        var encontrados = 0;
        for (let index = 0; index < this.arrayCuentaIndividual.length; index++) {
          const element = this.arrayCuentaIndividual[index];
          if (element.idArticulo == this.operacionActualItem.idProducto) {
            encontrados++;
            if (encontrados <= parseInt(this.modelEntradaCalculadora)) {
              element.estado = 0;
              let uri = this.ip + `DetalleOrdenIndividual_editIndividual/${
                element.idOrdenDetalleIndividual
              }`;
              this.axios
                .post(uri, element)
                .then(response => {
                  this.arrayCuenta = [];

                })
                .catch(error => {
                  this.println(error);
                });
            }
            //this.enterPrecioIndividual(element.idOrdenDetalleIndividual, element);
          }
        }
      } else if (this.operacionActual == "cobrarTarjeta") {
        try {
          //this.totalOrdenMostrar = parseFloat(totalOrden.toFixed(2));
          this.cobrarTarjeta = parseFloat((this.modelEntradaCalculadora));
        } catch (error) {
          try {
            this.cobrarTarjeta = parseInt(this.modelEntradaCalculadora);
          } catch (error2) {
            this.cobrarTarjeta = 0.00;
          }
          
        }

      } else if (this.operacionActual == "cobrarEfectivo") {
        try {
          //this.totalOrdenMostrar = parseFloat(totalOrden.toFixed(2));
          this.cobrarEfectivo = parseFloat((this.modelEntradaCalculadora));
        } catch (error) {
          try {
            this.cobrarEfectivo = parseInt(this.modelEntradaCalculadora);
          } catch (error2) {
            this.cobrarEfectivo = 0.00;
          }
          
        }
      } else {
        this.println("no hay seleccion");
      }

      this.tabModel = String("0");
      this.operacionActual = {};
      this.modelEntradaCalculadora = "";

      this.arrayCuenta = [];
      this.cargarOrden();
    },
    clckTecladoBorrar() {
      if (!this.modelEntradaCalculadora.length < 1) { //no borro
        this.modelEntradaCalculadora = this.modelEntradaCalculadora.slice(0, -1);
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
    clckActualizar() {
      this.desacBtnActualizar = false;
      setTimeout(() => { 
        this.desacBtnActualizar = true;
      }, 1500); 

      this.arrayCuenta = [];
      this.cargarOrden();
    },
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
          this.arrayCuenta = [];
          this.cargarOrden();

          //imprim = response.data;

          /*   if (!imprim[2] == 0) {
              this.println("Imprimiendo Barra");
              var enviar = "&-&\n"
              enviar = enviar + String(imprim[0]);
              let uri2 = "http://192.168.0.101:1234/";
              this.axios.post(uri2, enviar);
            }


            if (!imprim[3] == 0) {
              this.println("Imprimiendo Cocina");
              setTimeout(() => {
                var enviar2 = "&-&\n"
                enviar2 = enviar2 + String(imprim[1]);
                let uri4 = "http://192.168.0.101:1234/";
                this.axios.post(uri4, enviar2);
              }, 800);
            } */
          //this.println(response.data);
          /* for (let index = 0; index < response.data.length; index++) {
            const element = response.data[index];
            this.println(element);
            var enviar = "&-&\n"
            enviar = enviar + String(element);
            setTimeout(() => {
              let uri2 = "http://192.168.0.101:1234/";
              this.axios.post(uri2, enviar);
          }, 500); */
        })
        .catch(error => {
          this.mensajeError("Error al modificar");
        });

      //tengo     que enviarlo a una ruta de enviar a la cocina y a la barra.

    },
    clckTarjeta() {

      this.abrirCalcu('cobrarTarjeta', this.cobrarTarjeta);
    },
    clckEfectivo() {
      this.abrirCalcu('cobrarEfectivo', this.cobrarEfectivo);
    },
    clckConstanciaPago() {
      //la orden tiene que tener su constancia pago
      //Imprimir_ConstanciaCobro
      let uri = this.ip + `Imprimir_ConstanciaCobro/${
       this.$route.params.id
        }`;
      
      //{{((this.cobrarEfectivo+this.cobrarTarjeta)-(this.totalOrdenMostrar*this.porcentajePropina+this.totalOrdenMostrar)).toFixed(2)}}
      var item = {
        'efectivo': this.cobrarEfectivo,
        'tarjeta': this.cobrarTarjeta,
        'cambio':  ((this.cobrarEfectivo+this.cobrarTarjeta)-(this.totalOrdenMostrar*this.porcentajePropina+this.totalOrdenMostrar)).toFixed(2)
      }
      this.axios
        .post(uri, item)
        .then(response => {
          this.$router.push({
            name: "ordenesMesa"
          }); 
        })
        .catch(error => { 
          this.println(error);
        });

    },
    clckConstancia(){
      this.$router.push({
        name: "constancia",
        params: { id: this.$route.params.id}
      }); 
    },

    clckPasswordAceptar() {
      if (!(this.txtPassword == "Mirador201617")) {
        
        this.mensajeError("Contraseña incorrecta"); 
      } else {
        if (this.accionPassword=="accDeleteGrupal") {
          this.accDeleteGrupal2();
        } else if (this.accionPassword=="accRemoveGrupal") {
          this.abrirCalcu('calcDecrementoGrupal', this.itemPassword);
        } else if (this.accionPassword=="accPrecioGrupal") {
          this.abrirCalcu('calcPrecioGrupal', this.itemPassword)
        } else if (this.accionPassword=="accDeleteIndividual2") {
          this.accDeleteIndividual(this.itemPassword);
        }
      }
      this.txtPassword = "";
      this.dlgPassword = false;
    }
    , 
    
    /*
    |--------------------------------------------------------------------------
    | LISTO DEL TECLADO
    |--------------------------------------------------------------------------
    */
    enterPrecioIndividual(idOrdenDetalleIndividual, item) {

      //'precioVentaDefecto': this.operacionActualItem.precio_unitario,
      //    'nombre': this.operacionActualItem.producto,
      //  'idArticulo': this.operacionActualItem.idProducto

      item.precio = this.modelEntradaCalculadora;

      //this.println(item);

      //DetalleOrdenIndividual_editIndividual
      let uri = this.ip + `DetalleOrdenIndividual_editIndividual/${
        idOrdenDetalleIndividual
      }`;
      this.axios
        .post(uri, item)
        .then(response => {

        })
        .catch(error => {
          this.mensajeError("no se modifico");
          this.println(error);
        });
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
        this.insertarArticulo2(articulo);
      }
    },

    insertarArticulo2(articulo) {
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

        })
        .catch(error => {
          this.mensajeError("Error al insertar");
        });

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
      if (!loEncontro) {
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

      this.println(item);



      this.modelObservacion = item.observacion;
      this.dlgObservacion = true;
      this.actualItemObservacion = item;
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

      this.modelEntradaCalculadora = "";
      const active = parseInt(this.tabModel)
      this.tabModel = String("2");

 
    },
    accDeleteGrupal(item) {
      this.dlgPassword = true;
      this.itemPassword = item;
      this.accionPassword = "accDeleteGrupal";
      return;

    },
    /* 
     *INDIVIDUAL  
     */
  
    accDeleteIndividual() {
      var item = this.itemPassword;
      var itemTemp = item;
      item.estado = 0; 
      let uri = this.ip + `DetalleOrdenIndividual_editIndividual/${
        item.idOrdenDetalleIndividual
      }`;
      this.axios
        .post(uri, item)
        .then(response => {
          this.arrayCuenta = [];
          this.cargarOrden();
        })
        .catch(error => {
          this.println(error);
        });
    }, 
 
    accPrecioIndividual(item) {
      this.println(item);
    },
    accDescuentoIndividual(item) {
      this.println(item);
    },
    /*
    |--------------------------------------------------------------------------
    | CONTRASENIA
    |--------------------------------------------------------------------------
    */
    accDeleteGrupal2() {
      var item = this.itemPassword;
    for (let index = 0; index < this.arrayCuentaIndividual.length; index++) {
      const element = this.arrayCuentaIndividual[index];
      if (element.idArticulo == item.idProducto) {
        //this.operacionActualItem = element;
        //this.println("entro");
        //this.enterPrecioIndividual(element.idOrdenDetalleIndividual, element);
        element.estado = false;
        let uri = this.ip + `DetalleOrdenIndividual_editIndividual/${
          element.idOrdenDetalleIndividual
        }`;
        this.axios
          .post(uri, element)
          .then(response => {

          })
          .catch(error => {
            this.mensajeError("no se modifico");
            this.println(error);
          });
      }
    }
    this.arrayCuenta = [];
    this.cargarOrden();
    },
    accRemoveGrupal(item) {
      this.dlgPassword = true;
      this.itemPassword = item;
      this.accionPassword = "accRemoveGrupal";
      return;
     
    },
    accPrecioGrupal(item) {
      this.dlgPassword = true;
      this.itemPassword = item;
      this.accionPassword = "accPrecioGrupal";
      return;
    },

    accDeleteIndividual2(item) {
      this.dlgPassword = true;
      this.itemPassword = item;
      this.accionPassword = "accDeleteIndividual2";
      return;
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

          /* if (!imprim[1] == 0) {
            this.println("Imprimiendo Cuenta");
            var enviar = "&-&\n"
            enviar = enviar + String(imprim[0]);
            let uri2 = "http://192.168.0.101:1234/";
            this.axios.post(uri2, enviar);
          } */

        })
        .catch(error => {
          this.println(error);
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
        .post(uri3, enviar).then(response => {})
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
        .post(uri3, enviar).then(response => {})
        .catch(error => {
          this.$log.info("error al momento de escribir orden");
        });
    },
    /*
    |--------------------------------------------------------------------------
    | ACCTUALIZANNDO CUANOD  HAY CAMBIO DE CHECK
    |--------------------------------------------------------------------------
    */
    checkCambioItem(item) {
      //this.actualizarOrdenDetalle();
      //this.println(item);
      let uri = this.ip + `DetalleOrdenIndividual_editIndividual/${
        item.idOrdenDetalleIndividual
      }`;
      this.axios
        .post(uri, item)
        .then(response => {
          this.arrayCuenta = [];
          this.cargarOrden();
        })
        .catch(error => {
          this.println(error);
        });




    },
    getRandomColor() {
      var letters = '0123456789ABCDEF';
      var color = '#';
      for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
    },
    openCity(evt, cityName) {
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
    },
    openCity(cityName) {
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
    },

    abrirCalcu(actual, item) {
      //calcPrecioIndividual
      this.operacionActual = actual;

      this.operacionActualItem = item;
      if (actual == "calcPrecioIndividual") {
        this.modelEntradaCalculadora = item.precio;
      } else if (actual == "calcPrecioGrupal") {
        this.modelEntradaCalculadora = item.precio_unitario
      } else if (actual == "calcDecrementoGrupal") {
        this.modelEntradaCalculadora = "";
      } else if (actual == "calcAddGrupo") {
        this.modelEntradaCalculadora = "";
      } else {
        this.modelEntradaCalculadora = "";
      }


      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }

      document.getElementById('calc').style.display = "block";
    }
  }
}