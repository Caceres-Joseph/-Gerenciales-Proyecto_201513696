
import Dropdown from "bp-vuejs-dropdown";
import eSnack from "../modules/SnackBar/eSnack.vue";
import html2canvas from "html2canvas";
import getDefaultData from "./uten_homeD.js";

export default {
    props: {
        buscarGlobal: String,
        ip: String,
        itemsDisplayPersonas: Array,
        itemsDisplayRols: Array,
        itemsDisplayUsuarios: Array
    },
    components: {
        Dropdown,
        eSnack
    },
    data: getDefaultData,

    created() {
       // this.srcImagen = this.sede + "storage/images/categorias/logofinal.png";
        this.srcLogo = this.sede + "storage/images/categorias/logo1.png";
        this.listener();
        this.getUser();
        //this.inicializar();
    },
    methods: {

        /*
        |--------------------------------------------------------------------------
        | Inicio
        |--------------------------------------------------------------------------
        */
        inicializar() {

            let uri = this.ip + "Permiso_getPermisoModuloPersonas";

            this.axios.get(uri).then(response => {
                this.permisos = response.data;
            });
        },

        /*
        |--------------------------------------------------------------------------
        | Otras operaciones
        |--------------------------------------------------------------------------
        */
        getUser() {

            let uri = this.ip + "Usuario_actual";
            this.axios.get(uri).then(response => {
                //this.$log.info(response.data.usuario);

                this.inicial = response.data.usuario.charAt(0).toUpperCase();
            });


        },
        bug() {
            this.hiddenMenu();
            this.takeScreen();
            this.dlgBug = true;
            this.$nextTick(this.$refs.focoBug.focus);
        },
        atajos() {
            this.hiddenMenu();
            this.dlgAtajos = true;
        },
        salir() {
            //haciendo logout
            let uri = this.ip + "session_remove/";

            this.axios.get(uri).catch(error => {
                this.$log.info("Error al cerrar session");
            });

            var href = "https://www.chimaltv.ga"; //find url
            window.location = href;
        },
        inicio() {
            this.hiddenMenu();
            this.searchParent = "";
            //lendo a home
            var href = this.ip + "bienvenido"; //find url
            window.location = href;
        },


        clckCatgorias() {

            this.searchParent = "";
            this.$router.push({
                name: "ucat_display"
            });
        },
        clckPaquetes() {

            this.searchParent = "";
            this.$router.push({
                name: "personas"
            });
        },
        clckClientes() {


            this.searchParent = "";
            this.$router.push({
                name: "usuarios"
            });
        },


        enviarTab(indice) {
            this.tabs = indice;
        },
        listener() {
            window.addEventListener("keydown", e => {
                if (e.ctrlKey && e.code === "KeyF") {
                    //buscar

                    this.$nextTick(this.$refs.focoBuscar.focus);
                } else if (e.ctrlKey && e.altKey && e.code === "KeyU") {
                    //Clientes
                    this.clckClientes();
                } else if (e.ctrlKey && e.altKey && e.code === "KeyR") {
                    //Ubicaciones

                    this.clckCatgorias();
                } else if (e.ctrlKey && e.altKey && e.code === "KeyP") {
                    //Planes

                    this.clckPaquetes();
                }
            });
        },
        reportarBug() {
            let uri = this.ip + "Bug_insert";

            this.axios
                .post(uri, this.itemBug)
                .then(response => {
                    this.$refs.rSnack.mensajeInfo(
                        "Se reportó correctamente, sentimos los inconvenientes"
                    );
                    this.dlgBug = false;
                    this.itemBug = {};
                })
                .catch(error => {
                    this.$refs.rSnack.mensajeError("No se pudó reportar correctamente");
                });
        },
        takeScreen() {
            //var str = html2canvas(document.body);
            html2canvas(document.body).then(canvas => {
                //document.body.appendChild(canvas);

                var data = canvas.toDataURL();
                this.itemBug.image = data;
            });
        },
        hiddenMenu() {
            this.$refs.dropdown.isHidden = true;
        },

        /*
        |--------------------------------------------------------------------------
        | Botones
        |--------------------------------------------------------------------------
        */
        mensajeInfo(mensaje) {
            this.$refs.rSnack.mensajeInfo(
                mensaje
            );
        },
        mensajeError(mensaje) {

            this.$refs.rSnack.mensajeError(
                mensaje
            );
        },
        mensajeAdvertencia(mensaje) {

            this.$refs.rSnack.mensajeAdvertencia(
                mensaje
            );
        },

        /*
        |--------------------------------------------------------------------------
        | Botones
        |--------------------------------------------------------------------------
        */
        setDisplayPersonas(items) {
            //this.$log.info(items);
            this.itemsPersonas = items;
        },
        setDisplayRols(items) {
            this.itemsRols = items;
        },
        setDisplayUsuarios(items) {
            this.itemsUsuarios = items;
        }
    }
};