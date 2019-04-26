<template>
  <v-container fluid>
                <v-btn-toggle dark v-model="toggle_exclusive" mandatory >
                     <v-btn  :ripple="false" large  depressed color="orange darken-4" to="/cobrar/caja/detalles/detalle_abono">Abonos  </v-btn>
                    <v-btn  :ripple="false" large  depressed color="orange darken-4" to="/cobrar/caja/detalles/detalle_gasto/">Gastos</v-btn>
                      <v-btn  :ripple="false" large  depressed color="orange darken-4" to="/cobrar/caja/detalles/detalle_venta">Ventas</v-btn>
                   
                </v-btn-toggle> 
  <v-layout row wrap>
                <v-flex xs12>

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
<script src ="./detalles.js"/>