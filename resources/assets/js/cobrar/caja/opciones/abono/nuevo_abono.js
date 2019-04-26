export default {
  props: ['ip'],
  data() {
    return {
      /* SnackBar */
      snackColor: "teal darken-4",
      snackStatus: false,
      sanckText: " ",


      /* ITEMS */
      item: {},

      /* Fecha */
      date: null,
      menu: false,
      modal: false,
      menu2: false,

      /* Fecha2 */
      date2: null,


    };
  },
  computed: {


  },
  created() {
    this.focus();
  },
  methods: {

    focus() {
      setTimeout(() => {
        this.$nextTick(this.$refs.fcTxtNombre.focus);
      }, 500);

    },
    /*
    +------------------------------------------------+
    |   CLICK
    +------------------------------------------------+
    */
    clckAceptar() {

      //Abono_insertItem
      //
      let uri = this.ip + "Abono_insertItem";

      this.axios
        .post(uri, this.item)
        .then(response => {
          this.mensajeInfo("Abono ingresado a caja exitosamente");
          this.item = {};

        })
        .catch(error => {
          this.mensajeError("Error al registrar, revise si hay caja abierta");
          this.$log.info(error);
        });
      this.focus();
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
};