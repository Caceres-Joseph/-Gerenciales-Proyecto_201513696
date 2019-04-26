export default {
  props: ['ip'],
  data: () => ({
    search: "",

    dialog: false,
    /* 
    items: [], */
    editedIndex: -1,
    editedItem: {
      eAction: "",
      nombre: "",
      descripcion: "",
      rutaPadre: "",
      imagen: ""
    },
    defaultItem: {
      eAction: "",
      nombre: "",
      descripcion: "",
      rutaPadre: "",
      imagen: ""
    },

    categorias: [],

    itemEliminar: null,

    /*
     *---------------------------- 
     *Dialog ver
     *----------------------------
     */

    verDialogModel: false,
    verNombre: "",
    verDescripcion: "",
    verCodigo: "",
    verStockMinimo: "",
    verPrecioCompra: "",
    verPrecioVenta: "",
    verUnidadDeMedida: "",
    verCategoria: "",
    verCategoriaPadre: "",
    verLugarServir: "",
    verImagen: "",
    verSizeImagen: "",

    verGroupModel: "Sub Productos",
    verGroupModelBoolean: false,
    verGroupItems: [{
      icono: "extension",
      texto: "Sub Productos",
      active: false,
      items: [{
          texto: "Breakfast & brunch"
        },
        {
          texto: "New American"
        },
        {
          texto: "Sushi"
        }
      ]
    }],
    verGroupSubProductos: [],
    /*
     *---------------------------- 
     *Para el Menu 
     *----------------------------
     */

    menuModel: false,

    checkDescripcion: false,
    checkCodigo: false,
    checkStockMinimo: false,
    checkCompra: false,
    checkVenta: false,
    checkCategoria: false,
    checkMedida: false,
    /*
     *---------------------------- 
     *Para la Tabla
     *----------------------------
     */
    tableItems: [],
    tableHeader: [],
    tableModel: [],
    tablaEncabezado: [{
      text: "id",
      value: "idArticulo"
      },
      {
        text: "Nombre",
        value: "nombre"
      },
      {
        text: "Descripcion",
        value: "descripcion"
      },
      {
        text: "Código",
        value: "codigo"
      },
      {
        text: "Stock Minimo",
        value: "stockMinimo"
      },
      {
        text: "P.Compra",
        value: "precioCompraDefecto"
      },
      {
        text: "P.Venta",
        value: "precioVentaDefecto"
      },
      {
        text: "Acciones",
        sortable: false
      }
    ]
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    }
  },

  watch: {
    dialog(val) {
      val || this.close();
    }
  },

  created() {
    this.inicializar();
  },

  methods: {
    inicializar() {
      let uri = this.ip + "Articulo_items";
      this.axios.get(uri).then(response => {
        this.tableItems = response.data;
      });
    },

    /*
    +------------------------------------------------+
    |   ACCIONES
    +------------------------------------------------+
    */
    viewItem(item) {
      //Para cerrar el group model
      this.verGroupModelBoolean = false;
      /* Obteniendo el id de  */
      let uri = this.ip + `categoria_getitem/${item.idCategoria}`;
      this.axios.get(uri).then(response => {
        this.verCategoriaPadre = response.data.rutaPadre;
        this.verCategoria = response.data.nombre;
      });

      let uri2 = this.ip + `Medida_item/${item.idMedida}`;
      this.axios.get(uri2).then(response => {
        this.verUnidadDeMedida = response.data.nombre;
      });

      let uri4 = this.ip + `LugarServir_item/${item.idLugarServir}`;
      this.axios.get(uri4).then(response => {
        this.verLugarServir = response.data.nombre;
      });


      //this.$log.info(item.idArticulo);
      let uri3 = this.ip + `ArticuloDetalle_getItemsHijos/${item.idArticulo}`;
      this.axios.get(uri3).then(response => {
        this.verGroupSubProductos = response.data;
        var temp = response.data;
        for (let index = 0; index < temp.length; index++) {
          var element = temp[index];
          let uri4 = this.ip + `Articulo_item/${
              element.idArticulo
            }`;
          this.axios.get(uri4).then(response => {
            this.verGroupSubProductos[index].nombreSubProducto =
              response.data.nombre;
          });
        }
      });

      if (item.imagen == "/storage/images/categorias/nada.png") {
        this.verSizeImagen = "0";
      } else {
        this.verSizeImagen = "300";
      }
      this.verNombre = item.nombre;
      this.verDescripcion = item.descripcion;
      this.verCodigo = item.codigo;
      this.verStockMinimo = item.stockMinimo;
      this.verPrecioCompra = item.precioCompraDefecto;
      this.verPrecioVenta = item.precioVentaDefecto;
      this.verImagen = item.imagen;
      this.verDialogModel = true;
    },
    cerrarVerDialog() {
      this.verDialogModel = false;
    },
    close() {
      this.dialog = false;
    },

    accVerHistorial(item) {
      this.$router.push({
        name: "historial_detalleProducto",
        params: { id: item.idArticulo, nombre:item.nombre}
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