export default {
  props: ['ip'],
  data: () => ({
    /* 
     *Display items
     */
    search: "",
    headers: [{
        text: "Nombre",
        value: "nombre",
      },
      {
        text: "Monto",
        value: "monto",
        align: 'right',
      },
      {
        text: "Observacion",
        value: "observacion"
      },
    ],
    abonos: [],

    /* SnackBar */
    snackColor: "teal darken-4",
    snackStatus: false,
    sanckText: " ",

    /* TOTAL */
    totalAbono: 0.0,
  }),

  computed: {

  },

  watch: {

  },

  created() {
    this.inicializar();
  },

  methods: {
    /*
    +------------------------------------------------+
    |   Inicializar
    +------------------------------------------------+
    */
    inicializar() {
      let uri = this.ip + "Gasto_getGastos";
      this.axios.get(uri).then(response => {

        if (response.data != null) {
          this.abonos = response.data[0];
          this.totalAbono = parseFloat(response.data[1]);
        } else {
          this.totalAbono = 0.00;
        } 
      });
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
    },
    /*
    +------------------------------------------------+
    |   Click
    +------------------------------------------------+
    */
    clckImprimir() { 
      let uri = this.ip + "Imprimir_GastoCajaActual";
      this.axios.get(uri).then(response => {
        if (response.data != null) {
          this.mensajeInfo("Imprimiendo");
        }
      });
    }
  }
};