<template>
  <v-container fluid>


     <v-card color="grey lighten-3">
 
    <!-- Filtro  --> 
        <v-card-title>
            <v-layout row wrap>
              <v-flex xs12 md4  >
                <v-layout row wrap>
                    <v-flex  xs6>
                       <span class="subheading"  >Efectivo: Q</span> 
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex xs6 class="text-xs-right">
                        <span class="subheading" >{{(this.totalEfectivo).toFixed(2)}} </span>
                    </v-flex>
                    
                    <v-flex  xs6>
                       <span class="subheading"  >Tarjeta: Q </span> 
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex xs6 class="text-xs-right">
                        <span class="subheading" >{{(this.totalTarjeta).toFixed(2)}} </span>
                    </v-flex>

                    <v-flex  xs6>
                       <span class="subheading"  >Total: Q </span> 
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex xs6 class="text-xs-right">
                        <span class="subheading" >{{(this.totalTotal).toFixed(2)}}</span>
                    </v-flex>

                </v-layout>
                <!-- <span class="title">Efectivo Q{{this.totalEfectivo}}</span><br>
                <span class="title">Tarjeta  Q{{this.totalTarjeta}}</span><br>
                <span class="title">Total    Q{{this.totalTotal}}</span> -->
              </v-flex>
              <v-spacer></v-spacer>
              <v-flex xs12 md4>
                  <v-layout row wrap>
                    <v-flex xs12>
                        <v-btn large flat icon color="primary" @click="clckImprimir" >
                            <v-icon large>print</v-icon>
                        </v-btn>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field
                            append-icon="search"
                            label="Buscar"
                            single-line
                            hide-details
                            v-model="search"
                        ></v-text-field>
                    </v-flex>
                  </v-layout>

              </v-flex>

            </v-layout>
        <!-- <span class=" headline black--text hidden-xs-only">Abonos</span><br> -->

        </v-card-title>
    <!-- Tabla  --> 
        <v-data-table
        :headers="headers"
        :items="ventas" 
        class="elevation-1"
        :search="search"
        :disable-initial-sort="true"
        >
        <template slot="items" slot-scope="props">
            <td class="text-xs-left">{{ props.item.idOrden }}</td> 
            <td class="text-xs-right">{{ props.item.subTotal }}</td> 
            <td class="text-xs-right">{{ props.item.propina }}</td>
            <td class="text-xs-right">{{ props.item.total }}</td>
            <td class="text-xs-right">{{ props.item.efectivo }}</td>
            <td class="text-xs-right">{{ props.item.tarjeta }}</td> 
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
<script src ="./detalle_ventas.js">