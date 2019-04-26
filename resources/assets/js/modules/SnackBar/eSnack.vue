<template>
    <div class="eSnack">

        <!-- Snackbar -->
        <v-snackbar
                :timeout=3000
                button
                v-model="snackStatus"
                :color="snackColor">

            {{sanckText}}
            <div>
                <v-btn
                        depressed
                        small
                        dark
                        :color="snackColor"
                        @click.native="snackStatus = false">Cerrar</v-btn>
            </div>
        </v-snackbar>
    </div>
</template>

<script>
    export default {
        name: 'eSnack',
        data: () => ({
            snackColor: "teal darken-4",
            snackStatus: false,
            sanckText: ""
        }),

        methods: {
            onEnlargeText: function(mensaje){
                this.snackColor = "red";
                this.sanckText = "[Error] " + mensaje;
                this.snackStatus = true;
            },
            /*
             *Mensajes medida
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
        }
    };
</script>
