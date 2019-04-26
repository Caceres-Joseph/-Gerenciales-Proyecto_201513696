<template>
    <v-layout column>

        <v-card-text>

            <v-layout row wrap>
                <v-flex sm8 xs12>
                    <div class="headline">
                        <v-select
                                :clearable="true"
                                :items="mesas"
                                @change="cbCambioProducto"
                                autocomplete
                                color
                                item-text="nombre"
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

        <v-card flat>
            <v-container fluid grid-list-md>
                <v-layout row wrap>
                    <br>
                    <v-flex
                            :key="card.id"
                            sm4
                            v-for="card in cards" xs12
                    >
                        <v-card>
                            <v-card
                                    :key="mesero.idOrden"
                                    class="white--text"
                                    color="amber darken-4"
                                    v-for="mesero in card.meseros">
                                <v-layout row wrap>
                                    <v-flex xs6>
                                        <span class="subheading"> Orden No.{{mesero.idOrden}}</span>
                                    </v-flex>
                                    <v-flex class="text-xs-rigth" xx6>
                                        <span class="subheading"> Mesero:{{mesero.nombre}}</span>
                                    </v-flex>
                                    <v-flex xs12>
                                        <span class="subheading"> {{mesero.hora}}</span>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-divider></v-divider>
                                        <v-divider></v-divider>
                                        <!-- <span class="subheading" > -------------------------</span> -->
                                    </v-flex>
                                </v-layout>
                                <!-- <div class="subheading">{{mesero.idOrden}} <br> {{mesero.nombre}} </div> -->
                            </v-card>
                            <!-- :color="card.color" class="white--text" -->
                            <v-card color=" light-blue darken-4">
                                <v-card-title primary-title>
                                    <!-- <v-btn icon  flat  large  :color ="card.color">
                                              <v-icon x-large>layers</v-icon>
                                          </v-btn> -->
                                    <!-- <v-btn    fab :ripple="false"    :color="card.color" dark ><v-icon>device_hub</v-icon></v-btn>     -->
                                    <div class="headline white--text ">{{card.title}}</div>
                                </v-card-title>
                                <v-btn :ripple="false" @click="pantallaOrden(card)" color="blue-grey lighten-5" depressed
                                       large>
                                    <span class="subheading"> Nueva. Orden</span>
                                </v-btn>
                            </v-card>
                            <!--

                              <v-card color="light-blue darken-4">
                                     <v-card-actions>
                                         <v-spacer></v-spacer>
                                     </v-card-actions>
                             </v-card>

                             -->
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card>
    </v-layout>
</template>

<script src="./ordenes_mesas.js">