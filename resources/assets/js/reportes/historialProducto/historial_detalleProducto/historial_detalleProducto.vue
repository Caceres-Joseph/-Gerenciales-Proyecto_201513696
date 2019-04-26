<template>
  <v-container fluid>
  
    <v-card color="grey lighten-3">
      <v-card-title>
        <v-layout row wrap>
            
            <v-flex xs12>
                <span class="display-1">{{this.$route.params.nombre}}</span> 
            </v-flex>
            <v-flex xs12>
                <span class="headline">id:{{this.$route.params.id}}</span> 
            </v-flex> 
            <v-flex xs12>
                <span class="headline">Historial Compra/Venta Semanal</span> 
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
                            <v-date-picker v-model="day" no-title scrollable
                            locale="es-419">
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
                            <v-flex xs12 md4>
                                <v-card dark flat color="red darken-4">
                                <v-card-text>
                                    <v-layout row wrap>
                                        <v-flex xs12>
                                             <span class="subheading"  > Del: {{this.delFecha}} </span> 
                                            
                                        </v-flex>
                                        <v-flex xs12>
                                             <span class="subheading"  > Al : {{this.alFecha}}</span> 
                                        </v-flex>
                                    </v-layout>
                                                              
                                </v-card-text>
                                </v-card>
                            </v-flex>
                            
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
                    hide-actions
                    > 
                    <template  slot="items" slot-scope="props">
                        
                            
                         <td    :class="props.item.clase"> {{ props.item.operacion }}</td>
                       
                             

                            <td v-if="props.item.domingo!=null" :class="props.item.clase">{{ props.item.domingo }}</td>
                            <td v-else :class="props.item.clase">0</td>

                            <td v-if="props.item.lunes!=null" :class="props.item.clase">{{ props.item.lunes }}</td>
                            <td v-else :class="props.item.clase">0</td>

                            <td v-if="props.item.martes!=null" :class="props.item.clase">{{ props.item.martes }}</td>
                            <td v-else :class="props.item.clase">0</td>

                            <td v-if="props.item.miercoles!=null" :class="props.item.clase">{{ props.item.miercoles }}</td>
                            <td v-else :class="props.item.clase">0</td>

                            <td v-if="props.item.jueves!=null" :class="props.item.clase">{{ props.item.jueves }}</td>
                            <td v-else :class="props.item.clase">0</td>

                            <td v-if="props.item.viernes!=null" :class="props.item.clase">{{ props.item.viernes }}</td>
                            <td v-else :class="props.item.clase">0</td>

                            <td v-if="props.item.sabado!=null" :class="props.item.clase">{{ props.item.sabado }}</td>
                            <td v-else :class="props.item.clase">0</td> 
                        


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
<script src ="./historial_detalleProducto.js">