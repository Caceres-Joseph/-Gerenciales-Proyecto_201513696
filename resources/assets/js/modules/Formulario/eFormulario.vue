<template id="formulario">
    <v-container fluid>

        <v-card color="grey lighten-3">
            <v-card-title>
                <span class="headline">{{this.titulo}}</span>
            </v-card-title>
            <v-card-text>
                <v-layout
                        row
                        wrap>
                    <v-flex :key="item.id"
                            v-for="item in jsonPreguntas"
                            xs12
                    >
                        <v-text-field

                                :label="item.texto"
                                box
                                v-bind:autofocus="item.id == 0 ? true : false"
                                v-bind:required="item.obligatorio"
                                v-if="item.tipo==0"
                                :ref="item.id"
                                v-model="itemRetorno[item.nombre]"
                        ></v-text-field>

                        <v-text-field
                                :label="item.texto"
                                box
                                placeholder="0,00"
                                prefix="Q."
                                v-bind:required="item.obligatorio"
                                v-if="item.tipo==1"
                                v-mask-decimal.us="2"
                                v-model="itemRetorno[item.nombre]"
                        ></v-text-field>

                        <v-card color="white"
                                v-if="item.tipo==3"
                        >
                            <v-layout row wrap>
                                <v-flex xs12 sm4>
                                    <v-checkbox  v-model="item.check" @change="checkBox(item,item.nombre)" hide-details :color="color" :label="item.texto" >
                                    </v-checkbox>

                                </v-flex>
                                <v-spacer></v-spacer>

                                <v-flex xs12 sm8>
                                    <v-select :items="item.valores"
                                              :item-value="item.nombre"
                                              autocomplete
                                              :disabled="!item.check"
                                              item-text="nombre"
                                              placeholder="Seleccione"
                                              v-model="itemRetorno[item.nombre]"
                                    >
                                    </v-select>

                                </v-flex>
                            </v-layout>
                        </v-card>

                    </v-flex>

                </v-layout>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                        :color="color"
                        @click.native="clckAceptar"
                        dark
                        depressed
                        large>
                    Aceptar
                </v-btn>
                <v-btn
                        @click.native="clckCancelar"
                        color="blue-grey lighten-4"
                        depressed
                        large>
                    Cancelar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script src="./eFormulario.js">
</script>
