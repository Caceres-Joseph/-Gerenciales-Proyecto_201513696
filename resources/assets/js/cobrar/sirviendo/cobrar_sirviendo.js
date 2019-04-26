export default {
  props: ['ip'],
  data: () => ({
    cards: [
      /* {
        title: 'Primer Nivel',
        src: '/storage/images/categorias/logoGamer.jpeg',
        flex: 4,
        color: "light-blue darken-3"
      },
      {
        title: 'Segundo Nivel',
        src: '/storage/images/categorias/logoGamer.jpeg',
        flex: 4,
        color: "orange darken-3"
      },
      {
        title: 'Tercer Nivel',
        src: '/storage/images/categorias/logoGamer.jpeg',
        flex: 4,
        color: "teal darken-3"
      } */
    ],
    ordenes: [],
    /*
    |------------------ 
    | Password
    |------------------- 
    */
    dlgPassword: false,
    txtPassword: "",
    itemPassword: null,
    accionPassword: "",
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
    | Desactivar
    |------------------- 
    */
    desacBtnActualizar: true,

    //foco
    focText: "",
    modeloCombo:null

  }),
  created() {
    this.inicializar();

    //this.$log.info(this.cards);
  },

  methods: {
    /*
    |--------------------------------------------------------------------------
    | INICIALIZAR
    |--------------------------------------------------------------------------
    */
    inicializar() {
      let uri = this.ip + "Orden_ordenesSinCobrar";
      this.axios.get(uri).then(response => {
        //this.$log.info(response.data);
        this.ordenes = response.data;
        this.focus();
        /*           for (let index = 0; index < this.lugares.length; index++) {
                      const element = this.lugares[index];
                      //this.$log.info(response.data);  
                     var card = {
                      hora: element.nombre, 
                      id: element.idLugar
                    }
                    this.cards.push(card);  
                  } */
      });
    },
    focus() {
      this.focoCombo();
    },
    tab() {
      this.focus();

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

      /* this.$router.push({
        name: "mesas",
        params: { id: item, color:color}
      }); */
    },
    clckEliminarOrden(item) {

      if (item.total == 0.0) {
        //Orden_deleteOrden
        this.$log.info(item);
        let uri = this.ip + `Orden_deleteOrden/${item.idOrden}`;
        this.axios.get(uri).then(response => {
          this.inicializar();
        });
      } else {
        this.dlgPassword = true;
        this.itemPassword = item;
        this.accionPassword = "accDeleteGrupal";
      }

    },

    clckPasswordAceptar() {
      if (!(this.txtPassword == "Gamer201617")) {
        this.mensajeError("Contraseña incorrecta");
      } else {
        if (this.accionPassword == "accDeleteGrupal") {
          //Orden_deleteOrden 
          let uri = this.ip + `Orden_deleteOrden/${this.itemPassword.idOrden}`;
          this.axios.get(uri).then(response => {
            this.inicializar();
          });
        }
      }
      this.txtPassword = "";
      this.dlgPassword = false;
    },

    clckActualizar() {
      this.desacBtnActualizar = false;
      setTimeout(() => {
        this.desacBtnActualizar = true;
      }, 1500);

      this.inicializar();
    },
    clckDividir(item) {
      this.$router.push({
        name: "dividir",
        params: {
          id: item.idOrden
        }
      });
    },
    /*
    +--------------------------------------------------------------------------
    |   COMBO CAMBIO
    +--------------------------------------------------------------------------
    */
    cbCambioProducto(e) {
      if(e==null)
        return;

      if (e.idOrden == parseInt(e.idOrden, 10)) { //es numero
        this.$router.push({
          name: "orden",
          params: {
            id: e.idOrden
          }
        });
      } 

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
    +--------------------------------------------------------------------------
    |   COMBO
    +--------------------------------------------------------------------------
    */

    cbCambioProducto1(e) {
      if(e==null)
        return;

      if (e.idLugar == parseInt(e.idLugar, 10)) {
        this.clckVerMesas(e.idLugar,"blue darken-4");
      }

    },

    focoCombo(){

      this.$nextTick(() => {
        this.$refs.focoCombo.clearableCallback();
      });
    },

  }
}