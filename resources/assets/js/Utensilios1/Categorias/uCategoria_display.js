import getDefaultData from "./uCategoria_displayD.js";


export default {
    props: ['ip', 'buscarGlobal', 'colorDefecto'],
    data: getDefaultData,

    created() {
        this.inicializar();
        //this.enviarTab();
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
            this.items = this.itemsDisplayUsuarios;

            this.axios.get(uri).then(response => {

                this.$log.info("hola ütos");
                this.$log.info(response.data);
                return;
                if (this.itemsDisplayUsuarios == 0 || JSON.stringify(response.data) != JSON.stringify(this.items)) {
                    this.items = response.data;
                    this.$emit("accDisplayUsuarios", this.items);
                }
            });
        },

        /*
        |--------------------------------------------------------------------------
        | Botones
        |--------------------------------------------------------------------------
        */
        clckNuevo() {

            this.$router.push({
                name: "ucat_nuevo"
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

            let uri = this.ip + `Usuario_delete/${
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
        enviarTab() {
            this.$emit("accTabs", "0");
            window.scrollTo(0, 0);
        },
        getIndice(){
            var indice=0;
            indice +=this.itemsPermisos.roles.permiso;
            indice +=this.itemsPermisos.personas.permiso;
            return indice;
        }
    }
};