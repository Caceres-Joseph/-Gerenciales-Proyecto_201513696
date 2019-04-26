<template>
  <v-container fluid>
  
    <v-card color="grey lighten-3">
      <v-card-title>
        <v-layout row wrap> 
            <v-flex xs12>
                <span class="headline">Reporte de ventas detallas por empleado</span> 
            </v-flex>
            <v-flex xs12 >
                <v-card color="white" > 
                    <v-layout row wrap>
                        <v-flex xs12 sm4>
                            <!-- <v-checkbox v-model="modelChekMedida" hide-details color="blue darken-3" label="Unidad de Medida" @change="checkBoxMedida">
                            </v-checkbox> -->
                            <v-checkbox   v-model="checkMesero" hide-details color="blue darken-3" label="Mesero" @change="checkBoxMesero"  >
                            </v-checkbox>
                        </v-flex>
                        <v-spacer></v-spacer>
                    
                        <v-flex xs12 sm8>
                            <v-select :items="usuarios" :disabled="!checkMesero" item-text="nombre" autocomplete placeholder="Seleccione" @change="cbCambioUsuario">
                            </v-select>
                            <!-- 
                            <v-select ref="focoMedida" :items="medidas" :filter="customFilter" v-model="MedidaModel" item-text="nombre" autocomplete :disabled="!modelChekMedida" placeholder="Seleccione" @change="cbCambioNuevoMedida">
                            </v-select>
                             -->
                        </v-flex>
                    </v-layout>
                </v-card> 
            </v-flex>  
            <v-flex xs12>
                <hr>
                <v-expansion-panel> 
                    <!-- <v-expansion-panel-content focusable>  
                        <div slot="header">
                            Caja
                        </div>  
                        <v-card color="blue-grey lighten-4">
                            <v-card-text>
                              <v-text-field box label="Num Caja" v-model="idCaja"  placeholder="0" v-mask-number></v-text-field>
                            </v-card-text> 
                            <v-card-actions >
                              <v-btn depressed :ripple="false" dark large color="teal darken-4" @click="clckCaja">Aceptar</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-expansion-panel-content>
                    <v-expansion-panel-content>
                        <div slot="header"> 
                            Rango de Cajas
                        </div>
                        <v-card color="blue-grey lighten-4">
                            <v-card-text>
                              <v-text-field box label="Num Caja Inicio" v-model="idCaja1"  placeholder="0" v-mask-number></v-text-field>
                              <v-text-field box label="Num Caja Final" v-model="idCaja2"  placeholder="0" v-mask-number></v-text-field>
                            </v-card-text> 
                            <v-card-actions >
                              <v-btn depressed :ripple="false" dark large color="teal darken-4" @click="clckRangoCaja" >Aceptar</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-expansion-panel-content> -->
                    <v-expansion-panel-content>
                        <div slot="header"> 
                            Día
                        </div>
                        <v-card color="blue-grey lighten-4">
                            <v-card-text>
                            <v-date-picker
                                color="light-blue darken-4"
                                v-model="day" 
                                class="mt-3"
                                locale="es-419"
                            ></v-date-picker>
                            </v-card-text> 
                            <v-card-actions >
                              <v-btn depressed :ripple="false" dark large color="teal darken-4" @click="clckDia">Aceptar</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-expansion-panel-content>
                    <!-- <v-expansion-panel-content>
                        <div slot="header"> 
                            Rango de Días
                        </div>
                        <v-card color="blue-grey lighten-4">
                            <v-card-text>
                            <v-date-picker
                                color="light-blue darken-4"
                                v-model="day1" 
                                class="mt-3"
                                locale="es-419"
                            ></v-date-picker>
                            <v-date-picker
                                color="cyan darken-4"
                                v-model="day2" 
                                class="mt-3"
                                locale="es-419"
                            ></v-date-picker>
                            </v-card-text>
                            <v-card-actions >
                              <v-btn depressed :ripple="false" dark large color="teal darken-4" @click="clckRangoDia">Aceptar</v-btn>
                            </v-card-actions> 
                        </v-card>
                    </v-expansion-panel-content>
                    <v-expansion-panel-content>
                        <div slot="header"> 
                            Mes
                        </div>
                        <v-card color="blue-grey lighten-4">
                            <v-card-text>
                            <v-date-picker
                                color="light-blue darken-4"
                                v-model="month" 
                                class="mt-3"
                                locale="es-419"
                                type="month"
                            ></v-date-picker>
                            </v-card-text> 
                            <v-card-actions >
                              <v-btn depressed :ripple="false" dark large color="teal darken-4" @click="clckMes">Aceptar</v-btn>
                            </v-card-actions> 
                        </v-card>
                    </v-expansion-panel-content>
                    <v-expansion-panel-content>
                        <div slot="header"> 
                            Rango de Meses
                        </div>
                        <v-card color="blue-grey lighten-4">
                            <v-card-text>
                            <v-date-picker
                                color="light-blue darken-4"
                                v-model="month1" 
                                class="mt-3"
                                locale="es-419"
                                type="month"
                            ></v-date-picker>
                            <v-date-picker
                                color="cyan darken-4"
                                v-model="month2" 
                                class="mt-3"
                                locale="es-419"
                                type="month"
                            ></v-date-picker>
                            </v-card-text> 
                            <v-card-actions >
                              <v-btn depressed :ripple="false" dark large color="teal darken-4" @click="clckRangoMes">Aceptar</v-btn>
                            </v-card-actions> 
                        </v-card>
                    </v-expansion-panel-content>      -->         
 
                </v-expansion-panel> 
            </v-flex>
            <!-- <v-divider></v-divider> -->
            <hr>
            <br>  


            <v-flex xs12>
              <v-card color="orange darken-3">
                  <v-card-text>
                    <v-layout row wrap>
                    <v-flex xs12 md4>
                        <v-card dark flat color="red darken-4">
                        <v-card-text>
                            <v-layout row wrap>
 
                                <v-flex xs12 >
                                <span class="headline" > Mesero  {{this.mostrarMesero}}</span>
                                </v-flex>
                                <v-flex  xs12>
                                <span class="subheading"  >{{this.mostrarFecha}} </span> 
                                </v-flex>

                                <v-flex  xs6>
                                <span class="subheading"  > SubTotal: </span> 
                                </v-flex>
                                <v-spacer></v-spacer>
                                <v-flex xs6 class="text-xs-right">
                                <span class="title" >Q{{(this.mostrarSubTotal).toFixed(2)}} </span>
                                </v-flex>
                                <v-flex  xs6>
                                <span class="subheading"  >Propina  : </span> 
                                </v-flex>
                                <v-spacer></v-spacer>
                                <v-flex xs6 class="text-xs-right">
                                <span class="title" >Q{{(this.mostrarPropina).toFixed(2)}} </span>
                                </v-flex>
                                <v-flex xs12 class="text-xs-right" >
                                <span class="subheading"  > ---------------------</span> 
                                </v-flex>
                                <v-flex  xs6>
                                <span class="subheading"  > Total: </span> 
                                </v-flex>
                                <v-spacer></v-spacer>
                                <v-flex xs6 class="text-xs-right">
                                <span class="title" >Q{{(this.mostrarTotal).toFixed(2)}} </span>
                                </v-flex>
                            </v-layout>                            
                        </v-card-text>
                        </v-card>
                    </v-flex>
                    <v-flex xs12 md4>
                        <v-btn dark  large   depressed :ripple="false" color="orange darken-4" @click="printFecha"><v-icon>print</v-icon> Imprimir</v-btn>
                        <!-- <v-btn dark  large   depressed :ripple="false" color="orange darken-4" @click="printPropina"><v-icon>print</v-icon>Propina</v-btn>
                        <v-btn dark  large   depressed :ripple="false" color="orange darken-4" @click="printCajaMesero"><v-icon>print</v-icon>Caja-Mesero</v-btn> -->
                    </v-flex>
                    </v-layout>
                  </v-card-text>
              </v-card>

            </v-flex>
             <v-flex xs12>
                <v-data-table
                :headers="headers"
                :items="cobros" 
                class="elevation-1"
                :search="search"
                :disable-initial-sort="true"
                >
                <template slot="items" slot-scope="props">
                    
                    <td class="text-xs-left">{{ props.item.idOrden }}</td>
                    <td class="text-xs-left">{{ props.item.idCaja }}</td> 
                    <td class="text-xs-left">{{ props.item.subTotal }}</td>
                    <td class="text-xs-left">{{ props.item.propina }}</td>
                    <td class="text-xs-left">{{ props.item.total }}</td>
                    <td class="text-xs-left">{{ props.item.ordenFecha }}</td>
                    <td class="text-xs-left">{{ props.item.constanciaFecha }}</td>
                    <td class="text-xs-left">{{ props.item.mesero }}</td>
                    <td class="justify-center layout px-0"> 
                            <v-btn icon class="mx-0" @click="accVerItem(props.item)">
                                <v-icon >remove_red_eye</v-icon>
                            </v-btn> 
                    </td>

                </template>
                <template slot="no-data">
                </template>
                </v-data-table>              
            </v-flex>  
        </v-layout>
      </v-card-title>

    </v-card> 
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
<script src ="./dia_ventaDetalladaEmpleado.js">