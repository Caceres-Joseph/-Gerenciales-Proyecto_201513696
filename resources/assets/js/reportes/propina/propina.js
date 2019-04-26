export default {
    props: ['ip'],
    data() {
        return {
            /* SnackBar */
            snackColor: "teal darken-4",
            snackStatus: false,
            sanckText: " ",

            /* fasf */
            usuarios: [],
            idUsuarioPadre: null,

            /* Para el radio button */
            radioGroup: 1,

            /* Dia */
            idCaja: "",
            idCaja1: "",
            idCaja2: "",
            day: null,
            day1: null,
            day2: null,
            month: null,
            month1: null,
            month2: null,



            /* TABLA */

            headers: [{
                    text: "Orden",
                    value: "idOrden"
                },
                {
                    text: "Caja",
                    value: "idCaja"
                },
                {
                    text: "Sub-Total",
                    value: "subTotal"
                },
                {
                    text: "Propina",
                    value: "propina"
                },
                {
                    text: "Total",
                    value: "total"
                },

                /*  {
                     text: "Tarjeta",
                     value: "nombre"
                 },
                 {
                     text: "Efectivo",
                     value: "nombre"
                 }, */
                {
                    text: "Fecha/Hora-Orden",
                    value: "ordenFecha"
                },
                {
                    text: "Fecha/Hora-Cobro",
                    value: "constanciaFecha"
                },
                {
                    text: "Mesero",
                    value: "mesero"
                },
                /* { text: "Cajero"    , value: "nombre" }, */
                /* {
                    text: "Mesero",
                    sortable: false
                } */
            ],
            cobros: [],
            search: "",


            /* MESERO */

            checkMesero: false,

            /* MESERO */

            mostrarTotal: 0.00,
            mostrarSubTotal: 0.00,
            mostrarPropina: 0.00, 
            mostrarMesero: "",
            mostrarFecha: "",

            /* REPORTE */
            reporteActual: {},


        };
    },
    computed: {

    },
    created() {
        this.cargarMeseros();
    },
    methods: {

        /*
        +------------------------------------------------+
        |   Cargar combo box
        +------------------------------------------------+
        */
        cargarMeseros() {
            let uri = this.ip + "Usuario_itemsId";
            this.axios.get(uri).then(response => {
                this.usuarios = response.data;
            });
        },
        /*
        +------------------------------------------------+
        |   Cambio combo box
        |   Aqui cargo tambien las vistas si es que ya existe
        +------------------------------------------------+
        */

        cbCambioUsuario(e) {
            if (e.idUsuario != null) {
                this.idUsuarioPadre = e;
                //this.println(e.idUsuario);
            }
        },

        /*
        +------------------------------------------------+
        |   Chcek box
        +------------------------------------------------+
        */
        checkBoxMesero(e) {

            if (!e) {
                this.usuarios = [];
                //si es falso
                /* this.MedidaModel = null;
                this.idMedidaPadre = null; */
                this.idUsuarioPadre = null;
            } else {
                this.cargarMeseros();
            }
        },

        /*
        +------------------------------------------------+
        |   println
        +------------------------------------------------+
        */
        println(mensaje) {
            this.$log.info(mensaje);
        },
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
        },
        /*
        +------------------------------------------------+
        |   Click
        +------------------------------------------------+
        */
        clckCaja() {
            if (this.idUsuarioPadre == null) { //sin usuario
                //envio el id de la caja
                if (this.idCaja == "") { //no hay caja seleccionada
                    this.mensajeAdvertencia("Escriba el número de caja");
                } else {
                    this.recuperarCajaSinUsuario();
                }
            } else { //con usaurio
                this.recuperarCajaConUsuario();
            }

        },
        clckRangoCaja() {

        },
        clckDia() {
            if (this.idUsuarioPadre != null && this.day != null) {
                this.recuperarDiaConUsuarioTotal();
                this.recuperarDiaConUsuarioDetalle();
                
                this.reporteActual = {
                    'accion': "diaConUsuario",
                    'idUsuario': this.idUsuarioPadre.idUsuario,
                    'fecha': this.day,
                }
                 
            } else {
                this.mensajeAdvertencia("Seleccione un usuario y/o día");
                this.reporteActual = {};
            }
        },
        clckRangoDia() {

        },
        clckMes() {

        },
        clckRangoMes() {

        },
        /*
        +------------------------------------------------+
        |   DETALLE
        +------------------------------------------------+
        */
        recuperarCajaSinUsuario() {


        },
        recuperarCajaConUsuario() {


        },
        recuperarDiaConUsuarioDetalle() {
            var env = {};
            env.idUsuario = this.idUsuarioPadre.idUsuario;
            env.fecha = this.day;

            let uri = this.ip + "ConstanciaPago_diaUsuarioDetalle";

            this.axios
                .post(uri, env)
                .then(response => {
                    this.cobros = response.data;
                    //this.println(response.data);
                })
                .catch(error => {
                    this.mensajeError("Error al realizar la consulta");
                });
        },
        /*
        +------------------------------------------------+
        |   TOTAL
        +------------------------------------------------+
        */

        recuperarDiaConUsuarioTotal() {

            var env = {};
            env.idUsuario = this.idUsuarioPadre.idUsuario;
            env.fecha = this.day;


            let uri = this.ip + "ConstanciaPago_diaUsuarioTotal";

            this.axios
                .post(uri, env)
                .then(response => {
                    //this.println(response.data);
                    this.mostrarTotal = parseFloat(response.data[0].total);
                    this.mostrarSubTotal = parseFloat(response.data[0].subTotal);
                    this.mostrarPropina = parseFloat(response.data[0].propina);
                    this.mostrarMesero = this.idUsuarioPadre.nombre;   
                    
                })
                .catch(error => {
                    this.mensajeError("Error al realizar la consulta");
                });
        },

        /*
        +------------------------------------------------+
        |   PRINT
        +------------------------------------------------+
        */

        printFecha() {
            this.println(this.reporteActual);
            if (this.reporteActual.accion == "diaConUsuario") {
                let uri = this.ip + "Imprimir_reporteDiaConUsuarios";
                this.axios
                    .post(uri, this.reporteActual)
                    .then(response => {
                        
                        this.println(response.data);
                    })
                    .catch(error => {
                        this.mensajeError("Error al realizar la consulta");
                    });
            }
        },
        printPropina() {
            if (this.reporteActual == "diaConUsuario") {

            }
        },
        printCajaMesero() {
            if (this.reporteActual == "diaConUsuario") {

            }
        },
    }
};