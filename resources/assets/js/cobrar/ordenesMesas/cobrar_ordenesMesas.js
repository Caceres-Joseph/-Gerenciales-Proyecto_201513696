export default {
    props: ['ip'],
    data: () => ({
        cards: [
            /* {
              title: 'Primer Nivel',
              src: '/storage/images/categorias/logoGamer.jpeg',
              flex: 4,
              color: "light-blue darken-3"
            }, */
        ],
        lugares: [],
        arrayMesas: [],
        arrayMesasColor: [],
        arrayOrdenes: [],
        idActualLugar: 0,
        idMesaActual: 0,
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
    }),
    created() {
        this.inicializar();
        let uri = this.ip + "Usuario_actual/";
        this.axios.get(uri).then(response => {
            //this.$log.info(response.data);
        });

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
                this.lugares = response.data;
                this.cards = [];
                for (let index = 0; index < this.lugares.length; index++) {
                    const element = this.lugares[index];
                    var card = {
                        title: element.nombre,
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
        clckVerMesas(item) {
            this.idActualLugar = item;
            let uri = this.ip + `Mesa_itemIdLugarOcupada/${
                item
              }`;
            this.axios.get(uri).then(response => {
                this.arrayMesasColor = [];
                for (let index = 0; index < response.data.length; index++) {
                    this.arrayMesas = response.data;
                    const element = this.arrayMesas[index];
                    //sthis.$log.info(element);
                    var color = "blue";
                    let uri2 = this.ip + `Orden_countMesa/${
                        element.idMesa
                     }`;
                    this.axios.get(uri2).then(response => {
                        if (response.data > 0) {
                            this.arrayMesas[index].color = "red darken-4";
                        } else {
                            this.arrayMesas[index].color = "amber darken-4";
                        }
                        this.arrayMesasColor.push(this.arrayMesas[index]);

                        /* this.$log.info(response.data);
                        var card = {
                            'title': element.nombre,
                            color: color,
                            id: element.idLugar
                        } */

                    });


                    /* switch (index) {
                        case 0:
                            color = "light-blue darken-3";
                            break;
                        case 1:
                            color = "teal darken-3"
                            break;
                        case 2:
                            color = "teal darken-3"
                            break;
                    } */

                    //this.cards.push(card);
                }
                //this.$log.info(response.data);
                //this.arrayMesas = response.data;
            });
            //this.$log.info(this.arrayMesasColor); 
        },
        clckVerOrdenes(item) {
            this.idMesaActual = item;
            let uri = this.ip + `Orden_usuarioPorMesa/${
                item
              }`;
            this.axios.get(uri).then(response => {
                this.arrayOrdenes = response.data;
                //this.arrayMesas = response.data;
            });

            //this.$log.info(arrayMesas); 
        },
        clckVerOrden(item) {
            this.$router.push({
                name: "orden",
                params: {
                    id: item
                }
            });

            /* this.$router.push({
              name: "mesas",
              params: { id: item, color:color}
            }); */
        },
        clckEliminarOrden(item) {

            this.$log.info(item);
            if (item.total == 0.0) {
                //Orden_deleteOrden

                let uri = this.ip + `Orden_deleteOrden/${item.idOrden}`;
                this.axios.get(uri).then(response => {
                    this.lugares = [];
                    this.clckVerMesas(this.idActualLugar);
                    this.arrayOrdenes = [];
                    //this.inicializar();
                });
            } else {
                this.dlgPassword = true;
                this.itemPassword = item;
                this.accionPassword = "accDeleteGrupal";
            }


            //Orden_deleteOrden 


        },

        clckPasswordAceptar() {
            if (!(this.txtPassword == "Gamer201617")) {
                this.mensajeError("Contraseña incorrecta");
            } else {
                if (this.accionPassword == "accDeleteGrupal") {
                    //Orden_deleteOrden 
                    let uri = this.ip + `Orden_deleteOrden/${this.itemPassword.idOrden}`;
                    this.axios.get(uri).then(response => {
                        this.lugares = [];
                        this.clckVerMesas(this.idActualLugar);
                        this.arrayOrdenes = [];
                        //this.inicializar();
                    });
                }
            }
            this.txtPassword = "";
            this.dlgPassword = false;
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
    }
}