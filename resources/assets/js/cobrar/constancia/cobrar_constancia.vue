<template>
    <v-layout column ref="fcTxtIdOrden">
        <!-- CORTESIA  -->

        <v-dialog max-width="500px" v-model="dlgCortesia">
            <v-card>
                <v-card-title>
                    <span class="headline">Venta de cortesía.</span>
                </v-card-title>
                <v-card-text>
                    <v-text-field
                            label="Observación"
                            ref="fcTxtCortesia"
                            v-model="cortesiaModelObservacion"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click.native="clckAceptarCortesia" color="green darken-4" dark>Aceptar</v-btn>
                    <v-btn @click.native="dlgCortesia = false" color="blue darken-1" flat>Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>


        <v-container>
            <v-card color="grey lighten-3">
                <v-card-text>
                    <v-layout row wrap>
                        <v-flex sm6 xs12>
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <!--  <v-card color="teal darken-4"> orange darken-4-->
                                    <v-card color="yellow accent-4">
                                        <v-card-text>
                                            <v-layout row wrap>
                                                <v-flex xs6>
                                                    <span class="display-1 black--text text-xs-rigth">Total Q</span>
                                                </v-flex>
                                                <v-flex xs6>
                                                    <span class="display-1 black--text text-xs-left">Orden#{{this.idOrden}}</span>
                                                </v-flex>
                                                <v-flex class="text-xs-right" xs12>
                                                    <span class="display-3 black--text text-xs-left">{{(this.cobrarTotal+this.cobrarPropina).toFixed(2)}}</span>
                                                </v-flex>
                                            </v-layout>
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                                <v-flex xs12>
                                    <v-card color="orange darken-4">
                                        <v-layout row wrap>
                                            <v-flex xs8>
                                                <!-- Teclado -->
                                                <v-card color="blue-grey darken-3" flat>
                                                    <v-layout row wrap>
                                                        <v-flex xs12>
                                                            <v-card height="122">
                                                                <span class="display-3 black--text text-xs-center ">{{this.modelEntradaCalculadora}}</span>
                                                            </v-card>
                                                        </v-flex>
                                                        <v-flex xs4>
                                                            <v-card @click.native="clckTeclado(1)"
                                                                    color="blue-grey darken-3">
                                                                <v-card-text>
                                                                    <div class="headline white--text text-xs-center">1
                                                                    </div>
                                                                </v-card-text>
                                                            </v-card>
                                                        </v-flex>
                                                        <v-flex xs4>
                                                            <v-card @click.native="clckTeclado(2)"
                                                                    color="blue-grey darken-3">
                                                                <v-card-text>
                                                                    <div class="headline white--text text-xs-center">2
                                                                    </div>
                                                                </v-card-text>
                                                            </v-card>
                                                        </v-flex>
                                                        <v-flex xs4>
                                                            <v-card @click.native="clckTeclado(3)"
                                                                    color="blue-grey darken-3">
                                                                <v-card-text>
                                                                    <div class="headline white--text text-xs-center">3
                                                                    </div>
                                                                </v-card-text>
                                                            </v-card>
                                                        </v-flex>
                                                        <v-flex xs4>
                                                            <v-card @click.native="clckTeclado(4)"
                                                                    color="blue-grey darken-3">
                                                                <v-card-text>
                                                                    <div class="headline white--text text-xs-center">4
                                                                    </div>
                                                                </v-card-text>
                                                            </v-card>
                                                        </v-flex>
                                                        <v-flex xs4>
                                                            <v-card @click.native="clckTeclado(5)"
                                                                    color="blue-grey darken-3">
                                                                <v-card-text>
                                                                    <div class="headline white--text text-xs-center">5
                                                                    </div>
                                                                </v-card-text>
                                                            </v-card>
                                                        </v-flex>
                                                        <v-flex xs4>
                                                            <v-card @click.native="clckTeclado(6)"
                                                                    color="blue-grey darken-3">
                                                                <v-card-text>
                                                                    <div class="headline white--text text-xs-center">6
                                                                    </div>
                                                                </v-card-text>
                                                            </v-card>
                                                        </v-flex>
                                                        <v-flex xs4>
                                                            <v-card @click.native="clckTeclado(7)"
                                                                    color="blue-grey darken-3">
                                                                <v-card-text>
                                                                    <div class="headline white--text text-xs-center">7
                                                                    </div>
                                                                </v-card-text>
                                                            </v-card>
                                                        </v-flex>
                                                        <v-flex xs4>
                                                            <v-card @click.native="clckTeclado(8)"
                                                                    color="blue-grey darken-3">
                                                                <v-card-text>
                                                                    <div class="headline white--text text-xs-center">8
                                                                    </div>
                                                                </v-card-text>
                                                            </v-card>
                                                        </v-flex>
                                                        <v-flex xs4>
                                                            <v-card @click.native="clckTeclado(9)"
                                                                    color="blue-grey darken-3">
                                                                <v-card-text>
                                                                    <div class="headline white--text text-xs-center">9
                                                                    </div>
                                                                </v-card-text>
                                                            </v-card>
                                                        </v-flex>
                                                        <v-flex xs4>
                                                            <v-card @click.native="clckTeclado('.')"
                                                                    color="blue-grey darken-3">
                                                                <v-card-text>
                                                                    <div class="headline white--text text-xs-center">.
                                                                    </div>
                                                                </v-card-text>
                                                            </v-card>
                                                        </v-flex>
                                                        <v-flex xs4>
                                                            <v-card @click.native="clckTeclado(0)"
                                                                    color="blue-grey darken-3">
                                                                <v-card-text>
                                                                    <div class="headline white--text text-xs-center">0
                                                                    </div>
                                                                </v-card-text>
                                                            </v-card>
                                                        </v-flex>
                                                        <v-flex class="text-xs-center" xs4>
                                                            <v-card @click.native="clckCortesia" color="blue-grey lighten-3"
                                                                    height="64">
                                                                <v-card-text>
                                                                    <v-icon large>redeem</v-icon>
                                                                </v-card-text>
                                                            </v-card>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-card>
                                            </v-flex>
                                            <v-flex xs4>

                                                <v-btn :ripple="false" @click="clckTecladoBorrarTodo" block class="mx-0" color="orange darken-3"
                                                       dark depressed large>
                                                    <v-icon large>cancel</v-icon>
                                                </v-btn>
                                                <v-btn :ripple="false" @click="clckTecladoBorrar" block class="mx-0" color="orange darken-3"
                                                       dark depressed large>
                                                    <v-icon large>backspace</v-icon>
                                                </v-btn>
                                                <v-btn :ripple="false" @click="clckEfectivo" block class="mx-0" color="indigo darken-3"
                                                       dark depressed large>
                                                    <v-icon large>attach_money</v-icon>
                                                </v-btn>

                                                <v-layout row wrap>
                                                    <v-flex v-if="this.cobrarCambio>=0" xs12>
                                                        <v-card :disabled="!desacBtnGracias" @click.native="clckGracias" @shortkey="clckGracias"
                                                                class=" text-xs-center " color="red darken-4" dark
                                                                flat v-shortkey="['enter']">
                                                            <v-card-text>
                                                                <br>
                                                                <!-- <span class="title  white--text">Gracias</span>  -->
                                                                <v-icon large>sentiment_very_satisfied</v-icon>
                                                                <v-divider></v-divider>
                                                                <br>
                                                            </v-card-text>
                                                        </v-card>
                                                    </v-flex>
                                                    <v-flex v-else xs12>
                                                        <v-card color="orange darken-4" flat height="112">
                                                        </v-card>
                                                    </v-flex>
                                                </v-layout>
                                                <v-divider></v-divider>
                                                <v-btn :ripple="false" @click="clckTarjeta"
                                                       @shortkey="clckTarjeta" block class="mx-0" color="indigo darken-4" dark
                                                >
                                                    <v-icon large>credit_card</v-icon>
                                                </v-btn>
                                                <v-divider></v-divider>
                                                <v-btn :ripple="false" @click="clckPropina" block color="orange darken-3" dark
                                                       depressed large>Propina
                                                </v-btn>


                                            </v-flex>

                                        </v-layout>
                                    </v-card>
                                </v-flex>

                                <!--
                                  |- - - - - - - - - - - -
                                  | TECLADO
                                  |- - - - - - - - - - - -
                                -->


                                <!--
                                  |- - - - - - - - - - - -
                                  | BOTONES
                                  |- - - - - - - - - - - -
                                -->

                                <v-flex xs4>
                                    <v-card flat>
                                        <v-layout row wrap>

                                            <v-flex xs12>


                                                <!-- <v-btn block :ripple="false" color="deep-orange darken-3" dark @click="clckTecladoBorrar">Borrar</v-btn>
                                                <v-btn block :ripple="false" color="deep-orange darken-3" dark @click="clckTecladoBorrarTodo">Borrar Todo</v-btn> -->
                                                <!-- <v-btn block :ripple="false" color="primary" dark @click="clckTecladoEnter">Listo</v-btn>   -->
                                                <!--    <v-btn block :ripple="false" :disabled="!desacBtnActualizar"  color="secondary" dark @click="clckActualizar">Actualizar </v-btn> -->
                                                <!--
                                                  <v-btn-toggle block v-model="toggle_exclusive"  ><v-btn block :ripple="false"    color=""     @click="clckQuitarPropina">Sin Propina</v-btn></v-btn-toggle> -->

                                                <!-- <v-card  color="blue-grey darken-3" @click.native="clckTeclado(9)"  >
                                                 <v-card-text>
                                                   <div class="headline white--text text-xs-center">9</div>
                                                 </v-card-text>
                                                 </v-card>
                                                 -->
                                            </v-flex>
                                        </v-layout>
                                    </v-card>
                                </v-flex>


                                <v-flex xs12>
                                    <!--cobrarPropina  -->
                                    <!--  <v-card color="teal darken-4"> orange darken-4-->
                                    <v-card color="lime lighten-2" v-if="this.cobrarPropina>0">
                                        <v-card-text>
                                            <v-layout row wrap>
                                                <v-flex xs12>
                                                    <span class="title black--text text-xs-rigth">Subtotal Q</span>
                                                </v-flex>
                                                <v-flex class="text-xs-right" xs12>
                                                    <span class="title black--text text-xs-left">{{(this.cobrarSubTotal).toFixed(2)}}</span>
                                                </v-flex>
                                                <v-flex xs12>
                                                    <span class="title black--text text-xs-rigth">Propina</span>
                                                </v-flex>
                                                <v-flex class="text-xs-right" xs12>
                                                    <span class="title black--text text-xs-left">{{(this.cobrarPropina).toFixed(2)}}</span>
                                                </v-flex>
                                            </v-layout>
                                        </v-card-text>
                                    </v-card>
                                </v-flex>


                            </v-layout>
                        </v-flex>
                        <!--
                          |- - - - - - - - - - - -
                          | SALIDA
                          |- - - - - - - - - - - -
                        -->

                        <v-flex sm6 xs12>
                            <v-layout row wrap>
                                <v-card>
                                    <v-flex xs12>
                                        <v-card color="light-blue darken-2" flat>
                                            <v-card-text>


                                                <v-layout row wrap>
                                                    <v-flex xs12>
                                                        <span class="display-1 white--text text-xs-rigth">Efectivo Q</span>
                                                    </v-flex>
                                                    <v-flex class="text-xs-right" xs12>
                                                        <span class="display-3 white--text text-xs-left">{{(this.cobrarEfectivo).toFixed(2)}}</span>
                                                    </v-flex>
                                                </v-layout>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>

                                    <v-flex xs12>
                                        <v-card color="light-blue darken-3" flat v-if="this.cobrarTarjeta!=0">
                                            <v-card-text>
                                                <v-layout row wrap>
                                                    <v-flex xs12>
                                                        <span class="display-1 white--text text-xs-rigth">Tarjeta Q.</span>
                                                    </v-flex>
                                                    <v-flex class="text-xs-right" xs12>
                                                        <span class="display-3 white--text">{{(this.cobrarTarjeta).toFixed(2)}}</span>
                                                    </v-flex>
                                                </v-layout>
                                            </v-card-text>
                                        </v-card>
                                        <v-card @click.native="llenarTarjeta" @shortkey="llenarTarjeta" color="blue-grey lighten-1" flat
                                                height="160" v-else
                                                v-shortkey="['ctrl','l']">
                                            <v-card-text>
                                                <v-layout row wrap>
                                                    <v-flex class="text-xs-center" xs12>
                                                        <v-icon :size="100" dark>credit_card</v-icon>
                                                    </v-flex>
                                                </v-layout>

                                            </v-card-text>
                                        </v-card>
                                    </v-flex>

                                    <v-flex xs12>

                                        <v-card color="light-blue darken-4" flat height="222">
                                            <v-card-text>
                                                <v-layout row wrap>
                                                    <v-flex xs12>
                                                        <span class="display-1 white--text text-xs-rigth">Devolución Q.</span>
                                                    </v-flex>
                                                    <v-flex class="text-xs-right white--text" xs12>
                                                        <span class="display-3">{{(this.cobrarCambio).toFixed(2)}}</span>
                                                    </v-flex>
                                                </v-layout>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>
                                </v-card>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-card-text>
            </v-card>
        </v-container>

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

<script src="./cobrar_constancia.js">