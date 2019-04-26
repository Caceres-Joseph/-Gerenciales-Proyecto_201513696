export default {
  props: ['ip'],
    data: () => ({
      cards: [
        /* {
          title: 'Primer Nivel',
          src: '/storage/images/categorias/logoMirador.jpeg',
          flex: 4,
          color: "light-blue darken-3"
        },
        {
          title: 'Segundo Nivel',
          src: '/storage/images/categorias/logoMirador.jpeg',
          flex: 4,
          color: "orange darken-3"
        },
        {
          title: 'Tercer Nivel',
          src: '/storage/images/categorias/logoMirador.jpeg',
          flex: 4,
          color: "teal darken-3"
        } */
      ],
      ordenes: [], 
      /*
      |------------------ 
      | Desactivar
      |------------------- 
      */
      desacBtnActualizar: true,
     

    }),
    created() {
      this.inicializar();  
    },
  
    methods: {
      /*
      |--------------------------------------------------------------------------
      | INICIALIZAR
      |--------------------------------------------------------------------------
      */
      inicializar() {
        let uri = this.ip + "Orden_itemsActualUser";
        this.axios.get(uri).then(response => {
          //this.$log.info(response.data);
          this.ordenes = response.data;
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
      /*
      |--------------------------------------------------------------------------
      | CLICK
      |--------------------------------------------------------------------------
      */
      clckVerMesas(item) {
        //this.$log.info(item);

        this.$router.push({
          name: "orden",
          params: { id: item.idOrden}
        }); 

        /* this.$router.push({
          name: "mesas",
          params: { id: item, color:color}
        }); */
      }, 

      clckActualizar() {
        this.desacBtnActualizar = false;
        setTimeout(() => {
          this.desacBtnActualizar = true;
        }, 1500);

        this.inicializar();
      }
    
    }
  }