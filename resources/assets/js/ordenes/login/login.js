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
    lugares: [],


    /* Menu */
    fav: true,
    menu: false,
    message: false,
    hints: true,
    izquierda: false,
    txtPassword: "",

    idUsuario: null,

        /* SnackBar */
        snackColor: "teal darken-4",
        snackStatus: false,
    sanckText: " ",
    modeloCombo:null

  }),

  destroyed() {
    document.removeEventListener("keyup", this.atajos);
  },
  mounted() {
    document.addEventListener("keyup", this.atajos);
  },

  created() {
    this.inicializar();
    let uri = this.ip + "Usuario_actual/";
    this.axios.get(uri).then(response => {
      //this.$log.info(response.data);
    });

    //this.$log.info(this.cards);
  },

  methods: {
    atajos(event) {

    },
    /*
    |--------------------------------------------------------------------------
    | INICIALIZAR
    |--------------------------------------------------------------------------
    */
    inicializar() {
      let uri = this.ip + "Persona_meseros";
      this.axios.get(uri).then(response => {
        this.focoCombo();
        this.lugares = response.data;
        for (let index = 0; index < this.lugares.length; index++) {
          const element = this.lugares[index];
          var color = "blue";
          switch (index) {
            case 0:
              color = "light-blue darken-3";
              break;
            case 1:
              color = "teal darken-3"
              break;
            case 2:
              color = "green darken-4"
              break;
            case 3:
              color = "amber darken-4"
              break;
            case 4:
              color = "brown darken-4"
              break;
            case 5:
              color = "deep-orange accent-4"
              break;
            case 6:
              color = "green darken-4"
              break;
          }
          var card = {
            title: element.nombre,
            color: color,
            id: element.idUsuario
          }
          this.cards.push(card);
        }
      });
    },
    /*
    |--------------------------------------------------------------------------
    | CLICK
    |--------------------------------------------------------------------------
    */
    clckVerMesas(item) {
      this.txtPassword = "";
      //this.$log.info(item);
      this.menu = true;
      this.idUsuario = item.title;

      this.focoPassword();
      /*  this.$router.push({
         name: "mesas",
         params: {
           id: item,
           color: color
         }
       }); */
    },
    clckTeclado(numero) {
      this.txtPassword = this.txtPassword + numero;
    },
    clckTecladoBorrar() {
      if (!this.txtPassword.length < 1) { //no borro
        this.txtPassword = this.txtPassword.slice(0, -1);
      }
    },
    clckTecladoEnter() {
      this.validar();
      this.txtPassword = "";

    },
    validar() {
      if (this.idUsuario==null) {
        return;
      }
      var user = {
        'usuario': this.idUsuario,
        'password': this.txtPassword
      }; 

      let uri3 = this.ip + "Usuario_validation";
      this.axios.post(uri3, user).then(response => {
        if (response.data == 1) {
          /* var href = this.ip + "bienvenido"; //find url
          window.location = href;
          
          
          *///si exist el usuario
          this.$router.push({ name: "sirviendo" });
          
        } else { 
           this.mensajeError("Contraseña incorrecta");
          
          //Error en contraseña y usuario
        }
        //this.$log.info(response.data);
      });

      //this.$log.info(this.item);
    },    /*
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




    cbCambioProducto(e) {
      this.$log.info(e);
      if(e==null)
        return;

      if (e.id == parseInt(e.id, 10)) {
        this.clckVerMesas(e);
      }

    },

    focoCombo(){

      this.$nextTick(() => {
        this.$refs.focoCombo.clearableCallback();
      });
    },


    focoPassword(){

      setTimeout(() => {
        this.$nextTick(this.$refs.txtPassword.focus);
      }, 300);

    },


  }
}