import getDefaultData from './personas_nuevoD.js';

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
            Object.assign(this.$data, getDefaultData());
            this.focoInicio();
            let uri2 = "/Rol_items1";
            this.axios.get(uri2).then(response => {
                this.roles = response.data;

                //cargando los datos
                let uri =  `/Persona_item/${this.$route.params.id}`;
                this.axios.get(uri).then(response1 => {
                    this.item = response1.data;
                    this.cbRolModel = response1.data.idRol;
                });

            });
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
                name: "personas"
            });
        },
        clckAceptar() {
            let uri =  `/Persona_update/${
                this.$route.params.id
                }`;
            if (this.item.nombre == "" || this.item.idRol==null) {
                this.focoInicio();
                this.$emit("mensajeAdvertencia", "Tiene que colocarle nombre y/o indicar el rol");
                return;
            }

            this.axios
                .post(uri, this.item)
                .then(response => {
                    this.clckCancelar();
                    this.$emit("mensajeInfo", "Registro de persona modificada exitosamente");

                })
                .catch(error => {
                    this.$emit("mensajeError", "Error al modificar");
                });
        },

        /*
        |--------------------------------------------------------------------------
        | ComboBox
        |--------------------------------------------------------------------------
        */

        cbCambioNuevoRol(item2) {
            if(item2==null)
                return;

            if (item2 == parseInt(item2, 10)) {
                this.item.idRol = item2;
            }
        },
    }
};


