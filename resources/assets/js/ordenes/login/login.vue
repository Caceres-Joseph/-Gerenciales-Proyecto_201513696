<template>
    <v-app id="inspire">


        <v-layout column>


            <v-menu
                    :close-on-content-click="false"
                    :nudge-width="200"
                    offset-x
                    v-model="menu"
            >

                <v-btn color="blue-grey darken-4" dark icon slot="activator">
                    <v-icon>keyboard</v-icon>
                </v-btn>


                <v-card>
                    <v-layout row wrap>

                        <v-flex class="headline" xs12>
                            <v-card-text>
                                <v-text-field  ref="txtPassword"  label="Contraseña" solo-inverted type="password" v-model="txtPassword"></v-text-field>
                            </v-card-text>
                        </v-flex>

                        <v-flex xs8>
                            <v-card color="blue-grey darken-3">
                                <v-layout row wrap>

                                    <v-flex xs4>
                                        <v-card @click.native="clckTeclado(1)" color="blue-grey darken-3">
                                            <v-card-text>
                                                <div class="headline white--text text-xs-center">1</div>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>
                                    <v-flex xs4>
                                        <v-card @click.native="clckTeclado(2)" color="blue-grey darken-3">
                                            <v-card-text>
                                                <div class="headline white--text text-xs-center">2</div>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>
                                    <v-flex xs4>
                                        <v-card @click.native="clckTeclado(3)" color="blue-grey darken-3">
                                            <v-card-text>
                                                <div class="headline white--text text-xs-center">3</div>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>
                                    <v-flex xs4>
                                        <v-card @click.native="clckTeclado(4)" color="blue-grey darken-3">
                                            <v-card-text>
                                                <div class="headline white--text text-xs-center">4</div>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>
                                    <v-flex xs4>
                                        <v-card @click.native="clckTeclado(5)" color="blue-grey darken-3">
                                            <v-card-text>
                                                <div class="headline white--text text-xs-center">5</div>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>
                                    <v-flex xs4>
                                        <v-card @click.native="clckTeclado(6)" color="blue-grey darken-3">
                                            <v-card-text>
                                                <div class="headline white--text text-xs-center">6</div>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>
                                    <v-flex xs4>
                                        <v-card @click.native="clckTeclado(7)" color="blue-grey darken-3">
                                            <v-card-text>
                                                <div class="headline white--text text-xs-center">7</div>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>
                                    <v-flex xs4>
                                        <v-card @click.native="clckTeclado(8)" color="blue-grey darken-3">
                                            <v-card-text>
                                                <div class="headline white--text text-xs-center">8</div>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>
                                    <v-flex xs4>
                                        <v-card @click.native="clckTeclado(9)" color="blue-grey darken-3">
                                            <v-card-text>
                                                <div class="headline white--text text-xs-center">9</div>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>
                                    <v-flex xs4>
                                        <v-card @click.native="clckTeclado('#')" color="blue-grey darken-3">
                                            <v-card-text>
                                                <div class="headline white--text text-xs-center">#</div>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>
                                    <v-flex xs4>
                                        <v-card @click.native="clckTeclado(0)" color="blue-grey darken-3">
                                            <v-card-text>
                                                <div class="headline white--text text-xs-center">0</div>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>
                                    <v-flex xs4>
                                        <v-card @click.native="clckTeclado('*')" color="blue-grey darken-3">
                                            <v-card-text>
                                                <div class="headline white--text text-xs-center">*</div>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>
                                </v-layout>
                            </v-card>
                        </v-flex>
                        <v-flex xs4>
                            <v-btn :ripple="false" @click="clckTecladoEnter" block color="primary" dark depressed large>
                                Listo
                            </v-btn>
                            <v-btn :ripple="false" @click="clckTecladoBorrar" block color="deep-orange darken-3" dark depressed
                                   large>Borrar
                            </v-btn>
                        </v-flex>
                    </v-layout>
                </v-card>
            </v-menu>
            <span class="headline">RESTAURANTE MIRADOR --BIENVENIDOS--</span>

            <v-card-text>

                <v-layout row wrap>
                    <v-flex sm8 xs12>
                        <div class="headline">
                            <v-select
                                    :clearable="true"
                                    :items="cards"
                                    @change="cbCambioProducto"
                                    autocomplete
                                    color
                                    item-text="title"
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

                    </v-flex>
                </v-layout>
            </v-card-text>
            <v-flex xs12>
                <v-card flat height="250">
                    <v-parallax :height="800" src="/storage/images/categorias/fondo3.png">
                    </v-parallax>
                </v-card>
            </v-flex>
            <v-card flat>
                <v-container fluid grid-list-md>
                    <v-layout row wrap>
                        <br>
                        <v-flex
                                :key="card.title"
                                sm4
                                v-for="card in cards" xs12
                        >
                            <v-card :color="card.color" @click.native="clckVerMesas(card)" dark>
                                <v-container fluid grid-list-lg>
                                    <v-layout row>
                                        <v-flex xs12>
                                            <div>
                                                <div class="headline">{{card.title}}</div>
                                                <!-- <div>Ellie Goulding</div> -->
                                            </div>
                                        </v-flex>
                                        <!-- <v-flex xs5>
                                          <v-card-media
                                            src="/storage/images/categorias/logoMirador.jpeg"
                                            height="125px"
                                            contain
                                          ></v-card-media>
                                        </v-flex> -->
                                    </v-layout>
                                </v-container>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card>
        </v-layout>
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
    </v-app>
</template>
<script src="./login.js">