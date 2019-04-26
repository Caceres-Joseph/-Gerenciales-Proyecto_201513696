<template>
    <v-layout class="grey lighten-4" column>

        <v-card-text>

            <v-layout row wrap>
                <v-flex sm8 xs12>
                    <div class="headline">
                        <v-select
                                :clearable="true"
                                :items="lugares"
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
                            :key="card.title"
                            sm4
                            v-for="card in cards" xs12
                    >
                        <v-card @click.native="clckVerMesas(card.id, card.color)" color="blue darken-4" ripple>
                            <v-container fluid grid-list-lg>
                                <v-layout row>
                                    <v-flex xs12>
                                        <div>
                                            <div class="headline  white--text">{{card.title}}</div>
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
                            <!-- <v-btn    fab :ripple="false"    :color="card.color" dark ><v-icon>device_hub</v-icon></v-btn> -->
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card>
    </v-layout>
</template>

<script src="./lugar.js"/>

