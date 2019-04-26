export default {
  props: ['ip'],
  data: () => ({
    /* SnackBar */
    snackColor: "teal darken-4",
    snackStatus: false,
    sanckText: " ",


    cards: [],
    ordenes: [],
    /*
    |------------------ 
    | Desactivar
    |------------------- 
    */
    desacBtnActualizar: true,

    /*
    |------------------ 
    | Cuarentena
    |------------------- 
    */

    cuarentena: {
      model: false,
      txtObservacion: ""
    }

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
      let uri = this.ip + "Orden_itemsActualUser";
      this.axios.get(uri).then(response => {
        this.ordenes = response.data;
      });
    },
    /*
    |--------------------------------------------------------------------------
    | CLICK
    |--------------------------------------------------------------------------
    */
    clckVerMesas(item) {
      //this.$log.info(item);

      this.$router.push({
        name: "orden",
        params: {
          id: item.idOrden
        }
      });

    },


    clckActualizar() {
      this.desacBtnActualizar = false;
      setTimeout(() => {
        this.desacBtnActualizar = true;
      }, 1500);

      this.inicializar();
    },

    clckDividir(idOrden) {
      this.$router.push({
        name: "dividir",
        params: {
          id: idOrden
        }
      });
    },

    clckEliminar(item) {
      let uri = this.ip + `Orden_deleteOrden/${
                item
              }`;
      this.axios
        .get(uri)
        .then(response => {
          this.$router.push({
            name: "sirviendo"
          });
        })
        .catch(error => {
          this.mensajeError("No se puede eliminar");
          this.$log.info("No se pudo eliminar el item");
        });
    },
    clckCuarentena(e, total) {

      if (total == 0) {
        this.mensajeAdvertencia("Ordenes en cero se pueden eliminar");
        return;
      }
      this.cuarentena.model = true;
      this.cuarentena.idOrden = e;
      setTimeout(() => {
        this.$nextTick(this.$refs.fcTxtObservacion.focus);
      }, 500);

    },

    clckAceptarCuarentena() {
      
      //haciendo la peticion post

      let uri = this.ip + "cuarentena_insertItem";
      this.axios.post(uri, this.cuarentena).then(response => {
       // this.ordenes = response.data;
        this.mensajeInfo("Agregada a cuerentena");
        this.clckActualizar(); 
      }).catch(error => {
        this.mensajeError("Error al insertar, verifique si hay alguna caja abierta");
        this.$log.info(error);
        });
      
      this.cuarentena={}
      //this.println(this.cuarentena.txtObservacion);
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