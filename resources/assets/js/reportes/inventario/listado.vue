<template>
  <v-container fluid>
  
    <v-card color="grey lighten-3"> 
      <v-card-title>
        <v-layout row wrap> 
            <v-flex xs12>
                <span class="headline">Listado de Inventarios elaborados</span> 
            </v-flex>
        </v-layout>
      </v-card-title>

      <v-card-title primary-title>
        <v-text-field
        
            prepend-icon="search"
            label="Buscar"
            single-line
            hide-details
            v-model="search"
            solo-inverted
            flat
        ></v-text-field>
        <v-spacer></v-spacer>
      </v-card-title>
 
        <v-card-text> 
        </v-card-text> 
            <v-layout row wrap>      
                <v-flex xs12>
                    <v-data-table
                    :headers="headers"
                    :items="ventas" 
                    class="elevation-1"
                    :search="search"
                    :disable-initial-sort="true"
                    >
                    <template slot="items" slot-scope="props"> 
                        <td class="text-xs-left">{{ props.item.idInventario }}</td> 
                        <td class="text-xs-left">{{ props.item.nombre }}</td>
                        <td class="text-xs-left"> {{ props.item.fecha }}</td>
                      <!--   <td class="text-xs-left"> {{ props.item.numComprobante }}</td> 
                        <td class="text-xs-left"> {{ props.item.proveedor }}</td> 
                        <td class="text-xs-left"> {{ props.item.usuario }}</td> 
                        <td class="text-xs-left"> {{ props.item.total }}</td>  
                        -->
                        <td class="justify-center layout px-0"> 
                            <v-btn icon class="mx-0" @click="clckVer(props.item)">
                            <v-icon  color="grey darken-3">remove_red_eye</v-icon>
                            </v-btn> 
                        </td>  
                    </template>
                    <template slot="no-data">
                        No hay datos que mostrar
                    </template>
                    </v-data-table>               
                </v-flex>  
            </v-layout>
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
<script src ="./listado.js">