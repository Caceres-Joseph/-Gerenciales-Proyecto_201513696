import getDefaultData from './usuario_nuevoD';

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


            //cargando la lista de personas
            let uri2 = `/Persona_items3/${
                this.$route.params.id
                }`;

            this.axios.get(uri2).then(response => {
                this.personas = response.data;

                //cargando los datos
                let uri = `/Usuario_item/${this.$route.params.id}`;
                this.axios.get(uri).then(response1 => {
                    this.item = response1.data;
                    this.cbPersonaModel = response1.data;
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
                name: "usuarios"
            });
        },
        clckAceptar() {


            if (this.item.nombre == "" || this.item.password == "") {
                this.focoInicio();
                this.$emit("mensajeAdvertencia", "Tiene que colocarle nombre y una contraseña.");
                return;
            }


            let uri = `/Usuario_update/${
                this.$route.params.id
                }`;

            this.axios
                .post(uri, this.item)
                .then(response => {
                    this.$emit("mensajeInfo", "Usuario modificado exitosamente");
                    this.clckCancelar();
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

        cbCambioNuevoUsuario(item2) {

            if (item2.idPersona == parseInt(item2.idPersona, 10)) {
                this.item.idPersona = item2.idPersona;
            }
        },

        /*
        |--------------------------------------------------------------------------
        | Password
        |--------------------------------------------------------------------------
        */
        clckPass() {
            if (this.pass == "password") {
                this.pass = "text";
            } else {
                this.pass = "password";
            }
        }
    }
};


