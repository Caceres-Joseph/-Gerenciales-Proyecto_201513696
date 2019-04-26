<template>
  <v-container fluid>


     <v-card color="grey lighten-3">
 
    <!-- Filtro  --> 
        <v-card-title>
        <!-- <span class=" headline black--text hidden-xs-only">Abonos</span><br> -->
        
        <v-layout row wrap>
            <v-flex xs12 md3>
              <v-btn large flat icon color="primary" @click="clckImprimir" >
                <v-icon large>print</v-icon>
              </v-btn>
            </v-flex>
            <v-flex xs12 md5 >
                <span class="title text-xs-left ">Total Q{{(this.totalAbono).toFixed(2)}}</span> 
            </v-flex>
              <v-spacer></v-spacer>
              <v-flex xs12 md4>
                <v-text-field
                    append-icon="search"
                    label="Buscar"
                    single-line
                    hide-details
                    v-model="search"
                ></v-text-field>
              </v-flex>          
        </v-layout>

        </v-card-title>
        
        <!-- Tabla  --> 
        <v-data-table
        :headers="headers"
        :items="abonos" 
        class="elevation-1"
        :search="search"
        :disable-initial-sort="true"
        >
        <template slot="items" slot-scope="props">
            <td class="text-xs-left">{{ props.item.nombre }}</td> 
            <td class="text-xs-right">{{ props.item.monto }}</td> 
            <td class="text-xs-left">{{ props.item.observacion }}</td> 
        </template>
        <template slot="no-data">
            <span>No hay datos</span>
        </template>
        </v-data-table>
     </v-card>

<!-- Snackbar -->
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
<script src ="./detalle_abono.js">