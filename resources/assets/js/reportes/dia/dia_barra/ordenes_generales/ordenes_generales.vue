<template>
  <v-container fluid>
  
    <v-card color="grey lighten-3">
      <v-card-title>
        <v-layout row wrap> 
            <v-flex xs12>
                <span class="headline">Articulos Servidos de Barra</span> 
            </v-flex>
        </v-layout>
      </v-card-title>
        <v-card-text>
            <v-layout row wrap> 
                <v-flex xs12 > 
                    <v-card color="white">  
                        <v-menu
                            ref="menu"
                            :close-on-content-click="false"
                            v-model="menu"
                            :nudge-right="40"
                            :return-value.sync="day"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            min-width="290px"
                        >
                            <v-text-field
                            slot="activator"
                            v-model="day"
                            label="Fecha"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="day" no-title scrollable>
                            <v-spacer></v-spacer>
                            <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                            <v-btn flat color="primary" @click="$refs.menu.save(day)">OK</v-btn>
                            </v-date-picker>
                        </v-menu> 
                    </v-card>
                </v-flex>   
    
                <v-flex xs12>
                <v-card color="orange darken-3">
                    <v-card-text>
                        <v-layout row wrap> 
                            <!-- <v-flex xs12 md4>
                                <v-card dark flat color="red darken-4">
                                <v-card-text>
                                    <v-layout row wrap>  
                                        <v-flex  xs12>
                                        <span class="subheading"  >{{this.mostrar.fecha}} </span> 
                                        </v-flex> 
                                        <v-flex  xs6>
                                        <span class="subheading"  > Num. de Articulos: </span> 
                                        </v-flex>
                                        <v-spacer></v-spacer>
                                        <v-flex xs6 class="text-xs-right">
                                        <span class="title" >{{ this.ventas.length }} </span>
                                        </v-flex>
                                    </v-layout>                            
                                </v-card-text>
                                </v-card>
                            </v-flex>  -->
                            <v-flex xs12 md5>
                                <v-btn dark  large   depressed :ripple="false" color="orange darken-4" @click="clckAceptar"><v-icon>done</v-icon> Aceptar</v-btn>
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
                         
                        <td class="text-xs-left">{{ props.item.numVentas }}</td>
                        <td class="text-xs-left">{{ props.item.nombreArticulo }}</td> 
                        <td class="justify-center layout px-0">  
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
<script src ="./ordenes_generales.js">