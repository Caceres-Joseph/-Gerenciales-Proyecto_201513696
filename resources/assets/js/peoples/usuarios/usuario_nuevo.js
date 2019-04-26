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

            let uri2 = "/Persona_items2";
            this.axios.get(uri2).then(response => {
                this.personas = response.data;
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


            let uri = "/Usuario_insert";
            if (this.item.nombre == ""|| this.item.password=="") {
                this.focoInicio();
                this.$emit("mensajeAdvertencia", "Tiene que colocarle nombre y una contraseña.");
                return;
            }

            if(this.item.password!=this.item.password1){
                this.item.password="";
                this.item.password1="";
                this.$emit("mensajeAdvertencia", "Las contraseñas no coinciden");
                return;
            }

            this.axios
                .post(uri, this.item)
                .then(response => {
                    this.personas=[];

                    this.$emit("mensajeInfo", "Nuevo Usuario creado exitosamente");
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


