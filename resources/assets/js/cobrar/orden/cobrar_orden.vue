<template>


    <v-layout column>
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

        <v-dialog max-width="500px" v-model="dlgPassword">
            <v-card>
                <v-card-title>
                    <span class="headline">Escriba la contraseña para realizar la operación</span>
                </v-card-title>
                <v-card-text>
                    <v-flex xs12>
                        <v-text-field label="Contraseña" name="password" prepend-icon="lock" type="password"
                                      v-model="txtPassword"></v-text-field>
                    </v-flex>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click.native="clckPasswordAceptar" color="green darken-4" dark>Aceptar</v-btn>
                    <v-btn @click.native="dlgPassword = false" color="blue darken-1" flat>Cancelar</v-btn>
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
                                    <v-btn-toggle mandatory v-model="toggle_exclusive">
                                        <v-btn @click.native="openCity('orden')" color="teal darken-4" dark flat>
                                            ORDEN
                                        </v-btn>
                                        <v-btn @click.native="openCity( 'individual')" color="teal darken-4" dark flat>
                                            INDIVIDUAL
                                        </v-btn>
                                        <v-btn @click.native="openCity( 'calc')" color="teal darken-4" dark disabled
                                               flat>
                                            CALC
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
                                                <td class="text-xs-right">{{ props.item.precio_unitario }}</td>
                                                <td class="text-xs-right">{{ (props.item.precio_total).toFixed(2) }}
                                                </td>
                                                <td class="justify-center layout px-0">
                                                    <!-- <v-btn icon class="mx-0" @click="editItem(props.item)">
                                                      <v-icon color="teal">edit</v-icon>
                                                    </v-btn> -->
                                                    <v-btn @click="accObservacion(props.item)" class="mx-0" icon large>
                                                        <v-icon color="light-blue darken-4" large>send</v-icon>
                                                    </v-btn>
                                                    <!-- <v-btn icon  large class="mx-0" @click="accDeleteGrupal(props.item)">
                                                      <v-icon large color="pink">delete</v-icon>
                                                    </v-btn> -->
                                                    <!-- <v-btn icon large class="mx-0" @click="accRemoveGrupal(props.item)">
                                                      <v-icon  large color="blue-grey darken-3">remove_circle</v-icon>
                                                    </v-btn>   -->
                                                    <v-btn @click="abrirCalcu('calcAddGrupo', props.item)" class="mx-0" icon
                                                           large>
                                                        <v-icon color="blue-grey darken-3" large>add_circle</v-icon>
                                                    </v-btn>
                                                    <v-btn @click="accPrecioGrupal(props.item)" class="mx-0" icon large>
                                                        <v-icon color="blue-grey darken-3" large>monetization_on
                                                        </v-icon>
                                                    </v-btn>
                                                    <!--  <v-btn icon class="mx-0" @click="openCity( 'calc'),accIncrement(props.item) ">
                                                       <v-icon color="blue-grey darken-3" >assignment_returned</v-icon>
                                                     </v-btn>   -->
                                                    <!-- <v-checkbox  v-model="props.item.impreso" @change="checkCambioItem"></v-checkbox> -->
                                                </td>
                                                <td class="text-xs-left">{{ props.item.observacion }}</td>
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
                                    <div class="tabcontent" id="individual">
                                        <v-data-table
                                                :disable-initial-sort="true"
                                                :headers="headersCuentaIndividual"
                                                :items="arrayCuentaIndividual"
                                                class="elevation-1"
                                                hide-actions
                                        >
                                            <template slot="items" slot-scope="props">
                                                <td class="text-xs-left">{{ props.item.nombre }}</td>
                                                <td class="text-xs-right">{{ props.item.precio }}</td>
                                                <td class="text-xs-right">{{ props.item.descuento }}</td>
                                                <td class="justify-center layout px-0">

                                                    <v-btn @click="accObservacion(props.item)" class="mx-0" icon large>
                                                        <v-icon color="light-blue darken-4" large>send</v-icon>
                                                    </v-btn>
                                                    <!-- <v-btn  large icon class="mx-0" @click="accDeleteIndividual2(props.item)">
                                                      <v-icon  large color="pink">delete</v-icon>
                                                    </v-btn> -->
                                                    <!--   <v-btn icon class="mx-0" @click="accDecrementIndividual(props.item)">
                                                      <v-icon color="blue-grey darken-3">remove_circle</v-icon>
                                                    </v-btn>
                                                    <v-btn icon class="mx-0" @click="accAddIndividual( props.item)  ">
                                                      <v-icon color="blue-grey darken-3" >add_circle</v-icon>
                                                    </v-btn>   -->
                                                    <!-- <v-btn icon class="mx-0" @click="abrirCalcu( 'calcPrecioIndividual',props.item),accPrecioIndividual( props.item)  ">
                                                      <v-icon color="blue-grey darken-3" >monetization_on</v-icon>
                                                    </v-btn>
                                                    <v-btn icon class="mx-0" @click="accDescuentoIndividual( props.item) ">
                                                      <v-icon color="blue-grey darken-3" >assignment_returned</v-icon>
                                                    </v-btn>  -->
                                                    <!-- <v-checkbox   v-model="props.item.impreso" @change="checkCambioItem(props.item)"></v-checkbox> -->
                                                </td>
                                                <td class="text-xs-left">{{ props.item.observacionGrupal }},{{
                                                    props.item.observacion }}
                                                </td>
                                            </template>
                                            <template slot="no-data">
                                                <v-btn flat></v-btn>
                                            </template>
                                        </v-data-table>
                                    </div>
                                    <!--
                                      |- - - - - - - - - - - -
                                      | CALCU
                                      |- - - - - - - - - - - -
                                    -->
                                    <div class="tabcontent" id="calc">
                                        <v-layout row wrap>
                                            <v-flex xs8>
                                                <v-card color="blue-grey darken-3" dark>


                                                    <!-- <v-text-field class="display-3 white--text text-xs-center "  v-model="modelEntradaCalculadora" box label="Entrada"></v-text-field> -->
                                                    <span class="display-3 white--text text-xs-center ">{{this.modelEntradaCalculadora}}</span>

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
                                                <v-btn :ripple="false" @click="clckTecladoBorrar" block color="deep-orange darken-3"
                                                       dark>Borrar
                                                </v-btn>
                                                <v-btn :ripple="false" @click="clckTecladoEnter" block color="primary"
                                                       dark>Listo
                                                </v-btn>

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
                                                <div class="headline white--text text-xs-left">Total Q.</div>
                                                <v-spacer></v-spacer>
                                                <div class="headline white--text text-xs-right">
                                                    {{(this.totalOrdenMostrar*this.porcentajePropina+this.totalOrdenMostrar).toFixed(2)}}
                                                </div>
                                            </v-card-actions>
                                        </v-card>
                                        <!--  <v-card color="light-green lighten-2" @click.native="clckTarjeta" >
                                           <v-card-actions>
                                             <div class="subheading black--text text-xs-left">Tarjeta</div>
                                             <v-spacer></v-spacer>
                                             <div class="subheading black--text text-xs-right">{{(this.cobrarTarjeta).toFixed(2)}}</div>
                                           </v-card-actions>
                                         </v-card>
                                         <v-card color="lime lighten-2" @click.native="clckEfectivo" >
                                           <v-card-actions>
                                             <div class="subheading black--text text-xs-left">Efectivo</div>
                                             <v-spacer></v-spacer>
                                             <div class="subheading black--text text-xs-right">{{(this.cobrarEfectivo).toFixed(2)}}</div>
                                           </v-card- -->
                                    </v-card>
                                    <!-- <v-card v-if="((this.cobrarEfectivo+this.cobrarTarjeta)-(this.totalOrdenMostrar*this.porcentajePropina+this.totalOrdenMostrar))<0"  color="deep-orange darken-3">
                                      <v-card-actions>
                                        <div class="display-1 white--text text-xs-left">Cambio</div>
                                        <v-spacer></v-spacer>
                                        <div  class="display-1 white--text text-xs-right">{{((this.cobrarEfectivo+this.cobrarTarjeta)-(this.totalOrdenMostrar*this.porcentajePropina+this.totalOrdenMostrar)).toFixed(2)}}</div>
                                      </v-card-actions>
                                    </v-card>  -->
                                    <!-- <v-card  v-if="((this.cobrarEfectivo+this.cobrarTarjeta)-(this.totalOrdenMostrar*this.porcentajePropina+this.totalOrdenMostrar))>=0"   color="teal darken-4">
                                      <v-card-actions>
                                        <div class="display-1 white--text text-xs-left">Cambio</div>
                                        <v-spacer></v-spacer>
                                        <div  class="display-1 white--text text-xs-right">{{((this.cobrarEfectivo+this.cobrarTarjeta)-(this.totalOrdenMostrar*this.porcentajePropina+this.totalOrdenMostrar)).toFixed(2)}}</div>
                                      </v-card-actions>
                                    </v-card>   -->
                                    <!--                         </v-card>
                                                            <v-card ripple  >
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
                                                <v-card @click.native="clckTeclado('.')" color="light-blue darken-4">
                                                    <v-card-text>
                                                        <div class="headline white--text text-xs-center">.</div>
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

                                                <v-btn :ripple="false" @click="clckQuitarPropina" block color="amber darken-4 white--text"
                                                       dark large
                                                       v-if="this.porcentajePropina==0.0">Sin propina
                                                </v-btn>
                                                <v-btn :ripple="false" @click="clckQuitarPropina" block color="white black--text"
                                                       dark large v-if="this.porcentajePropina!=0.0"> Con
                                                    propina
                                                </v-btn>
                                                <v-btn :disabled="!desacBtnActualizar" :ripple="false" @click="clckActualizar" block
                                                       color="teal darken-4" dark large>Actualizar
                                                </v-btn>

                                                <!-- <v-btn large v-if="((this.cobrarEfectivo+this.cobrarTarjeta)-(this.totalOrdenMostrar*this.porcentajePropina+this.totalOrdenMostrar))>=0"  block :ripple="false" color="light-green darken-4" dark @click="clckConstanciaPago">Constacia Pago </v-btn>
                                                --><!--
                            <v-btn-toggle block v-model="toggle_exclusive"  ><v-btn block :ripple="false"    color=""     @click="clckQuitarPropina">Sin Propina</v-btn></v-btn-toggle> -->

                                                <!-- <v-card  color="blue-grey darken-3" @click.native="clckTeclado(9)"  >
                                                 <v-card-text>
                                                   <div class="headline white--text text-xs-center">9</div>
                                                 </v-card-text>
                                                 </v-card>
                                                 -->
                                            </v-flex>
                                            <v-flex xs12>

                                                <v-flex xs12>
                                                    <v-card @click.native="clckConstancia" class=" text-xs-center "
                                                            color="orange darken-4">
                                                        <v-card-text>
                                                            <br>
                                                            <span class="title  white--text">Cobrar </span>
                                                            <v-divider></v-divider>
                                                            <br>
                                                        </v-card-text>
                                                    </v-card>
                                                </v-flex>

                                            </v-flex>
                                        </v-layout>
                                    </v-card>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-flex>

                <v-flex class="right" sm6 xs12>
                    <br>
                    <v-layout row wrap>

                        <v-flex xs12>

                            <!-- <v-btn color="orange darken-3" @click="clckBlock">Salir</v-btn> -->
                            <v-btn-toggle mandatory v-model="toggle_exclusiveImprimir">
                                <v-btn :disabled="!desacBtnCobrar" :ripple="false" @click="imprimir" color="amber accent-4"
                                       depressed large>Ticket
                                </v-btn>
                                <v-btn :disabled="!desacBtnEnviar" :ripple="false" @click="clckEnviar" color="green darken-4"
                                       depressed large>Enviar
                                </v-btn>
                            </v-btn-toggle>
                            <v-btn-toggle mandatory v-model="toggle_exclusiveAtras">
                                <v-btn :ripple="false" @click="clckSubirDeCarpeta" color="lime darken-4" depressed
                                       large>
                                    Atras
                                </v-btn>
                            </v-btn-toggle>
                        </v-flex>
                        <v-flex xs12>
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
                :timeout=3000
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
<script src="./cobrar_orden.js"/>
