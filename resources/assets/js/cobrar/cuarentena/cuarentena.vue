<template>
  <v-container fluid>
  
    <v-card color="grey lighten-3">
      <v-card-title>
        <v-layout row wrap> 
            <v-flex xs12>
                <span class="headline">Ordenes en cuarentena</span> 
            </v-flex>
        </v-layout>
      </v-card-title>
        <v-card-text>
            <v-layout row wrap>  
                <v-flex xs12>
                    <v-data-table
                    :headers="headers"
                    :items="listado" 
                    class="elevation-1"
                    :search="search"
                    :disable-initial-sort="true"
                    >
                    <template slot="items" slot-scope="props">

                        <td class="text-xs-left">{{ props.item.idCuarentena }}</td>  
                        <td class="text-xs-left">{{ props.item.idCaja }}</td> 
                        <td class="text-xs-left">{{ props.item.cajero }}</td>
                        <td class="text-xs-left">{{ props.item.mesero }}</td>
                        <td class="text-xs-left"> {{ props.item.idOrden }}</td>
                        <td class="text-xs-left"> {{ props.item.observacion }}</td>
                        <td class="text-xs-left"> {{ props.item.fecha_hora }}</td>
                        
                        <td class="justify-center layout px-0"> 
                            <v-btn icon class="mx-0" @click="accVerItem(props.item)">
                                <v-icon >remove_red_eye</v-icon>
                            </v-btn> 
                        </td>
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
<script src ="./cuarentena.js">