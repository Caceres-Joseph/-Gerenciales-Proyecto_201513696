import getDefaultData from './usuario_nuevoD';

import eTiempo from "../../modules/Tiempo/eTiempo.vue";

export default {
    props: ['ip', 'buscarGlobal', 'colorDefecto'] ,


    components: {
        eTiempo
    },

    data: getDefaultData,
    created() {
        this.inicializar();
    },

    updated(){
        //this.$refs.tiempo.mHoras="08";
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

            let uri2 = "/sueldo_getTrabajadores";
            this.axios.get(uri2).then(response => {
                this.personas = response.data;
            });
            window.scrollTo(0, 0);

        },

        /*
        |--------------------------------------------------------------------------
        | Botones
        |--------------------------------------------------------------------------
        */
        clckCancelar() {
            this.$router.push({
                name: "sueldo"
            });
        },
        clckAceptar() {


            if (this.itemEnviar.idPersona==null) {
                this.$emit("mensajeAdvertencia", "Debe seleccionar una persona");
                return;
            }

            /* if(this.itemEnviar.sueldoHora==""||this.itemEnviar.sueldoExtra==""){
                this.$emit("mensajeAdvertencia", "Debe indicar el sueldo de las horas y/o el sueldo de horas extras");
                return;
            } */



            let uri = "/sueldo_insertar";
            this.axios
                .post(uri, this.itemEnviar)
                .then(response => {



                    this.$log.info(response.data);

                    this.$emit("mensajeInfo", "Nuevo Usuario creado exitosamente");
                    Object.assign(this.$data, getDefaultData());
                    this.inicializar();
                })
                .catch(error => {
                    this.$emit("mensajeError", "No se logró establecer conexión con el sensor biométrico(reloj)");
                });
        },

        clckCalcular(){


            this.itemEnviar.horasAlDia=parseFloat(this.$refs.tiempo.mHoras)+
                (parseFloat(this.$refs.tiempo.mMinutos)/60);


            this.item.sueldoDia=(parseFloat(this.item2.sueldo.replace(",",""))/parseFloat(this.item2.dia)).toFixed(2);
            this.item.sueldoHora=(this.item.sueldoDia/(this.itemEnviar.horasAlDia)).toFixed(2);


            this.itemEnviar.sueldoHora=this.item.sueldoHora;
            this.item2.sueldoDia=this.item.sueldoDia;
        },

        /*
        |--------------------------------------------------------------------------
        | ComboBox
        |--------------------------------------------------------------------------
        */

        cbCambioNuevoUsuario(item2) {
            if(item2==null){
                return ;
            }

            if (item2.idPersona == parseInt(item2.idPersona, 10)) {
                this.itemEnviar.idPersona = item2.idPersona;
                this.itemEnviar.nombre = item2.nombre;
                this.generarContrasenia();
            }
        },


        focoInicio() {
            setTimeout(() => {
                this.focoPersona();
            }, 500);
        },

        focoPersona(){

            this.$nextTick(() => {
                this.$refs.fPersona.clearableCallback();
            });
        },

        generarContrasenia(){

            this.itemEnviar.password = Math.floor(1000 + Math.random() * 9000);
        }

    }
};


