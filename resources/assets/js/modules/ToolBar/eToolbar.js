import Dropdown from "bp-vuejs-dropdown";
import eSnack from "../SnackBar/eSnack.vue";
import html2canvas from "html2canvas";
export default {

    /*
    |--------------------------------------------------------------------------
    | Datos por componente
    |--------------------------------------------------------------------------
    */
    props: {
        colorBarra: String,
        subModulos: Array,
        atajos1:Array,
        chip:Object
    },
    components: {
        Dropdown,
        eSnack
    },

    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    */

    data: () => ({
        tabs: -1,
        searchParent: "",
        dlgAtajos: false,
        dlgBug: false,
        itemBug: {},
        colorDefecto: "orange darken-4",
        srcImagen: "",
        srcLogo: "",
        inicial: "-",


        itemsPersonas: [],
        itemsRols: [],
        itemsUsuarios: [],
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
            this.getUser();
            this.listener();
        },

        reset() {
            this.itemRetorno = {};
            this.$nextTick(this.$refs[0][0].focus);
        },


        listener() {
            window.addEventListener("keydown", e => {
                if (e.ctrlKey && e.code === "KeyF") {
                    //buscar

                    this.$nextTick(this.$refs.focoBuscar.focus);
                }
            });
        },


        /*
        |--------------------------------------------------------------------------
        | Otras operaciones
        |--------------------------------------------------------------------------
        */
        getUser() {
            let uri = "/Usuario_actual";
            this.axios.get(uri).then(response => {
                this.inicial = response.data.usuario.charAt(0).toUpperCase();
            });
        },
        bug() {
            this.hiddenMenu();
            this.takeScreen();
            this.dlgBug = true;


            setTimeout(() => {
                this.$nextTick(this.$refs.focoBug.focus);
            }, 500);

        },
        atajos() {
            this.hiddenMenu();
            this.dlgAtajos = true;


            this.$nextTick(() => this.$refs.btnAtajos.$el.focus())

        },
        salir() {
            //haciendo logout
            let uri =  "/session_remove/";

            this.axios
                .get(uri)
                .catch(error => {
                    this.$log.info("Error al cerrar session");
                });

            var href = "/login"//find url
            window.location = href;
        },
        inicio() {
            this.hiddenMenu();
            this.searchParent = "";
            //lendo a home
            var href = "/bienvenido"; //find url
            window.location = href;
        },


        /*
        |--------------------------------------------------------------------------
        | SubModulos
        |--------------------------------------------------------------------------
        */

        reportarBug() {
            let uri = "/Bug_insert";

            this.axios
                .post(uri, this.itemBug)
                .then(response => {
                    this.$refs.rSnack.mensajeInfo(
                        "Se reportó correctamente, le agradecemos sus comentarios"
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




    }
}