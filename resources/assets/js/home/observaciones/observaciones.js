export default {
  props: ['ip'],
  data: () => ({
    chips: []
  }),
  created() {
    this.inicializar();
    window.scrollTo(0, 0);
   /*  let uri = this.ip + "Usuario_actual/";
    this.axios.get(uri).then(response => {
      //this.$log.info(response.data);
    }); */

    //this.$log.info(this.cards);
  },
  
  methods: {
    /*
    |--------------------------------------------------------------------------
    | INICIALIZAR
    |--------------------------------------------------------------------------
    */
    inicializar() {


      let uri = this.ip + "Observacion_items";
      this.axios.get(uri).then(response => {

        this.chips = response.data; 
      }); /* */
    },

    insertarMultiple() {
      //Observacion_insertMultiple

    },
    guardar() {
      let uri = this.ip + "Observacion_insertMultiple";
      this.axios
        .post(uri, this.chips)
        .then(response => {

        })
        .catch(error => {
          this.$log.info("Error al insertar");
        });


    },
    /*
    |--------------------------------------------------------------------------
    | CLICK
    |--------------------------------------------------------------------------
    */
    remove(item) {
      this.chips.splice(this.chips.indexOf(item), 1)
      this.chips = [...this.chips]
    }
  }
}