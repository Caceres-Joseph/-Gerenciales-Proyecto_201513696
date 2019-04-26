export default {
  props: ['ip'],
  data: () => ({
    cards: [

    ],
    lugares: [],
    modeloCombo:null
  }),
  created() {
    this.inicializar();
    let uri = this.ip + "Usuario_actual/";
    this.axios.get(uri).then(response => {
      //this.$log.info(response.data);
    });
    
    //this.$log.info(this.cards);
  },

  methods: {
    /*
    |--------------------------------------------------------------------------
    | INICIALIZAR
    |--------------------------------------------------------------------------
    */
    inicializar() {
      let uri = this.ip + "Lugar_items";
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
              color = "teal darken-3"
              break;
          }
          var card = {
            title: element.nombre,
            color: color,
            id: element.idLugar
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
    clckVerMesas(item, color) {
      //this.$log.info(item);
      this.$router.push({
        name: "mesas",
        params: { id: item, color:color}
      });
    },


    cbCambioProducto(e) {
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