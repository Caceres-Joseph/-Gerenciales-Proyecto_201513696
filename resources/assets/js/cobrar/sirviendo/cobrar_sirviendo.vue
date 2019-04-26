<template>
    <v-layout column>
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

        <v-card flat>
            <v-container fluid grid-list-md>
                <v-layout row wrap>
                    <br>

                    <v-card-text>
                        <v-layout row wrap>
                            <v-flex sm8 xs12>
                                <div class="headline">
                                    <v-select
                                            :clearable="true"
                                            :items="ordenes"
                                            @change="cbCambioProducto"
                                            autocomplete
                                            color
                                            item-text="idOrden"
                                            placeholder="Seleccione"
                                            ref="focoCombo"
                                            solo-inverted
                                            v-model="modeloCombo"
                                    >
                                    </v-select>
                                </div>
                            </v-flex>
                            <v-spacer></v-spacer>
                            <v-flex sm4 xs12>
                                <v-btn :disabled="!desacBtnActualizar" @click="clckActualizar" color="teal darken-4" dark depressed
                                       large>Actualizar
                                </v-btn>
                            </v-flex>
                        </v-layout>
                    </v-card-text>

                    <v-flex
                            :key="card.idOrden"
                            sm4
                            v-for="card in ordenes" xs12
                    >

                        <v-card color="green darken-3" dark>
                            <v-card-title primary-title>
                                <v-layout row wrap>
                                    <v-flex xs6>
                                        <span class="headline"> {{card.nombreLugar}}</span>
                                    </v-flex>
                                    <v-flex class="text-xs-right" xs6>
                                        <span class="headline"> {{card.nombreMesa}}</span>
                                    </v-flex>

                                    <v-flex xs6>
                                        <span class="headline"> {{card.nombreUsuario}}</span>
                                    </v-flex>
                                    <v-flex class="text-xs-right" xs6>
                                        <span class="headline"> Orden #{{card.idOrden}}</span>
                                    </v-flex>
                                    <v-flex xs12>
                                        <span class="subheading">{{card.hora}} </span>
                                    </v-flex>

                                    <v-flex xs6>
                                        <span class="subheading"> SubTotal: </span>
                                    </v-flex>
                                    <v-spacer></v-spacer>
                                    <v-flex class="text-xs-right" xs6>
                                        <span class="title">Q{{card.subtotal}} </span>
                                    </v-flex>
                                    <v-flex xs6>
                                        <span class="subheading">Propina 10%: </span>
                                    </v-flex>
                                    <v-spacer></v-spacer>
                                    <v-flex class="text-xs-right" xs6>
                                        <span class="title">Q{{card.propina}} </span>
                                    </v-flex>
                                    <v-flex class="text-xs-right" xs12>
                                        <span class="subheading">---------------------</span>
                                    </v-flex>
                                    <v-flex xs6>
                                        <span class="subheading"> Total: </span>
                                    </v-flex>
                                    <v-spacer></v-spacer>
                                    <v-flex class="text-xs-right" xs6>
                                        <span class="title">Q{{card.total}} </span>
                                    </v-flex>

                                </v-layout>
                                <!-- <div>
                                  <h3 class="headline mb-0">Kangaroo Valley Safari</h3>

                                  <div>Located two hours south of Sydney in the <br>Southern Highlands of New South Wales, ...</div>
                                </div> -->
                            </v-card-title>
                            <v-card-actions>
                                <v-btn :ripple="false" @click.native="clckVerMesas(card)" color="green darken-4" depressed
                                       large>Ver
                                </v-btn>
                                <v-btn :ripple="false" @click="clckEliminarOrden(card)" color="red darken-3" depressed
                                       large>Eliminar
                                </v-btn>
                                <v-btn :ripple="false" @click="clckDividir(card)" color="lime darken-4" depressed large>
                                    Dividir
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card>
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

<script src="./cobrar_sirviendo.js">