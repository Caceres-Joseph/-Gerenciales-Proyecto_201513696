import getDefaultData from "../usuarios/usuario_displayD.js";


export default {
    props: ['ip', 'buscar', 'colorDefecto'],
    data: getDefaultData,
    destroyed() {
        document.removeEventListener("keyup", this.atajos);
    },
    mounted() {
        document.addEventListener("keyup", this.atajos);
    },
    created() {
        this.inicializar();
    },
    methods: {
        atajos(event) {
            if (event.ctrlKey && event.code == "KeyN") {
                this.clckNuevo();
            }

        },
        /*
        |--------------------------------------------------------------------------
        | Inicio
        |--------------------------------------------------------------------------
        */
        inicializar() {

            let uri = "/Usuario_items";

            this.axios.get(uri).then(response => {
                    this.items = response.data;

            });
            window.scrollTo(0, 0);
        },

        /*
        |--------------------------------------------------------------------------
        | Botones
        |--------------------------------------------------------------------------
        */
        clckNuevo() {

            this.$router.push({
                name: "usuarios_nuevo"
            });
        },
        clckEditar(item) {


            this.$router.push({
                name: "usuarios_editar",
                params: {
                    id: item.idUsuario
                }
            });
        },
        clckEliminar(item) {

            this.itemEliminar = item;
            this.dlgEliminar = true;
        },

        /*
        |--------------------------------------------------------------------------
        | Dialogo
        |--------------------------------------------------------------------------
        */
        btnEliminar() {

            let uri = `/Usuario_delete/${
                this.itemEliminar.idUsuario
                }`;

            this.axios
                .get(uri)
                .then(response => {
                    var index = this.items.indexOf(this.itemEliminar);
                    if (index > -1) {
                        this.items.splice(index, 1);
                    }

                    this.$emit("mensajeInfo", "Usuario eliminado exitosamente");
                })
                .catch(error => {
                    this.$emit("mensajeError", "Ocurrió un error al eliminar, verifique su conexión.");
                });

            this.idEliminar = 0;
            this.dlgEliminar = false;
        },
    }
};