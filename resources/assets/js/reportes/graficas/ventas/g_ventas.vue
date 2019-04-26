<template>
  <v-container fluid>
  
    <v-card color="grey lighten-3">
      <v-card-title>
        <v-layout row wrap> 
            <v-flex xs12>
                <span class="headline">{{this.txtTitulo}}</span> 
            </v-flex>
        </v-layout>
      </v-card-title>
        <v-card-text>
            <v-layout row wrap> 


                <v-flex xs12>
                    
                    <v-layout row wrap>
                                    <v-flex xs12>
                                    <v-btn-toggle dark v-model="toggle_exclusive" mandatory >
                                        <v-btn  :ripple="false"  depressed color="teal darken-4" @click="clckHorizontal">Horizontal</v-btn> 
                                        <v-btn  :ripple="false"  depressed color="teal darken-4" @click="clckVertical">Vertical</v-btn>
                                    </v-btn-toggle> 

                                    <v-btn-toggle dark v-model="toggle_exclusive2" mandatory >
                                        <v-btn  :ripple="false"  depressed color="teal darken-4" @click="clckBarra">Barras</v-btn>
                                        <v-btn  :ripple="false"  depressed color="teal darken-4" @click="clckLinea">Linea</v-btn> 
                                    </v-btn-toggle> 
                                </v-flex>
                    </v-layout> 
                </v-flex>
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
                            label="Fecha Inicio"
                            prepend-icon="event"
                            readonly
                            ></v-text-field> 
                            <v-date-picker v-model="day" @input="$refs.menu.save(day)" 
                                locale="es-419"></v-date-picker>   
                        </v-menu>  
                    </v-card>
                </v-flex> 
                <v-spacer></v-spacer>
                <v-flex xs12 > 
                    <v-card color="white">  
                        <v-menu
                            ref="menu2"
                            :close-on-content-click="false"
                            v-model="menu2"
                            :nudge-right="40"
                            :return-value.sync="day2"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            min-width="290px"
       
                        >
                            <v-text-field
                            slot="activator"
                            v-model="day2"
                            label="Fecha Fin"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                            <v-date-picker 
                                locale="es-419" v-model="day2" @input="$refs.menu2.save(day2)"></v-date-picker>
                        </v-menu> 
                    </v-card>
                </v-flex> 

  
                <v-flex xs12>
                <v-card color="orange darken-3">
                    <v-card-text>
                        <v-layout row wrap>  
                            <v-flex xs12 md5>
                                <v-btn dark     depressed :ripple="false" color="orange darken-4" @click="clckAceptar"> Ventas</v-btn>
                                <v-btn dark     depressed :ripple="false" color="orange darken-4" @click="clckAbonosGastos"> Abonos y Gastos</v-btn>
                                <v-btn dark     depressed :ripple="false" color="orange darken-4" @click="clckDiferencia"> Diferencia</v-btn> 
                                <v-btn dark     depressed :ripple="false" color="orange darken-4" @click="clckMeseros2"> Meseros</v-btn>
                                <v-btn dark     depressed :ripple="false" color="orange darken-4" @click="clckPropina"> Propina</v-btn>
                                <v-btn dark     depressed :ripple="false" color="orange darken-4" @click="clckMerma"> Merma</v-btn> 
                            </v-flex>
                        </v-layout>
                    </v-card-text>
                </v-card>

                </v-flex>



            <v-flex xs12 >
                <v-card color="grey lighten-2" > 
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
                        <v-flex xs12>
                                <v-btn dark    :disabled="!checkMesero" depressed :ripple="false" color="orange darken-4" @click="clckMeseros"> Mesero </v-btn>
                        </v-flex>


                    </v-layout>
                </v-card> 
            </v-flex>   


                <v-flex xs12>
                    <GChart
                        :type="typeColumn"
                        :data="chartData"
                        :options="chartOptions"
                    />

                </v-flex>

                <v-flex xs12>
                    <span class="headline">{{this.txtPropina}}</span> 
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
<script src ="./g_ventas.js">