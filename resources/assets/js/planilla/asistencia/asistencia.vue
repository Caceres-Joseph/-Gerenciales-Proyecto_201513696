<template>
  <v-container fluid>
  
    <v-card color="grey lighten-3">
      <v-card-title>
        <v-layout row wrap> 
            <v-flex xs12>
                <span class="headline">Asistencia por rango de fechas</span>
            </v-flex>
        </v-layout>
      </v-card-title>
        <v-card-text>
            <v-layout row wrap>



                <v-flex xs12 >
                    <v-card flat color="light-blue darken-3" dark>
                        <v-card-text>
                            <span class="headline"> {{this.$route.params.nombre }}</span>
                            <br>
                            <span class="subheading"> Id:{{this.$route.params.id }}</span>
                            <v-divider></v-divider>

                            <span class="subheading">Tiempo laborado del <strong>{{this.day }} al {{this.day2}}</strong>  HH:mm:ss </span>
                            <br>
                            <span class="subheading">Total: <strong>{{this.itemEnviar.horas}}</strong> </span>

                        </v-card-text>
                    </v-card>
                </v-flex>

                <v-flex xs12 sm5 >
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
                </v-flex> 
                <v-spacer></v-spacer>
                <v-flex xs12 sm6 >
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
                </v-flex> 

                <br>
                <v-flex xs12>
                    <v-card color="blue-grey lighten-5" flat>
                        <v-card-title>
                            <v-btn
                                    @click="clckAceptar"
                                    color="light-blue darken-3"
                                    dark
                                    depressed
                                    large
                            >
                                Aceptar
                            </v-btn>
                            <v-btn
                                    @click.native="imprimir"
                                    color="orange darken-2"
                                    depressed
                                    large
                                    dark
                            >
                                Imprimir
                            </v-btn>
                            <!--<v-btn
                                    @click.native="imprimir"
                                    color="blue-grey lighten-4"
                                    depressed
                                    large
                            >
                                Asistencia
                            </v-btn>
                            <v-btn
                                    color="teal darken-2"
                                    dark
                                    depressed
                                    large
                            >
                                Saldo
                            </v-btn>-->
                            <v-spacer></v-spacer>
                        </v-card-title>

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
                            :disable-initial-sort="true"
                    >
                        <template slot="items" slot-scope="props">

                            <td class="text-xs-left">{{ props.item.fecha }}</td>
                            <td class="text-xs-left">{{ props.item.entrada }}</td>
                            <td class="text-xs-left">{{ props.item.salida }}</td>
                            <td class="text-xs-left">{{ props.item.horas }}</td>

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
<script src ="./asistencia.js">