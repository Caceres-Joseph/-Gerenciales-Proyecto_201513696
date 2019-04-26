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
        mesas: [],
        items: {},
        modeloCombo: null
    }),
    created() {
        //this.inicializar();
        //this.$log.info(this.$route.params.color);
        this.inicializar(this.$route.params.id, this.$route.params.color)
    },

    methods: {
        /*
        |--------------------------------------------------------------------------
        | INICIALIZAR
        |--------------------------------------------------------------------------
        */
        inicializar(idLugar, color) {
            //let uri = this.ip + "Lugar_items";
            let uri = this.ip + `Mesa_itemIdLugar/${
                idLugar
                }`;

            this.axios.get(uri).then(response => {
                this.focoCombo();
                this.mesas = response.data;
                for (let index = 0; index < this.mesas.length; index++) {
                    const element = this.mesas[index];

                    var meserosActuales = [];
                    //tengo que buscar los meseros asociados con ese id de la mesa.

                    /* Orden_usuarioPorMesa */

                    let uri2 = this.ip + `Orden_usuarioPorMesa/${
                        element.idMesa
                        }`;
                    this.axios.get(uri2).then(response => {
                        var card = {
                            title: element.nombre,
                            color: color,
                            id: element.idMesa,
                            meseros: response.data
                        }
                        this.cards.push(card);


                        //this.$log.info(response.data);
                    });


                } /* */
            });
        },

        /*
        |--------------------------------------------------------------------------
        | CLICK
        |--------------------------------------------------------------------------
        */
        clckVerMesas(item) {
            this.$log.info(item);
        },
        pantallaOrden(item) {

            /* this.crearOrden(); //le tengo que enviar el id de la orden

            this.$log.info(item);
            this.$router.push({
              name: "orden",
              params: { id: item.id}
            }); */
            //this.println(this.$route.params.id)// la mesa
            this.items.idMesa = item.id;

            let uri = this.ip + "Orden_insert";
            this.axios
                .post(uri, this.items)
                .then(response => {
                    this.$router.push({
                        name: "orden",
                        params: {
                            id: response.data
                        }
                    });
                })
                .catch(error => {
                    this.$log.info("Error al insertar");
                });

        },
        pantallaOrden2(item) {

            this.crearOrden(); //le tengo que enviar el id de la orden

            this.$log.info(item);
            this.$router.push({
                name: "orden",
                params: {
                    id: item.id
                }
            });
        },
        crearOrden() {

        },
        /*
        |--------------------------------------------------------------------------
        | FUNCIONES
        |--------------------------------------------------------------------------
        */
        println(mensaje) {
            this.$log.info(mensaje);
        },



        cbCambioProducto(e) {
            if(e==null)
                return;

            this.$log.info(e);

            var item={
                id:e.idMesa
            }
            if (e.idMesa == parseInt(e.idMesa, 10)) {
                this.pantallaOrden(item);
            }

        },

        focoCombo(){

            this.$nextTick(() => {
                this.$refs.focoCombo.clearableCallback();
            });
        },

    }
}