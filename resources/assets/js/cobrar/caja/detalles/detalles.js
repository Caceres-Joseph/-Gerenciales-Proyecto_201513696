export default {
  props: ['ip'],
  data() {
    return {
      /* SnackBar */
      snackColor: "teal darken-4",
      snackStatus: false,
      sanckText: " ",

      /* fasf */
      usuarios: [],

      toggle_exclusive: null,


    };
  },
  computed: {


  },
  created() {
    this.cargarCombo();
  },
  methods: {

    /*
    +------------------------------------------------+
    |   Cargar combo box
    +------------------------------------------------+
    */
    cargarCombo() {
      let uri = this.ip + "Usuario_items";
      this.axios.get(uri).then(response => {
        this.usuarios = response.data;
      });
    },
    /*
    +------------------------------------------------+
    |   Cambio combo box
    |   Aqui cargo tambien las vistas si es que ya existe
    +------------------------------------------------+
    */

    cbCambioUsuario(e) {
      if (e != null) {
        this.idLugarActual = e.idLugar;
        /* Recuperando valores */
        let uri = this.ip + `Mesa_Silla_items/${
            this.idLugarActual
          }`;

        this.axios
          .get(uri)
          .then(response => {
            this.limpiarArregloMesa();
            response.data.forEach(element => {
              if (element.tipo == "M") {
                //Insertando mesa
                this.drawTable(element);
              } else if (element.tipo == "S") {
                //Insertando silla
                this.drawChair(element);
              }
            });
          })
          .catch(error => {
            this.$log.info("Error al recuperar mesas");
          });
      }
    },
    /*
    +------------------------------------------------+
    |   Cambio combo box
    |   Aqui cargo tambien las vistas si es que ya existe
    +------------------------------------------------+
    */

    clckDetalleGasto() {
      this.$router.push({
        name: "detalle_gasto"
      });
    },
    clckDetalleAbono() {
      this.$router.push({
        name: "detalle_abono"
      });
    },
    clckDetalleVenta() {
      this.$router.push({
        name: "detalle_venta"
      });
    },

  }
};