<template>
    <v-container fluid>

        <v-card color="grey lighten-3">
            <v-card-text>


                <span class="headline">Indique el Id de la Caja</span>
                <v-text-field
                        autofocus
                        box
                        placeholder="Id de Caja"
                        v-model="txtIdCaja"
                ></v-text-field>


            </v-card-text>
            <v-card-actions>
                <v-btn
                        color="indigo darken-3"
                        @click.native="clckEnviar"
                        dark
                        depressed
                        :disabled="!estadoBoton"
                        large>
                    Enviar Correo
                </v-btn>
            </v-card-actions>
        </v-card>
        <v-snackbar
                :color="snackColor"
                :timeout=3000
                button
                v-model="snackStatus"
        >
            {{ sanckText }}
            <div>
                <v-btn :color="snackColor" @click.native="snackStatus = false" dark depressed small>Cerrar</v-btn>
            </div>
        </v-snackbar>
    </v-container>
</template>
<script src="./correo.js"/>