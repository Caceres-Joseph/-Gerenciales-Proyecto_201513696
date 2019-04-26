export default {
    props: ['ip'],
    data() {
        return {
            /* SnackBar */
            snackColor: "teal darken-4",
            snackStatus: false,
            sanckText: " ",


            /* ITEMS */
            item: {},

            /* Fecha */
            date: null,
            menu: false,
            modal: false,
            menu2: false,

            /* Fecha2 */
            date2: null,

            /* Boton Acepta */
            boolBtnAceptar: false,

            dialogNuevo: false,


            /* Boton Acepta */
            ticket_tVentas: 0.0,
            ticket_tCajaInicial: 0.0,
            ticket_tAbono: 0.0,
            ticket_tTarjeta: 0.0,
            ticket_tGastos: 0.0,
            ticket_tEfectivoActual: 0.0,
            ticket_tDiferencia: 0.0,
            ticket_tPrimerSuma: 0.0,
            ticket_tSegundaSuma: 0.0,
            ticket_tEfectivoAdejar: "",
            ticket_tObservacion: "",
            ticket_tIdCaja: "",
            ticket_tFecha: "",
            ticket_tHora: "",
            ticket_tEncargado: ""


        };
    },
    computed: {},
    created() {
        this.inicializar();
    },
    methods: {
        inicializar() {
            let uri = this.ip + "Caja_obtenerUltimaCajaAbierta/";

            this.axios
                .get(uri)
                .then(response => {
                    if (response.data == 0) {

                        //hay que verificar que no hay ordenes pendientes

                        this.boolBtnAceptar = true;

                    } else {
                        this.boolBtnAceptar = false;
                    }
                    this.$log.info(response.data);

                })
                .catch(error => {
                    this.$log.info(error);
                });
        },

        /*
        +------------------------------------------------+
        |   CLICK
        +------------------------------------------------+
        */
        clckAceptar() {
            this.cargarTicket();

            /*       let uri = this.ip + "Caja_abrirCaja/";

                  this.axios
                    .post(uri, this.item)
                    .then(response => {
                     this.$router.push({
                        name: "caja"
                      });
                      this.mensajeInfo("Caja Abierta Exitosamente");
                      //lo redirecciono

                    })
                    .catch(error => {
                      this.mensajeError("Error al abrir la caja");
                      this.$log.info(error);
                    }); */
        },
        clckImprimir() {

            //this.$log.info(this.ticket);
            //
            let uri = this.ip + "Imprimir_CierreCaja";
            this.axios
                .post(uri, this.ReturnTicket())
                .then(response => {

                    this.mensajeInfo("Imprimiendo");
                    //lo redirecciono
                })
                .catch(error => {
                    this.mensajeError("Error al imprimir");
                    this.$log.info(error);
                });
            this.dialogNuevo = false;
        },

        clckAceptarCierre() {

          var ticket = this.ReturnTicket();
          let uri = this.ip + "Caja_cerrarCaja";
          this.axios
            .post(uri, ticket)
            .then(response => {
              this.mensajeInfo("Cierre de caja exitoso");
              //ahora procedo a enviar el correo
                  let uri2 = this.ip + "Caja_enviarCorreo";
                  this.axios
                    .post(uri2, ticket)
                    .then(response => {
                      this.mensajeInfo(response.data);
                  })
                  .catch(error => {
                    this.mensajeError("Error al enviar el correo del cierre");
                    this.$log.info(error);
                  });
              this.inicializar();
            })
            .catch(error => {
              this.mensajeError("Error al cerrar caja");
              this.$log.info(error);
            });
          this.dialogNuevo = false;
        },


        /*clckAceptarCierre() {

            var ticket = this.ReturnTicket();
            //ahora procedo a enviar el correo
            let uri2 = this.ip + "Caja_enviarCorreo";
            this.axios
                .post(uri2, ticket)
                .then(response => {
                    this.mensajeInfo(response.data);
                })
                .catch(error => {
                    this.mensajeError("Error al enviar el correo del cierre");
                    this.$log.info(error);
                });
            //this.inicializar();

            this.dialogNuevo = false;
        },*/
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
        },

        /*
        +------------------------------------------------+
        |   ticket
        +------------------------------------------------+
        */
        cargarTicket() {


            let uri = this.ip + "Caja_ticketParaCierre"

            this.axios
                .post(uri, this.item)
                .then(response => {

                    this.ticket_tAbono = response.data.abono;
                    this.ticket_tCajaInicial = response.data.cajaInicial;
                    this.ticket_tEncargado = response.data.encargado;
                    this.ticket_tFecha = response.data.fecha;
                    this.ticket_tHora = response.data.hora;
                    this.ticket_tTarjeta = response.data.tarjeta;
                    this.ticket_tVentas = response.data.venta;
                    this.ticket_tEfectivoActual = response.data.efectivoActual;
                    this.ticket_tPrimerSuma = response.data.primerSuma;
                    this.ticket_tSegundaSuma = response.data.segundaSuma;
                    this.ticket_tDiferencia = response.data.diferencia;
                    this.ticket_tGastos = response.data.gasto;
                    this.ticket_tIdCaja = response.data.idCaja;

                    this.dialogNuevo = true;
                    //this.$log.info(this.ticket);

                })
                .catch(error => {
                    this.mensajeError("Error al abrir la caja");
                    this.$log.info(error);
                });

        },
        /*
        +------------------------------------------------+
        |   ticket
        +------------------------------------------------+
        */
        ReturnTicket() {
            var ticket = {
                tVentas: this.ticket_tVentas,
                tCajaInicial: this.ticket_tCajaInicial,
                tAbono: this.ticket_tAbono,
                tTarjeta: this.ticket_tTarjeta,
                tGastos: this.ticket_tGastos,
                tEfectivoActual: this.ticket_tEfectivoActual,
                tDiferencia: this.ticket_tDiferencia,
                tPrimerSuma: this.ticket_tPrimerSuma,
                tSegundaSuma: this.ticket_tSegundaSuma,
                tEfectivoAdejar: this.ticket_tEfectivoAdejar,
                tObservacion: this.ticket_tObservacion,
                tIdCaja: this.ticket_tIdCaja,
                tFecha: this.ticket_tFecha,
                tHora: this.ticket_tHora,
                tEncargado: this.ticket_tEncargado,
            };

            /*

             */
            return ticket;
        }

    }
};