<template>
  <v-container fluid>
  
    <v-card color="grey lighten-3">
      <v-card-title>
        <v-layout row wrap> 
            <v-flex xs12>
                <span class="headline">Stock Actual de Barra</span> 
            </v-flex>
        </v-layout>
      </v-card-title>

        <v-card-text>
            <v-layout row wrap>  
    
                <v-flex xs12>
                <v-card color="orange darken-3">
                    <v-card-text>
                        <v-layout row wrap> 
                            
                            <v-flex xs12 md5>
                                <v-btn dark  large   depressed :ripple="false" color="orange darken-4" @click="imprimir"><v-icon>print</v-icon> Imprimir</v-btn>
                            </v-flex>
                        </v-layout>
                    </v-card-text>
                </v-card>
                </v-flex>
                <v-flex xs12>
                    <v-data-table
                    :headers="headers"
                    :items="ventas" 
                    class="elevation-1"
                    :search="search"
                    :disable-initial-sort="true"
                    >
                    <template slot="items" slot-scope="props"> 
                        <!-- <td class="text-xs-left">{{ props.item.idArticulo }}</td>  -->
                        <td class="text-xs-left">{{ props.item.nombre }}</td>
                        <!-- <td class="text-xs-left"> {{ props.item.stockBodega }}</td> -->
                        <td class="text-xs-left"> {{ props.item.stockBarra }}</td> 
                        <!-- <td class="text-xs-left"> {{ props.item.stockCocina }}</td> 
                        <td class="text-xs-left"> {{ props.item.total }}</td>   -->
                    </template>
                    <template slot="no-data">
                        No hay datos que mostrar
                    </template>
                    </v-data-table>               
                </v-flex>  
            </v-layout> 
        </v-card-text> 
    </v-card> 
        <v-snackbar 
        :timeout=3000
        button   
        v-model="snackStatus"
        :color= "snackColor"
        >
        {{ sanckText }} 
        <div>
            <v-btn  depressed small  dark :color="snackColor" @click.native="snackStatus = false" >Cerrar</v-btn>
        </div>
    </v-snackbar> 
  </v-container>
</template>
<script src ="./dia_devolucionBarra.js">