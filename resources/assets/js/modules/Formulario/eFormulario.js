export default {

    /*
    |--------------------------------------------------------------------------
    | Datos por componente
    |--------------------------------------------------------------------------
    */
    props: {
        jsonPreguntas: Array,
        titulo: String,
        configuracion: Object,
        color: String,
        clckAceptar: Function,
        componente1:Object
    },

    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    */

    data: () => ({
        itemRetorno: {},
    }),

    /*
    |--------------------------------------------------------------------------
    | Funciones
    |--------------------------------------------------------------------------
    */

    components: {
    },
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