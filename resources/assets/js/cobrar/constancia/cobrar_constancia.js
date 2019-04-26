export default {
  props: ['ip'],



  data: () => ({
    /* SnackBar */
    snackColor: "teal darken-4",
    snackStatus: false,
    sanckText: " ",


    cobrarTotal: 0.0,
    cobrarCambio: 0.0,
    cobrarEfectivo: 0.0,
    cobrarTarjeta: 0.0,
    cobrarSubTotal: 0.0,
    cobrarPropina: 0.0,

    cambioColor: "orange darken-4",

    modelEntradaCalculadora: "",
    operacionActual: "",


    idOrden: 0,

    /*
    |------------------ 
    | Desactivar
    |------------------- 
    */
    desacBtnGracias: true,
    /*
    |------------------ 
    | Cortesia
    |------------------- 
    */
    cortesiaModelObservacion: "",
    dlgCortesia: false,
    indice: null


  }),
  destroyed() {

    document.removeEventListener('keyup', this.foo);
  },
  mounted() {
    document.addEventListener('keyup', this.foo);

  },
  created() {

    this.inicializar();
    //this.listener();
    /* window.addEventListener('keydown', function (e) {
      if (e.keyCode==69) {//e
        
      } else if (e.keyCode==84) {
        
      }
        
      this.$log.info(e.keyCode);
    }); */
  },

  methods: {
    focus() {
      setTimeout(() => {
        this.$nextTick(this.$refs.fcTxtCortesia.focus);
      }, 500);

    },
    foo(event) {
      if (this.dlgCortesia == false) {


        if (
          event.key == "1" ||
          event.key == "2" ||
          event.key == "3" ||
          event.key == "4" ||
          event.key == "5" ||
          event.key == "6" ||
          event.key == "7" ||
          event.key == "8" ||
          event.key == "9" ||
          event.key == "0" ||
          event.key == ".") {
          this.modelEntradaCalculadora = this.modelEntradaCalculadora + event.key;
        } else if (event.key == "Backspace") {
          this.clckTecladoBorrar();
        } else if (event.key == "Delete") {
          this.clckTecladoBorrarTodo();
        } else if (event.ctrlKey && event.code == "KeyT") {
          this.clckTarjeta();
        } else if (event.ctrlKey && event.code == "KeyE") {
          this.clckEfectivo();
        } else if (event.ctrlKey && event.code == "KeyS") {
          this.clckCortesia();
        }
        this.println(event);
      }
    },
    recibiendo(e) {
      this.$log.info(e);
      this.modelEntradaCalculadora = this.modelEntradaCalculadora + e.key;
    },
    listener() {
      window.addEventListener(
        "keydown",
        function (e) {
          this.prueba(e);
        }

        ,
        true
      );
    },
    prueba() {
      e => {
        this.recibiendo(e);
      }
    },
    listener2(evt) {

    },
    /*
    |--------------------------------------------------------------------------
    | INICIALIZAR
    |--------------------------------------------------------------------------
    */
    inicializar() {

      let uri = this.ip + `Orden_itemId/${this.$route.params.id}`;
      this.axios
        .get(uri)
        .then(response => {
          //this.$log.info(response);
          this.cobrarTotal = parseFloat(response.data.total);
          this.idOrden = this.$route.params.id;
          this.calculando();
        })
        .catch(error => {
          this.$log.info(error);
        });


    },
    /*
    |--------------------------------------------------------------------------
    | CLICK
    |--------------------------------------------------------------------------
    */

    cgDialogCortesia(e) {
      this.$log.info(e);
    },

    /*
    |--------------------------------------------------------------------------
    | CLICK
    |--------------------------------------------------------------------------
    */
    clckVerMesas(item, color) {
      //this.$log.info(item);
      this.$router.push({
        name: "mesas",
        params: {
          id: item,
          color: color
        }
      });
    },

    clckTeclado(item) {
      this.modelEntradaCalculadora = this.modelEntradaCalculadora + item;
    },
    clckTecladoBorrar() {
      if (!this.modelEntradaCalculadora.length < 1) { //no borro
        this.modelEntradaCalculadora = this.modelEntradaCalculadora.slice(0, -1);
      }
    },
    clckTecladoBorrarTodo() {
      this.modelEntradaCalculadora = "";
    },
    clckTecladoEnter() {
      this.$log.info(this.operacionActual);
      if (this.operacionActual == "efectivo") {
        //parseFloat(totalOrden.toFixed(2)); 

      } else if (this.operacionActual == "tarjeta") {

      }
      this.calculando();
    },
    clckEfectivo() {
      if (this.modelEntradaCalculadora == "") {
        this.cobrarEfectivo = 0.0;
        this.calculando();
        return;
      }
      try {
        this.cobrarEfectivo = parseFloat(this.modelEntradaCalculadora);
      } catch (error) {
        this.$log.info("error de parseo");
        this.cobrarEfectivo = 0.0;
      }
      this.calculando();
      this.modelEntradaCalculadora = "";

    },
    clckTarjeta() {
      if (this.modelEntradaCalculadora == "") {
        this.cobrarTarjeta = 0.0;
        this.calculando();
        return;
      }

      try {
        this.cobrarTarjeta = parseFloat(this.modelEntradaCalculadora);
      } catch (error) {
        this.$log.info("error de parseo");
        this.cobrarTarjeta = 0.0;
      }
      this.calculando();
      this.modelEntradaCalculadora = "";
    },

    llenarTarjeta() {
      if (this.cobrarCambio < 0) {
        this.cobrarTarjeta = this.cobrarCambio * (-1);
        this.calculando();
      }

    },

    clckPropina() {
      if (this.modelEntradaCalculadora == "") {
        this.cobrarPropina = 0.0;
        this.calculando();
        return;
      }
      try {
        this.cobrarPropina = parseFloat(this.modelEntradaCalculadora);
      } catch (error) {
        this.$log.info("error de parseo");
        this.cobrarPropina = 0.0;
      }
      this.calculando();
      this.modelEntradaCalculadora = "";
    },
    clckGracias() {

      if (this.cobrarTotal == 0.00) {
        this.mensajeAdvertencia("No se pueden cobrar cuentas en cero");
        return;
      }
      let uri = this.ip + `Imprimir_ConstanciaCobro/${
       this.$route.params.id
        }`;

      var item = {
        'efectivo': this.cobrarEfectivo,
        'tarjeta': this.cobrarTarjeta,
        'cambio': this.cobrarCambio,
        'propina': this.cobrarPropina,
        'subTotal': this.cobrarSubTotal,
        'total': this.cobrarTotal + this.cobrarPropina
      }

      this.axios
        .post(uri, item)
        .then(response => {
          if (response.data == 0) {
            this.mensajeError("No hay caja abierta");
          } else if (response.data == 1) {
            this.$router.push({
              name: "sirviendo"
            });
          } else {
            this.mensajeError("No se pudo efectuar el cobro");
          }

        })
        .catch(error => {
          this.mensajeError("No se puede efectuar el cobro, revise si hay caja abierta");
          this.println(error);
        });
    },

    clckCortesia() {

      if (this.cobrarTotal == 0.00) {
        this.mensajeAdvertencia("No se pueden cobrar cuentas en cero");
        return;
      }

      this.focus();
      this.cortesiaModelObservacion = "";
      this.dlgCortesia = true;

    },

    clckAceptarCortesia() {
      if (this.cobrarTotal == 0.00) {
        this.mensajeAdvertencia("No se pueden cobrar cuentas en cero");
        return;
      }
      let uri = this.ip + `Imprimir_ConstanciaCortesia/${
       this.$route.params.id
        }`;

      var item = {
        'propina': this.cobrarPropina,
        'subTotal': this.cobrarSubTotal,
        'total': this.cobrarTotal + this.cobrarPropina,
        'observacion': this.cortesiaModelObservacion
      }

      this.axios
        .post(uri, item)
        .then(response => {
          if (response.data == 0) {
            this.mensajeError("No hay caja abierta");
          } else if (response.data == 1) {
            this.$router.push({
              name: "ordenesMesa"
            });
          } else {
            this.mensajeError("No se pudo efectuar la transacción");
          }
        })
        .catch(error => {
          this.mensajeError("No se puede efectuar la transacción, revise si hay caja abierta");
          this.println(error);
        });

      this.dlgCortesia = false;
    },


    /*
    |--------------------------------------------------------------------------
    | Haciendo operaciones
    |--------------------------------------------------------------------------
    */
    calculando() {

      var camb = (this.cobrarEfectivo + this.cobrarTarjeta) - (this.cobrarTotal + this.cobrarPropina);
      this.cobrarSubTotal = this.cobrarTotal;

      if (camb < 0) {
        this.cambioColor = "red darken-4";
      } else {
        this.cambioColor = "amber darken-4";
      }
      /* this.$log.info(camb);
      this.$log.info(this.cobrarTotal);
      this.$log.info(this.cobrarEfectivo);
      this.$log.info(this.cobrarTarjeta); */
      // this.cobrarCambio = (this.cobrarTotal - (this.cobrarEfectivo + this.cobrarTarjeta)).toFixed(2);  

      try {
        this.cobrarCambio = parseFloat(camb);
      } catch (error) {
        this.$log.info("error de parseo");
        this.cobrarCambio = 0;
      }



    },
    println(mensaje) {
      this.$log.info(mensaje);
    },
    /*
    +------------------------------------------------+
    |   Mensajes
    +------------------------------------------------+
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
    }
  }
}