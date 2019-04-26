export default {
    props: ['ip'],
    data: () => ({
        ordenes: []
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
            //ordenes en cero 

            let uri = this.ip + "Orden_ordenesEnCeroMesero";
            this.axios.get(uri).then(response => {
                this.ordenes = response.data;
            });

        },
        /*
        |--------------------------------------------------------------------------
        | CLICK
        |--------------------------------------------------------------------------
        */
        eliminarOrden(item) { 
            let uri = this.ip + `Orden_deleteOrden/${
                item
              }`;
            this.axios
                .get(uri)
                .then(response => {
                    this.$router.push({ name: "sirviendo" });
                })
                .catch(error => {
                    this.$log.info("No se pudo eliminar el item");
                }); 
        }
    }
}