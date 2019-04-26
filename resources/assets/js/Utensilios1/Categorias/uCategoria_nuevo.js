import getDefaultData from './uCategoria_nuevoD';

export default {
    props: ['ip', 'buscarGlobal', 'colorDefecto'],
    data: getDefaultData,
    created() {
        this.inicializar();
    },

    methods: {
        /*
        |--------------------------------------------------------------------------
        | Botones
        |--------------------------------------------------------------------------
        */
        inicializar() {

            this.focoInicio();
            let uri2 = this.ip + `uCategoria_getItems/0`;
            this.axios.get(uri2).then(response => {
                this.categorias = response.data;
            });

            window.scrollTo(0, 0);
        },
        focoInicio() {
            setTimeout(() => {
                this.$nextTick(this.$refs.focoNuevo.focus);
            }, 500);
        },

        /*
        |--------------------------------------------------------------------------
        | Botones
        |--------------------------------------------------------------------------
        */
        clckCancelar() {
            this.$router.push({
                name: "usuarios"
            });
        },
        clckAceptar() {


            let uri = this.ip + "uCategoria_insertItem";
            if (this.item.nombre == "") {
                this.focoInicio();
                this.$emit("mensajeAdvertencia", "Tiene que colocarle nombre.");
                return;
            }



            this.axios
                .post(uri, this.item)
                .then(response => {
                    this.$emit("mensajeInfo", "Nueva categoría creada exitosamente");
                    return;
                    this.categorias=[];

                    this.inicializar();
                })
                .catch(error => {
                    this.$emit("mensajeError", "Error al insertar");
                });
        },

        /*
        |--------------------------------------------------------------------------
        | ComboBox
        |--------------------------------------------------------------------------
        */

        cbCambioNuevoUsuario(item2) {

            if (item2.idPersona == parseInt(item2.idPersona, 10)) {
                this.item.idPersona = item2.idPersona;
            }
        },
    }
};


