<template>
  <v-container fluid>
  
    <v-card color="grey lighten-4">
      <v-card-title>
        <v-layout row wrap> 
            <v-flex xs12>
                <span class="headline">Orden # {{this.$route.params.id }}</span> 
            </v-flex>
        </v-layout>
      </v-card-title>
        <v-card-text>
            <v-layout row wrap>    
                <v-flex xs12>
                <v-card color="green darken-4" flat>
                    <v-card-text>
                        <v-layout row wrap>  
            <!--        
              |- - - - - - - - - - - - 
              | CUENTA
              |- - - - - - - - - - - - 
            -->   
                            <v-flex xs12 md4>
                                <v-card dark flat color="light-green darken-4">
                                <v-card-text>
                                    <v-layout row wrap> 
                                        <!-- <v-flex xs12 class="text-xs-center">
                                            <span class="subheading"  > Orden #{{this.$route.params.id }}</span> 
                                        </v-flex>
                                        <v-flex  xs6>
                                        <span class="subheading"  > Lugar: </span> 
                                        </v-flex>
                                        <v-spacer></v-spacer> -->
                                        <v-flex  xs6>
                                        <span class="subheading"  > SubTotal: </span> 
                                        </v-flex>
                                        <v-spacer></v-spacer>
                                        <v-flex xs6 class="text-xs-right">
                                        <span class="subheading" >Q {{this.detalleOrden.subTotal}} </span>
                                        </v-flex>
                                        <v-flex  xs6>
                                        <span class="subheading"  >Propina 10%: </span> 
                                        </v-flex>
                                        <v-spacer></v-spacer>
                                        <v-flex xs6 class="text-xs-right">
                                        <span class="subheading" >Q {{this.detalleOrden.propina}} </span>
                                        </v-flex>
                                        <v-flex xs12 class="text-xs-right" >
                                        <span class="subheading"  >---------------------</span> 
                                        </v-flex>
                                        <v-flex  xs6>
                                        <span class="subheading"  > Total: </span> 
                                        </v-flex>
                                        <v-spacer></v-spacer>
                                        <v-flex xs6 class="text-xs-right">
                                        <span class="subheading" >Q {{this.detalleOrden.total}} </span>
                                        </v-flex>
                                    </v-layout>                            
                                </v-card-text>
                                </v-card>
                            </v-flex> 

 
                             <v-flex xs12 md4 class="text-xs-center" >
                                <v-btn    large     depressed :ripple="false" color="blue-grey lighten-4" @click="clckImprimir"><v-icon>print</v-icon>Imprimir</v-btn>
                                <!-- <v-btn    large  dark  depressed :ripple="false" color="blue-grey darken-1" @click="clckRecuperar"><v-icon>done</v-icon> Recuperar </v-btn> -->
                               
                            </v-flex>
            <!--        
              |- - - - - - - - - - - - 
              | CUENTA
              |- - - - - - - - - - - - 
            -->             <v-spacer></v-spacer>
            
                            <v-flex xs12 md4>
                                <v-card dark flat color="light-green darken-4">
                                <v-card-text>
                                    <v-layout row wrap> 
                                        <v-flex xs12 class="text-xs-left">
                                        <span class="subheading"  > {{this.detalleOrden.nombreUsuario}}</span> 
                                        </v-flex>
                                        <v-flex xs12 class="text-xs-left">
                                        <span class="subheading"  > {{this.detalleOrden.nombreLugar}}</span> 
                                        </v-flex>
                                        <v-flex xs12 class="text-xs-left">
                                        <span class="subheading"  > {{this.detalleOrden.nombreMesa}}</span> 
                                        </v-flex>
                                        <v-flex xs12 class="text-xs-left">
                                        <span class="subheading"  > {{this.detalleOrden.fechaHora}}</span> 
                                        </v-flex> 
                                    </v-layout>                            
                                </v-card-text>
                                </v-card>
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
                    <v-card color="yellow accent-4" height="12">
                        
                    </v-card> 
                </v-flex>


                <v-flex xs12>
                    <v-data-table
                    :headers="headers"
                    :items="listado" 
                    class="elevation-1"
                    :search="search"
                    :disable-initial-sort="true"
                    >
                    <template slot="items" slot-scope="props">
                         
                        <td class="text-xs-left">{{ props.item.cantidad }}</td> 
                        <td class="text-xs-left">{{ props.item.nombreArticulo }}</td>
                     
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
<script src ="./detalleOrden.js"/>