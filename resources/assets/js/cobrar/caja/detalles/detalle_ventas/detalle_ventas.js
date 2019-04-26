export default {
  props: ['ip'],
  data: () => ({
    /* 
     *Display items
     */
    search: "",
    headers: [
      {
        text: "Orden",
        value: "idOrden", 
      },
      {
        text: "Sub-Total",
        value: "subtotal",
        align: 'right',
      },
      {
        text: "Propina",
        value: "propina",
        align: 'right',
      },
      {
        text: "Total",
        value: "total",
        align: 'right',
      },
      {
        text: "Efectivo",
        value: "efectivo",
        align: 'right',
      },
      {
        text: "Tarjeta",
        value: "tarjeta",
        align: 'right',
      }, 
    ],
    ventas:[],
 
    /* SnackBar */
    snackColor: "teal darken-4",
    snackStatus: false,
    sanckText: " ",

    /* TOTAL */
    totalEfectivo: 0.0,
    totalTarjeta: 0.0,
    totalTotal:0.0,
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
     let uri = this.ip + "ConstanciaPago_getConstancias";
      this.axios.get(uri).then(response => {
         
        if(response.data!=null){
          this.ventas = response.data[0]; 
          this.totalEfectivo = parseFloat(response.data[2]);
          this.totalTarjeta = parseFloat(response.data[1]);
          this.totalTotal = parseFloat(response.data[3]);
         } else {
          this.totalEfectivo = 0.00;
          this.totalTarjeta = 0.00;
          this.totalTotal = 0.00;
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
      let uri = this.ip + "Imprimir_VentaCajaActual";
      this.axios.get(uri).then(response => {
        if (response.data != null) {
          this.mensajeInfo("Imprimiendo");
        }
      });
    }
  }
};