export default {
  props: ['ip'],
  data: () => ({
    /*
    |------------------ 
    | SNACKBAR
    |------------------- 
    */
    snackColor: "teal darken-4",
    snackStatus: false,
    sanckText: " ",
    /*
    |------------------ 
    | HEADER
    |------------------- 
    */

    headerTabla: [{
        text: "Producto",
        value: "nombre"
      },
      {
        text: "Acciones",
        sortable: false
      }
    ],

    headerTabla2: [{
        text: "Acciones",
        sortable: false
      },
      {
        text: "Producto",
        value: "nombre"
      }

    ],

    /*
    |------------------ 
    | TABLA1
    |------------------- 
    */

    dataTable1: [],
    dataTable2: [],
    dataOrdenesExistentes: [],

    /*
    |------------------ 
    | Desactivar
    |------------------- 
    */
    desacCheck: true,
    /*
    |------------------ 
    | ORDEN EXISTENTE
    |------------------- 
    */
    checkOrden: false,

    /*
    |------------------ 
    | ID ORDEN PADRE
    |------------------- 
    */
    idOrdenPadre: null,

    actualMesa: "",
    actualNivel: "",

    actualMesa2: "",
    actualNivel2: "",



  }),
  created() {
    this.inicializar();
  },
  methods: {
    /*
    |--------------------------------------------------------------------------
    | INICIALIZAR
    |--------------------------------------------------------------------------
    */
    inicializar() {

      this.individuales();
      this.cargarInfoOrden();
    },

    individuales() {
      let uri = this.ip + `DetalleOrdenIndividual_getOrden/${this.$route.params.id}`;
      this.axios
        .get(uri)
        .then(response => {
          //this.println(response.data);
          this.dataTable1 = response.data;
        })
        .catch(error => {
          this.mensajeError("Error al cargar la orden");
          this.println(error);
        });

    },
    cargarInfoOrden() {
      let uri = this.ip + `Orden_itemId/${this.$route.params.id}`;
      this.axios
        .get(uri)
        .then(response => {
          //this.actualNombreMesero = response.data.nombre;
          this.actualMesa = response.data.nombreMesa;
          this.actualNivel = response.data.nombreLugar;
        })
        .catch(error => {
          this.println(error);
        });
    },

    /*
    |--------------------------------------------------------------------------
    | CLICK
    |--------------------------------------------------------------------------
    */

    clckAceptar() {
      //enviando los dos arreglos 
      var env = {
        'idOrden1': this.$route.params.id,
        'tabla1': this.dataTable1,
        'idOrden2': this.idOrdenPadre,
        'tabla2': this.dataTable2
      }

      let uri = this.ip + "DetalleOrdenIndividual_dividirOrden";
      this.axios
        .post(uri, env)
        .then(response => {
          this.println(response.data);
          this.$router.push({
            name: "sirviendo"
          });
          //aqui redirecciono
          //this.dataTable1 = response.data;
        })
        .catch(error => {
          this.mensajeError("Error al realizar la operación");
          this.println(error);
        });
    },
    clckCancelar() {
      this.$router.push({
        name: "sirviendo"
      });
    },
    clckMovDerecha(item) {
      this.desacCheck = false;
      this.checkOrden = false;
      var index = this.dataTable1.indexOf(item);
      if (index > -1) {
        this.dataTable2.splice(0, 0, item);
        this.dataTable1.splice(index, 1);

      }
    },
    clckMovIzquierda(item) {
      this.checkOrden = false;
      this.desacCheck = false;
      var index = this.dataTable2.indexOf(item);
      if (index > -1) {
        this.dataTable1.splice(0, 0, item);
        this.dataTable2.splice(index, 1);
      }
    },
    /*
    +------------------------------------------------+
    |   COMBO
    +------------------------------------------------+
    */
    cbCambioOrden(e) {
      if (e != null) {
        this.idOrdenPadre = e;
        let uri = this.ip + `DetalleOrdenIndividual_getOrden/${e}`;
        this.axios
          .get(uri)
          .then(response => {


            this.dataTable2 = response.data;
            let uri = this.ip + `Orden_itemId/${e}`;
            this.axios
              .get(uri)
              .then(response => { 
                this.actualMesa2 = response.data.nombreMesa;
                this.actualNivel2 = response.data.nombreLugar;
              })
              .catch(error => {
                this.println(error);
              });

          })
          .catch(error => {
            this.mensajeError("Error al cargar");
            this.println(error);
          });
      }
    },
    /*
    +------------------------------------------------+
    |   CHECK BOX
    +------------------------------------------------+
    */
    checkBoxOrden(e) {
      if (e) {
        let uri = this.ip + `Orden_ordenesIdsSinCobrar/${this.$route.params.id}`;
        this.axios
          .get(uri) 
          .then(response => {
            //this.println(response.data);
            this.dataOrdenesExistentes = response.data;
          })
          .catch(error => {
            this.mensajeError("Error al cargar la orden");
            this.println(error);
          });
      } else { 
        this.dataOrdenesExistentes = [];
        this.dataTable2 = [];
        this.idOrdenPadre = null;
      }
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