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
      menu2: false,

      /* Boton Acepta */
      boolBtnAceptar:false,
    };
  },
  computed: {


  },
  created() {
    this.inicializar();
  },
  methods: {
    inicializar() {
      let uri = this.ip + "Caja_obtenerUltimaCajaAbierta/";

      this.axios
      .get(uri )
        .then(response => {
          if (response.data==0) {
            this.boolBtnAceptar = true;

            let uri2 = this.ip + "Caja_EfectivoAdejarCajaAnterior/";
            
            this.axios.get(uri2).then(response => {
              //this.$log.info(response.data);
              this.item.cajaInicial = response.data;


            });

            //tengo que obtener la ultima caja con lo que se cerro
          } else {
            this.boolBtnAceptar = false;
          }
          //this.$log.info(response.data);
         
      })
      .catch(error => { 
        this.$log.info(error);
      });
    },

    /*
    +------------------------------------------------+
    |   CLICK
    +------------------------------------------------+
    */
    clckAceptar() {
      //Caja_abrirCaja
      let uri = this.ip + "Caja_abrirCaja";
      
      this.axios
        .post(uri, this.item)
        .then(response => {
          /* */this.$router.push({
            name: "caja"
          }); 
          this.mensajeInfo("Caja Abierta Exitosamente");
          //lo redirecciono

        })
        .catch(error => {
          this.mensajeError("Error al abrir la caja");
          this.$log.info(error);
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
    }
  }
};