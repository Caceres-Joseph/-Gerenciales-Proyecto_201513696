<template>
    <v-container fluid>
        <v-layout row wrap>
            <v-flex xs12>
                <v-btn-toggle dark mandatory v-model="toggle_exclusive">
                    <v-btn :ripple="false" color="orange darken-4" depressed large
                           to="/cobrar/caja/caja_operacion/abrir_caja">Abrir Caja
                    </v-btn>
                    <v-btn :ripple="false" color="orange darken-4" depressed large
                           to="/cobrar/caja/caja_operacion/cerrar_caja">Cerrar Caja
                    </v-btn>
                </v-btn-toggle>
            </v-flex>
        </v-layout>

        <router-view>
        </router-view>
        <v-snackbar
                :color="snackColor"
                :timeout=3000
                button
                v-model="snackStatus"
        >
            {{ sanckText }}
            <!-- <v-btn    @click.native="snackStatus = false">Cerrar</v-btn> -->
            <div>
                <v-btn :color="snackColor" @click.native="snackStatus = false" dark depressed small>Cerrar</v-btn>
            </div>
        </v-snackbar>
    </v-container>
</template>
<script src="./caja.js">