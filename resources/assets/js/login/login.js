export default {
    props: ['ip'],
    data: () => ({
        /* SnackBar */
        snackColor: "teal darken-4",
        snackStatus: false,
        sanckText: " ",

        /* Items */
        item: {},
        drawer: null
    }),
    created() {
        window.scrollTo(0, 0);

        ///desloguear

        //haciendo logout
        let uri =  "/session_remove/";

        this.axios
            .get(uri)
            .catch(error => {
                this.$log.info("Error al cerrar session");
            });




        this.focoTipoComprobante();
    },
    methods: {
        validar() {

            let uri3 = this.ip + "Usuario_validation";

            this.$log.info(uri3);
            this.axios.post(uri3, this.item).then(response => {
                if (response.data == 1) {
                    var href = this.ip + "bienvenido"; //find url
                    window.location = href;
                    //si exist el usuario
                } else {
                    this.item = {};
                    this.focoTipoComprobante();
                    this.mensajeError("Usuario y/o contraseña incorrecta");
                    //Error en contraseña y usuario
                }
                this.$log.info(response.data);
            });

            //this.$log.info(this.item);
        },
        /*
        +------------------------------------------------+
        |   Mensajes
        +------------------------------------------------+
        */
        mensajeError(mensaje) {
            this.snackColor = "red";
            this.sanckText = "[Error] " + mensaje;
            this.snackStatus = true;
        },
        mensajeInfo(mensaje) {
            this.snackColor = "light-blue darken-4";
            this.sanckText = mensaje;
            this.snackStatus = true;
        },
        mensajeAdvertencia(mensaje) {
            this.snackColor = "amber darken-4";
            this.sanckText = "[Advertencia] " + mensaje;
            this.snackStatus = true;
        }

        ,
        focoTipoComprobante() {

            setTimeout(() => {
                this.$nextTick(this.$refs.txtTipoComprobante.focus);
            }, 500);

        },

    }
};