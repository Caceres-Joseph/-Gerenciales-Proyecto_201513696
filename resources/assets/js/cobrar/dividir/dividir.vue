<template>
  <v-layout column> 
 
    <v-card flat color="grey lighten-3"  > 
      <v-card-title>
        <!-- <v-layout row wrap> 
            <v-flex xs12>
                <span class="headline">División de orden</span> 
            </v-flex>
        </v-layout> -->
      </v-card-title>
        <v-container fluid grid-list-md>
          <v-layout row wrap> 
            <!--        
              |- - - - - - - - - - - - 
              | ORDENS
              |- - - - - - - - - - - - 
            -->    
            <v-flex xs12 >
                <v-card color="white" > 
                    <v-layout row wrap>
                        <v-flex xs12 sm4> 
                            <v-checkbox :disabled="!desacCheck"   v-model="checkOrden" hide-details color="blue darken-3" label="Orden" @change="checkBoxOrden"  >
                            </v-checkbox>
                        </v-flex>
                        <v-spacer></v-spacer> 
                        <v-flex xs12 sm8>
                            <v-select :items="dataOrdenesExistentes" item-value="idOrden" :disabled="!checkOrden" item-text="idOrden" autocomplete placeholder="Seleccione" @change="cbCambioOrden">
                            </v-select> 
                        </v-flex>
                    </v-layout>
                </v-card> 
            </v-flex>  

            <!--        
              |- - - - - - - - - - - - 
              | OPCIONES
              |- - - - - - - - - - - - 
            -->    
                <v-flex xs12>
                  <v-card color="teal darken-4">
                      <v-card-actions>
                        
                     
                          <v-layout row wrap>  
                              <v-flex xs12 md6>
                                  <v-btn dark  large   depressed :ripple="false" color="teal darken-3" @click="clckAceptar"><v-icon>done</v-icon> Aceptar</v-btn> 
                              </v-flex>
                              <v-flex xs12 md6>
                                  <v-btn dark  large   depressed :ripple="false" color="teal darken-3" @click="clckCancelar"> Cancelar</v-btn> 
                              </v-flex>
                          </v-layout>
                      </v-card-actions>
                  </v-card> 
                </v-flex>
            <!--        
              |- - - - - - - - - - - - 
              | TABLA 1
              |- - - - - - - - - - - - 
            -->   
            <v-flex xs12 sm6>
              <v-card dark color="orange darken-4">
                 <v-card-text>
                  <span class="title">Orden #{{this.$route.params.id}}</span> 
                  <br>
                  <span class="title">Nivel:{{this.actualMesa}}</span> 
                  <br>
                  <span class="title">Mesa:{{this.actualNivel}}</span> 
                 </v-card-text>
               </v-card>
              <v-data-table
                :headers="headerTabla" 
                class="elevation-1" 
                :disable-initial-sort="true"
                :items="dataTable1" 
                hide-actions
              >
                <template slot="items" slot-scope="props">
                  <td class="body-2 text-xs-left">{{ props.item.nombre }}</td> 
                  <!-- <td class="text-xs-left">{{ props.item.producto }}</td> --> 
                  <td class="justify-center layout px-0">  
                    <v-btn depressed :ripple="false" large  flat class="mx-0" @click="clckMovDerecha(props.item)" >
                      <v-icon large color="light-blue darken-4" >chevron_right</v-icon>
                    </v-btn>  
                  </td>
                </template>  
                <template slot="no-data">
                  No hay datos
                </template>
              </v-data-table>  
            </v-flex>
            <!--        
              |- - - - - - - - - - - - 
              | TABLA 2
              |- - - - - - - - - - - - 
            -->   
             <v-flex xs12 sm6>
               <v-card dark color="orange darken-4">
                 <v-card-text>
                  <span v-if="this.idOrdenPadre==null" class="title">Nueva Orden</span> 
                 <div v-else>
                 <span  class="title" >Orden #{{this.idOrdenPadre}}</span>
                 <br>
                  <span class="title">Nivel:{{this.actualMesa2}}</span> 
                  <br>
                  <span class="title">Mesa:{{this.actualNivel2}}</span> 
                 </div>
                 </v-card-text>
               </v-card>
              <v-data-table
                :headers="headerTabla2" 
                class="elevation-1" 
                :disable-initial-sort="true"
                :items="dataTable2" 
                hide-actions
              >
                <template slot="items" slot-scope="props">
                  
                  <!-- <td class="text-xs-left">{{ props.item.producto }}</td> --> 
                  <td class="justify-center layout px-0">  
                    <v-btn depressed :ripple="false" large  flat class="mx-0" @click="clckMovIzquierda(props.item)">
                      <v-icon  large color="light-blue darken-4" >chevron_left</v-icon>
                    </v-btn>  
                  </td>
                  <td class="body-2 text-xs-left">{{ props.item.nombre }}</td> 
                </template>  
                <template slot="no-data">
                  No hay datos
                </template>
              </v-data-table>  
            </v-flex>
          </v-layout>
        </v-container> 
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

  </v-layout>
</template>

<script src ="./dividir.js">