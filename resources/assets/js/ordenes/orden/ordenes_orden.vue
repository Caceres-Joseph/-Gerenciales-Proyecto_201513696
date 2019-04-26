<template>

    <v-layout column>
        <!-- /*
        |__________________________________________________________________________
        | INICIO APLICACION
        |__________________________________________________________________________
        */ -->


        <!-- Nuevo  -->
        <v-dialog max-width="500px" v-model="dlgObservacion">
            <v-card>
                <v-card-title>
                    <span class="headline">{{this.actualItemObservacion.producto}}</span>
                </v-card-title>
                <v-card-text>
                    <v-flex xs12>
                        <v-text-field
                                label="Observación"
                                v-model="modelObservacion"

                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                    </v-flex>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click.native="clckNuevaObservacion" color="green darken-4" dark>Aceptar</v-btn>
                    <v-btn @click.native="dlgObservacion = false" color="blue darken-1" flat>Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- Modificar cantidad  -->
        <v-dialog max-width="500px" v-model="dlgCantidad">
            <v-card>
                <v-card-title>
                    <span class="headline">Cant.{{this.actualItemObservacion.producto}}</span>
                </v-card-title>
                <v-card-text>
                    <v-flex xs12>
                        <v-text-field
                                label="Observación"
                                v-model="modelCantidad"

                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                    </v-flex>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click.native="clckNuevaCantidad" color="green darken-4" dark>Aceptar</v-btn>
                    <v-btn @click.native="dlgCantidad = false" color="blue darken-1" flat>Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>


        <div class="wrap">

            <v-layout row wrap>


                <v-flex class="left" sm6 xs12>

                    <br>
                    <v-layout row wrap>
                        <v-flex xs12>
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <v-btn-toggle dark mandatory v-model="toggle_exclusive2">
                                        <v-btn :ripple="false" @click.native="openCity('orden')" color="indigo darken-4"
                                               depressed
                                               large>
                                            VISTA
                                        </v-btn>
                                        <v-btn :ripple="false" @click.native="openCity('eliminarCuenta')"
                                               color="red darken-4" depressed
                                               large>
                                            ELIMINAR
                                        </v-btn>
                                        <!-- <v-btn   color="orange darken-4"      @click.native="openCity( 'individual')">
                                          VISTA INDIVIDUAL
                                        </v-btn> -->
                                        <v-btn :ripple="false" @click.native="openCity( 'calc')" color="teal darken-4"
                                               dark depressed disabled flat
                                               large>
                                            CALC
                                        </v-btn>
                                        <v-btn :ripple="false" @click.native="openCity( 'observaciones')"
                                               color="teal darken-4" dark depressed disabled flat
                                               large>
                                            OBSER
                                        </v-btn>

                                    </v-btn-toggle>
                                </v-flex>
                                <v-flex xs12>


                                    <!--
                                      |- - - - - - - - - - - -
                                      | CUENTA
                                      |- - - - - - - - - - - -
                                    -->
                                    <div class="tabcontent" id="orden">
                                        <v-data-table
                                                :disable-initial-sort="true"
                                                :headers="headersCuenta"
                                                :items="arrayCuenta"
                                                class="elevation-1"
                                                hide-actions
                                        >
                                            <template slot="items" slot-scope="props">
                                                <td class="text-xs-left">{{ props.item.cantidad }}</td>
                                                <td class="text-xs-left">{{ props.item.producto }}</td>
                                                <td class="text-xs-left">{{ props.item.precio_unitario }}</td>
                                                <td class="text-xs-left">{{ (props.item.precio_total).toFixed(2) }}</td>
                                                <td class="justify-center layout px-0">
                                                    <!-- <v-btn icon class="mx-0" @click="editItem(props.item)">
                                                      <v-icon color="teal">edit</v-icon>
                                                    </v-btn> -->
                                                    <v-btn @click="accObservacion(props.item)" class="mx-0" flat large>
                                                        <v-icon color="light-blue darken-4" large>send</v-icon>
                                                    </v-btn>
                                                    <!-- <v-btn icon class="mx-0" @click="accDelete(props.item)">
                                                      <v-icon color="pink">delete</v-icon>
                                                    </v-btn>
                                                    <v-btn icon class="mx-0" @click="accDecrement(props.item)">
                                                      <v-icon color="blue-grey darken-3">remove_circle</v-icon>
                                                    </v-btn> -->
                                                    <v-btn @click="openCity( 'calc'),accIncrement(props.item) "
                                                           class="mx-0" flat
                                                           large>
                                                        <v-icon color="blue-grey darken-3" large>add_circle</v-icon>
                                                    </v-btn>
                                                    <!-- <v-checkbox  v-model="props.item.impreso" @change="checkCambioItem"></v-checkbox> -->
                                                </td>
                                                <td class="text-xs-left">{{ props.item.observacion }}</td>
                                            </template>
                                            <template slot="no-data">
                                                <v-btn flat></v-btn>
                                            </template>
                                        </v-data-table>
                                    </div>


                                    <div class="tabcontent" id="eliminarCuenta">
                                        <v-data-table
                                                :disable-initial-sort="true"
                                                :headers="headersCuentaEliminar"
                                                :items="arrayCuentaEliminar"
                                                class="elevation-1"
                                                hide-actions
                                        >
                                            <template slot="items" slot-scope="props">
                                                <td class="text-xs-left">{{ props.item.producto }}</td>
                                                <td class="justify-center layout px-0">
                                                    <v-btn @click="accEliminarProductoIndividual(props.item)"
                                                           class="mx-0" flat
                                                           large>
                                                        <v-icon color="pink" large>delete</v-icon>
                                                    </v-btn>
                                                </td>
                                            </template>
                                            <template slot="no-data">
                                                <v-btn flat></v-btn>
                                            </template>
                                        </v-data-table>
                                    </div>
                                    <!--
                                      |- - - - - - - - - - - -
                                      | INDIVIDUAL
                                      |- - - - - - - - - - - -
                                    -->
                                    <!-- <div id="individual" class="tabcontent">
                                      <v-data-table
                                          :headers="headersCuentaIndividual"
                                          class="elevation-1"
                                          :disable-initial-sort="true"
                                          :items="arrayCuentaIndividual"
                                          hide-actions
                                        >
                                          <template slot="items" slot-scope="props">
                                            <td class="text-xs-left">{{ props.item.nombre }}</td>
                                            <td class="text-xs-left">{{ props.item.precio }}</td>
                                            <td class="text-xs-left">{{ props.item.descuento }}</td>
                                            <td class="justify-center layout px-0">

                                              <v-btn large icon class="mx-0" @click="accObservacion(props.item)">
                                                <v-icon large color="light-blue darken-4">send</v-icon>
                                              </v-btn>

                                            </td>
                                            <td class="text-xs-left">{{ props.item.observacionGrupal }},{{ props.item.observacion }}</td>
                                          </template>
                                          <template slot="no-data">
                                            <v-btn  flat > </v-btn>
                                          </template>
                                        </v-data-table>
                                    </div> -->
                                    <!--
                                      |- - - - - - - - - - - -
                                      | CALCU
                                      |- - - - - - - - - - - -
                                    -->
                                    <div class="tabcontent" id="calc">
                                        <v-layout row wrap>
                                            <v-flex xs8>
                                                <v-card color="blue-grey darken-3">


                                                    <span class="headline white--text text-xs-center ">{{this.modelEntradaCalculadora}}</span>

                                                    <!-- <v-flex xs12>
                                                        <v-text-field
                                                          v-model="modelEntradaCalculadora"
                                                          label="Cantidad"
                                                          box
                                                          disabled
                                                          class="title"
                                                        ></v-text-field>
                                                      </v-flex> -->
                                                </v-card>
                                            </v-flex>
                                            <v-flex xs4>
                                                <v-btn :ripple="false" @click="clckTecladoBorrar" block
                                                       color="deep-orange darken-3"
                                                       dark>Borrar
                                                </v-btn>
                                                <!-- <v-btn block :ripple="false" color="deep-orange darken-3" dark @click="clckTecladoBorrarTodo">B.Todo</v-btn> -->
                                                <v-btn :ripple="false" @click="clckTecladoEnter" block color="primary"
                                                       dark>Listo
                                                </v-btn>

                                            </v-flex>
                                        </v-layout>
                                    </div>

                                    <div class="tabcontent" id="observaciones">
                                        <v-layout row wrap>


                                            <v-flex xs9>
                                                <v-card>

                                                    <v-text-field
                                                            :rows="3"
                                                            label="Observaciones"
                                                            multi-line
                                                            name="input-7-1"
                                                            v-model="txtObservaciones"
                                                    ></v-text-field>
                                                    <!--  <span class="headline white--text text-xs-center ">{{this.modelEntradaCalculadora}}</span> -->

                                                    <!-- <v-flex xs12>
                                                        <v-text-field
                                                          v-model="modelEntradaCalculadora"
                                                          label="Cantidad"
                                                          box
                                                          disabled
                                                          class="title"
                                                        ></v-text-field>
                                                      </v-flex> -->
                                                </v-card>
                                            </v-flex>
                                            <v-flex xs3>
                                                <v-btn :ripple="false" @click="clckTecladoBorrarObservacion" block
                                                       color="deep-orange darken-3"
                                                       dark>Borrar
                                                </v-btn>
                                                <v-btn :ripple="false" @click="clckTecladoBorrarTodo" block
                                                       color="deep-orange darken-3"
                                                       dark>B.Todo
                                                </v-btn>
                                                <v-btn :ripple="false" @click="clckTecladoEnterObservacion" block
                                                       color="primary"
                                                       dark>Listo
                                                </v-btn>

                                            </v-flex>
                                            <v-flex
                                                    xs12

                                            >
                                                <!--                             <v-select
                                                                            v-model="chips"
                                                                            chips
                                                                            tags
                                                                            solo
                                                                            append-icon=""
                                                <template slot="selection" slot-scope="data">
                                                                          > -->

                                                <!-- :selected="data.selected"
                                                  @click="clckChip(data.item)" -->

                                                <v-chip
                                                        :key="elem"
                                                        @click="clckChip(elem)"
                                                        color="teal darken-4"
                                                        label
                                                        v-for="elem in chips"
                                                >
                                                    <span class=" body-1 white--text">{{elem}}</span>
                                                </v-chip>

                                                <!--  </template>
                                                                          </v-select> -->
                                            </v-flex>

                                        </v-layout>
                                    </div>

                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex xs12>
                            <v-layout row wrap>
                                <v-flex sm12 xs12>
                                    <v-card>
                                        <v-card>
                                            <v-card-actions>
                                                <div class="subheading black--text text-xs-left">SubTotal Q.</div>
                                                <v-spacer></v-spacer>
                                                <div class=" subheading black--text text-xs-right">
                                                    {{this.totalOrdenMostrar.toFixed(2)}}
                                                </div>
                                            </v-card-actions>
                                        </v-card>
                                        <v-card>
                                            <v-card-actions>
                                                <div class="subheading black--text text-xs-left">Propina Sugerida 10%.
                                                    Q.
                                                </div>
                                                <v-spacer></v-spacer>
                                                <div class=" subheading black--text text-xs-right">
                                                    {{(this.totalOrdenMostrar*this.porcentajePropina).toFixed(2)}}
                                                </div>
                                            </v-card-actions>
                                        </v-card>
                                        <v-card color="teal darken-4">
                                            <v-card-actions>
                                                <div class="subheading white--text text-xs-left">Total Q.</div>
                                                <v-spacer></v-spacer>
                                                <div class="subheading white--text text-xs-right">
                                                    {{(this.totalOrdenMostrar*this.porcentajePropina+this.totalOrdenMostrar).toFixed(2)}}
                                                </div>
                                            </v-card-actions>
                                        </v-card>
                                    </v-card>
                                    <!--                         <v-card ripple  >
                                                              <v-card-text >
                                                                <v-btn   dark icon color="blue darken-3"  >
                                                                  <v-icon>home</v-icon>
                                                                </v-btn>
                                                              </v-card-text>
                                                            </v-card>
                                                            <v-card ripple color="blue darken-3" >
                                                              <v-card-text >
                                                                <div class=" white--text text-xs-left">Imprimir</div>
                                                              </v-card-text>
                                                            </v-card>
                                                            <v-card ripple color="blue darken-4" >
                                                              <v-card-text >
                                                                <div class=" white--text text-xs-left">Imprimir</div>
                                                              </v-card-text>
                                                            </v-card>
                                                            <v-btn block color="primary" dark>imprimir</v-btn>
                                                            <v-btn block color="primary" dark>Cocina</v-btn>
                                                            <v-btn block color="primary" dark>barra</v-btn> -->
                                </v-flex>
                                <!--
                                  |- - - - - - - - - - - -
                                  | TECLADO
                                  |- - - - - - - - - - - -
                                -->
                                <v-flex xs8>
                                    <v-card color="light-blue darken-4">
                                        <v-layout row wrap>

                                            <v-flex xs4>
                                                <v-card @click.native="clckTeclado(1)" color="light-blue darken-4">
                                                    <v-card-text>
                                                        <div class="headline white--text text-xs-center">1</div>
                                                    </v-card-text>
                                                </v-card>
                                            </v-flex>
                                            <v-flex xs4>
                                                <v-card @click.native="clckTeclado(2)" color="light-blue darken-4">
                                                    <v-card-text>
                                                        <div class="headline white--text text-xs-center">2</div>
                                                    </v-card-text>
                                                </v-card>
                                            </v-flex>
                                            <v-flex xs4>
                                                <v-card @click.native="clckTeclado(3)" color="light-blue darken-4">
                                                    <v-card-text>
                                                        <div class="headline white--text text-xs-center">3</div>
                                                    </v-card-text>
                                                </v-card>
                                            </v-flex>
                                            <v-flex xs4>
                                                <v-card @click.native="clckTeclado(4)" color="light-blue darken-4">
                                                    <v-card-text>
                                                        <div class="headline white--text text-xs-center">4</div>
                                                    </v-card-text>
                                                </v-card>
                                            </v-flex>
                                            <v-flex xs4>
                                                <v-card @click.native="clckTeclado(5)" color="light-blue darken-4">
                                                    <v-card-text>
                                                        <div class="headline white--text text-xs-center">5</div>
                                                    </v-card-text>
                                                </v-card>
                                            </v-flex>
                                            <v-flex xs4>
                                                <v-card @click.native="clckTeclado(6)" color="light-blue darken-4">
                                                    <v-card-text>
                                                        <div class="headline white--text text-xs-center">6</div>
                                                    </v-card-text>
                                                </v-card>
                                            </v-flex>
                                            <v-flex xs4>
                                                <v-card @click.native="clckTeclado(7)" color="light-blue darken-4">
                                                    <v-card-text>
                                                        <div class="headline white--text text-xs-center">7</div>
                                                    </v-card-text>
                                                </v-card>
                                            </v-flex>
                                            <v-flex xs4>
                                                <v-card @click.native="clckTeclado(8)" color="light-blue darken-4">
                                                    <v-card-text>
                                                        <div class="headline white--text text-xs-center">8</div>
                                                    </v-card-text>
                                                </v-card>
                                            </v-flex>
                                            <v-flex xs4>
                                                <v-card @click.native="clckTeclado(9)" color="light-blue darken-4">
                                                    <v-card-text>
                                                        <div class="headline white--text text-xs-center">9</div>
                                                    </v-card-text>
                                                </v-card>
                                            </v-flex>
                                            <v-flex xs4>
                                                <v-card color="white">
                                                    <v-card-text>
                                                        <div class="headline white--text text-xs-center">7</div>
                                                    </v-card-text>
                                                </v-card>
                                            </v-flex>
                                            <v-flex xs4>
                                                <v-card @click.native="clckTeclado(0)" color="light-blue darken-4">
                                                    <v-card-text>
                                                        <div class="headline white--text text-xs-center">0</div>
                                                    </v-card-text>
                                                </v-card>
                                            </v-flex>
                                            <v-flex xs4>
                                                <v-card color="white">
                                                    <v-card-text>
                                                        <div class="headline white--text text-xs-center">9</div>
                                                    </v-card-text>
                                                </v-card>
                                            </v-flex>
                                        </v-layout>
                                    </v-card>
                                </v-flex>
                                <v-flex xs4>
                                    <v-card flat>
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <!--  <v-btn block :ripple="false" color="deep-orange darken-3" dark @click="clckTecladoBorrar">Borrar</v-btn>
                                                 <v-btn block :ripple="false" color="primary" dark @click="clckTecladoEnter">Listo</v-btn> -->
                                                <v-btn :ripple="false" @click="clckQuitarPropina" block
                                                       color="white black--text"
                                                       dark large v-if="this.porcentajePropina!=0.0"> Con
                                                    propina
                                                </v-btn>
                                                <v-btn :ripple="false" @click="clckQuitarPropina" block
                                                       color="amber darken-4 white--text"
                                                       dark large
                                                       v-if="this.porcentajePropina==0.0">Sin propina
                                                </v-btn>
                                                <v-btn :disabled="!desacBtnActualizar" :ripple="false"
                                                       @click="clckActualizar" block
                                                       color="teal darken-4" dark large>Actualizar
                                                </v-btn>
                                                <!--
                                                  <v-btn-toggle block v-model="toggle_exclusive"  ><v-btn block :ripple="false"    color=""     @click="clckQuitarPropina">Sin Propina</v-btn></v-btn-toggle> -->

                                                <!-- <v-card  color="blue-grey darken-3" @click.native="clckTeclado(9)"  >
                                                 <v-card-text>
                                                   <div class="headline white--text text-xs-center">9</div>
                                                 </v-card-text>
                                                 </v-card>
                                                 -->
                                            </v-flex>
                                            <v-flex xs12>

                                            </v-flex>
                                        </v-layout>
                                    </v-card>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-flex>

                <!--        <v-flex xs12>
                     <div class="container">
                        <div class="top">Fixed Top</div>
                        <div class="content">
                          <div>
                          incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quincididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.is nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                          </div>
                          <div>
                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                          </div>
                        </div>
                      </div>
                      </v-flex>-->
                <v-flex class="right" sm6 xs12>
                    <v-layout row wrap>
                        <v-flex xs12>
                            <br>
                            <v-btn-toggle dark mandatory v-model="toggle_exclusive">
                                <!--<v-btn @click="clckVerOrdenes" color="blue darken-3" depressed large>Ordenes</v-btn>-->
                                <v-btn @click="clckBlock" color="orange darken-3" depressed large>Salir</v-btn>
                                <v-btn :disabled="!desacBtnCobrar" @click="imprimir" color="amber accent-4" depressed
                                       large>Cobrar
                                </v-btn>
                                <v-btn :disabled="!desacBtnEnviar" @click="clckEnviar" color="green darken-4" depressed
                                       large>Enviar
                                </v-btn>
                                <v-btn @click="clckSubirDeCarpeta" color="lime darken-4" depressed large>
                                    <v-icon large>arrow_drop_up</v-icon>
                                </v-btn>
                            </v-btn-toggle>
                        </v-flex>

                        <v-flex xs12>
                            <!--  <v-btn color="blue darken-3" @click="imprimir">Ordenes</v-btn>
                                   <v-btn color="orange darken-3" @click="clckBlock">Salir</v-btn>
                                   <v-btn color="amber accent-4" @click="imprimir">Cobrar</v-btn>
                                   <v-btn color="green darken-4" @click="imprimir">Imprimir</v-btn>
                                    -->
                            <v-card flat>
                                <v-card-text>
                                    <v-layout row wrap>
                                        <v-flex md6 xs12>
                                            <span class="title"> {{this.actualNivel}}, {{this.actualMesa}}  </span>
                                        </v-flex>
                                        <v-flex class="text-md-right" md6 xs12>
                      <span class="title">
                        {{this.actualNombreMesero}}
                        -
                        Orden #
                        {{
                          this.actualIdOrden
                        }}
                      </span>
                                        </v-flex>
                                    </v-layout>

                                </v-card-text>
                            </v-card>
                            <v-card color="teal darken-4">
                                <!-- :rows-per-page-items="rowsPerPageItems"
                                  :pagination.sync="pagination" -->
                                <!-- CARPETS -->
                                <v-data-iterator
                                        :items="categorias"
                                        content-tag="v-layout"
                                        hide-actions
                                        row
                                        wrap

                                >
                                    <v-flex
                                            lg3
                                            md4
                                            slot="item"
                                            slot-scope="props"
                                            sm6
                                    >
                                        <!-- ripple -->
                                        <v-card @click.native="clckCategoria(props.item)" flat>
                                            <v-card-media
                                                    :src="props.item.imagen"
                                                    contain
                                                    height="100"
                                            >
                                                <v-container fill-height fluid>
                                                    <v-layout fill-height>
                                                        <v-flex align-end flexbox xs12>
                                                            <v-card class="center" flat>
                                                                <span>{{ props.item.nombre }}</span>
                                                            </v-card>
                                                            <!--<v-btn block class="center" color="white" light >text</v-btn>
                                                           <span class="subheading">{{ props.item.nombre }}</span>
                                                         --> </v-flex>
                                                    </v-layout>
                                                </v-container>
                                            </v-card-media>
                                        </v-card>
                                    </v-flex>
                                    <template slot="no-data">
                                        <span class="white--text">No hay categorías que mostrar</span>
                                    </template>
                                </v-data-iterator>
                            </v-card>
                            <v-card flat height="10">

                            </v-card>
                        </v-flex>
                        <v-flex xs12>
                            <!-- ARCHIVOS -->
                            <v-card color="orange darken-2">
                                <v-data-iterator
                                        :items="articulos"
                                        content-tag="v-layout"
                                        hide-actions

                                        row
                                        wrap
                                >
                                    <v-flex
                                            lg3
                                            md4
                                            slot="item"
                                            slot-scope="props"
                                            sm6
                                    >
                                        <!-- ripple -->


                                        <v-card @click.native="clckArticulo(props.item)" color="orange darken-2" flat>
                                            <v-card-media
                                                    :rows-per-page-items="rowsPerPageItems2"
                                                    :src="props.item.imagen"
                                                    contain
                                                    height="100"
                                            >
                                                <v-container fill-height fluid>
                                                    <v-layout fill-height>
                                                        <v-flex align-end flexbox xs12>
                                                            <v-card class="center" flat>
                                                                {{ props.item.nombre }}
                                                                Q{{ props.item.precioVentaDefecto }}
                                                            </v-card>
                                                            <!--<v-btn block class="center" color="white" light >text</v-btn>
                                                           <span class="subheading">{{ props.item.nombre }}</span>
                                                         --> </v-flex>
                                                    </v-layout>
                                                </v-container>

                                            </v-card-media>
                                        </v-card>
                                    </v-flex>

                                    <template slot="no-data">
                                        <span>No hay artículos que mostrar</span>
                                    </template>
                                </v-data-iterator>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-flex>


            </v-layout>
        </div>
        <!-- Snackbar -->
        <v-snackbar
                :color="snackColor"
                :timeout=5000
                button
                v-model="snackStatus"
        >
            {{ sanckText }}
            <!-- <v-btn    @click.native="snackStatus = false">Cerrar</v-btn> -->
            <div>
                <v-btn :color="snackColor" @click.native="snackStatus = false" dark depressed small>Cerrar</v-btn>
            </div>
        </v-snackbar>
    </v-layout>
</template>
<style>
    #keep main .container {
        height: 660px;
    }

    .navigation-drawer__border {
        display: none;
    }

    .text {
        font-weight: 400;
    }
</style>

<style>
    .wrap {
        display: flex;
    }

    .left {
        height: 80vh;
        overflow: auto;
    }

    .right {
        height: 80vh;
        overflow: auto;
    }
</style>
<style>
    .center {
        opacity: 0.85;
        filter: alpha(opacity=85);
    }
</style>
<style>
    /* body {font-family: Arial;} */

    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    /* Style the buttons inside the tab */
    .tab button {
        /* background-color: inherit;
          float: left;
          border: none;
          outline: none;
          cursor: pointer;
          padding: 14px 16px;
          transition: 0.3s;
          font-size: 17px; */
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        /* background-color: #ddd; */
    }

    /* Create an active/current tablink class */
    .tab button.active {
        /*  background-color: #ccc; */
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
        border-top: none;
    }
</style>
<script src="./ordenes_orden.js"/>
