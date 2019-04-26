export default {
    props: ['ip'],
    data() {
        return {
            /* SnackBar */
            snackColor: "teal darken-4",
            snackStatus: false,
            sanckText: " ",


            /* Dia */
            day: null,
            menu: false,


            /* TABLA */

            headers: [
                {
                    text: "Id Inventario",
                    value: "idInventario",
                },
                {
                    text: "Usuario",
                    value: "nombre",
                }, 
                {
                    text: "Fecha/Hora ",
                    value: "fecha",
                },
              
                {
                  text: "Acciones",
                  sortable: false
                } 

            ],
            ventas: [],

            search: "",

            /* MOSTRAR */
            mostrar: {
                fecha: "",
                efectivo: 0.0,
                tarjeta: 0.0,
                total: 0.0,
            },
        };
    },
    computed: {

    },
    created() {
        this.inicializar();
    },
    methods: {
        inicializar() {
            let uri = this.ip + "inventario_items";
            var ele;
            this.axios.get(uri).then(response => {
                //this.println(response.data); 
                this.ventas = response.data; 
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
        },

        

        /*
        +------------------------------------------------+
        |   Click
        +------------------------------------------------+
        */

        clckAceptar() {

            

            
        },
        clckVer(item) {
            this.$router.push({
                name: "inventario_detalle",
                params: { id: item.idInventario, usuario:item.nombre,fecha:item.fecha}
              }); 
        },
        /*
        +------------------------------------------------+
        |   IMPRIMIR
        +------------------------------------------------+
        */

        imprimir() {
           
            

            let uri = this.ip + "Imprimir_DiaOrdenCortesia";
            var ele;
            this.axios.post(uri, enviar).then(response => {
                
            }).catch(error => {
                this.mensajeError("Error al realizar la consulta");
            });
        },

        /*
        +------------------------------------------------+
        |   MENSAJES
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

    }
};