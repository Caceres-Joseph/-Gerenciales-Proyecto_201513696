<template>


    <ingreso
            :color="colorDefecto"
            :productos="fProductos"
            :proveedores1="fProveedores"
    ></ingreso>


</template>

<script>
    import ingreso from '../../modules/Ingreso/eIngreso.vue'
    import mensajes from '../../modules/SnackBar/mensajes.js'

    export default {
        props: {
            colorDefecto: String
        },

        mixins: [mensajes],

        components: {
            ingreso
        },

        data: () => ({

            fProductos:[],
            fProveedores:[]

        }),

        created() {
            this.inicializar();
        },

        methods: {

            /*
            |-------------------------
            | Inicio
            |-------------------------
            */
            inicializar() {

                window.scrollTo(0, 0);
                this.cargarProductos();
                this.cargarProveedores();
            },

            /*
            +------------------------------------------------+
            |   Cargando los combos
            +------------------------------------------------+
            */

            cargarProductos() {
                let uri = "/uUtensilio_getItems";
                this.axios.get(uri).then(response => {
                    this.fProductos=response.data;
                    //this.println(response.data);
                });
            },
            cargarProveedores() {
                let uri = "/Persona_proveedores";
                this.axios.get(uri).then(response => {
                    this.fProveedores=response.data;
                    //this.$log.info(response.data);
                });
            },

        }
    }
</script>