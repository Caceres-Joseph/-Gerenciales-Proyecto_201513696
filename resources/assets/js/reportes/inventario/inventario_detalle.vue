<template>
  <v-container fluid >
      <!-- grid-list-md -->   
    <v-card color="grey lighten-3"> 
            <v-card-title primary-title> 
                <v-layout row wrap> 
                    <v-flex xs12>
                        <span class="headline">Detalle Inventario</span> 
                    </v-flex>
                </v-layout>
            </v-card-title>

        <v-card-text>
            <v-layout row wrap>  
                <v-flex xs12>
                <v-card color="green darken-4" flat>
                    <v-card-text>
                        <v-layout row wrap> 
                            <v-flex xs12 md4>
                                <v-card dark flat color="green darken-4">
                                <v-card-text>
                                    <v-layout row wrap> 
            <!--        
              |- - - - - - - - - - - - 
              | CUENTA
              |- - - - - - - - - - - - 
            -->   
                                        <v-flex  xs6>
                                        <span class="subheading"  > Id Inventario: </span> 
                                        </v-flex>
                                        <v-spacer></v-spacer>
                                        <v-flex xs6 class="text-xs-right">
                                        <span class="subheading" >{{this.$route.params.id }} </span>
                                        </v-flex>
                                        <v-flex  xs6>
                                        <span class="subheading"  > Usuario: </span> 
                                        </v-flex>
                                        <v-spacer></v-spacer>
                                        <v-flex xs6 class="text-xs-right">
                                        <span class="subheading" >{{ this.$route.params.usuario }} </span>
                                        </v-flex>
                                        <v-flex  xs6>
                                        <span class="subheading"  > Fecha: </span> 
                                        </v-flex>
                                        <v-spacer></v-spacer>
                                        <v-flex xs6 class="text-xs-right">
                                        <span class="subheading" >{{ this.$route.params.fecha }} </span>
                                        </v-flex> 
                                    </v-layout>                            
                                </v-card-text>
                                </v-card>
                            </v-flex> 

                            <v-flex xs12 md4>
                                 <v-btn dark  large   depressed :ripple="false" color="green darken-3" @click="imprimir"><v-icon>print</v-icon> Imprimir</v-btn>
                            </v-flex>
                            
                            <!-- <v-flex xs12 md5>
                                <v-btn dark  large   depressed :ripple="false" color="orange darken-4" @click="clckAceptar"><v-icon>done</v-icon> Aceptar</v-btn>
                                <v-btn dark  large   depressed :ripple="false" color="orange darken-4" @click="imprimir"><v-icon>print</v-icon> Imprimir</v-btn>
                            </v-flex> -->
                        </v-layout>
                    </v-card-text>
                </v-card>
                </v-flex>
                <v-flex xs12 flat>
                    <v-card color="yellow accent-4" height="10"> 
                    </v-card> 
                </v-flex>
            <!--        
              |- - - - - - - - - - - - 
              | CUENTA
              |- - - - - - - - - - - - 
            -->   
                <v-flex xs12>
                    <v-data-table
                    :headers="headers"
                    :items="ventas" 
                    class="elevation-1"
                    :search="search"
                    :disable-initial-sort="true"
                    >
                    <template slot="items" slot-scope="props">
                         
                    <td class="text-xs-left">{{ props.item.idArticulo }}</td> 
                    <td class="text-xs-left">{{ props.item.nombre }}</td> 
                    <td class="text-xs-left">{{improperFractionToMixedNumber(props.item.stockSistema_numerador,props.item.stockSistema_denominador)}}</td> 
                     

                    <td   class="text-xs-center">{{ improperFractionToMixedNumber(props.item.stockFisico_numerador, props.item.stockFisico_denominador) }}</td>
 
                    <td class="text-xs-left">{{ substractFrac(props.item)}}</td> 
                    
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
<script src ="./inventario_detalle.js">