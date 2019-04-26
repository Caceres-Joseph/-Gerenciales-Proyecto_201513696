<template>
  <v-container fluid>
  <v-layout row wrap>
                <v-flex xs12>
                <v-btn-toggle dark v-model="toggle_exclusive" mandatory >
                    <v-btn  :ripple="false" large  depressed color="teal darken-4" to="/cobrar/caja/opciones/">Opciones</v-btn>
                    <v-btn  :ripple="false" large depressed color="teal darken-4" to="/cobrar/caja/detalles/">Detalles</v-btn>
                    <v-btn  :ripple="false" large depressed color="teal darken-4" to="/cobrar/caja/caja_operacion/">Caja</v-btn>
                </v-btn-toggle> 
            </v-flex>
  </v-layout>
        <router-view> 
        </router-view> 
    <v-snackbar 
        :timeout=3000
        button   
        v-model="snackStatus"
        :color= "snackColor"
        >
        {{ sanckText }}
        <!-- <v-btn    @click.native="snackStatus = false">Cerrar</v-btn> -->
        <div>
            <v-btn  depressed small  dark :color="snackColor" @click.native="snackStatus = false" >Cerrar</v-btn>
        </div>
    </v-snackbar> 
 
  </v-container>
</template>
<script src ="./caja.js"/>