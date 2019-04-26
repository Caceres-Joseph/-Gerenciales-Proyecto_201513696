export default {

    /*
    |--------------------------------------------------------------------------
    | Datos por componente
    |--------------------------------------------------------------------------
    */
    props: {
        items: Array,
        titulo: String,
        encabezado: Array,
        clckEditar: Function,
        clckEliminar: Function,
        clckNuevo: Function,
        buscar:String
    },

    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    */

    data: () => ({
        /*
        |------------------
        | Items temporal
        |-------------------
        */
        itemEliminar: {},
        /*
        |------------------
        | Items
        |-------------------
        */

        dlgEliminar: false,
        search: ""

    }),

    /*
    |--------------------------------------------------------------------------
    | Funciones
    |--------------------------------------------------------------------------
    */

    created: function () {
        this.inicializar();
    },

    /*
    |--------------------------------------------------------------------------
    | Funciones
    |--------------------------------------------------------------------------
    */

    methods: {

        /*
        |-------------------------
        | Inicio
        |-------------------------
        */
        inicializar() {
        },

        reset() {
            this.itemRetorno = {};
            this.$nextTick(this.$refs[0][0].focus);
        },

        /*
        |-------------------------
        | Botones
        |-------------------------
        */
        clckCancelar() {
            this.$router.push({
                name: this.configuracion['rutaCancelar']
            });
        },

        clckEliminarTemp(item) {
            this.dlgEliminar = true;
            this.itemEliminar = item;
        },
        btnEliminar(){
            this.dlgEliminar=false;
            this.clckEliminar(this.itemEliminar);
        },


        /*
        |-------------------------
        | Select
        |-------------------------
        */
        checkBox(item, nombre) {
            if (!item.check) {
                this.itemRetorno[nombre] = null;
            }
        }


    }
}