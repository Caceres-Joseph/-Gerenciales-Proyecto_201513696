<template>
    <v-container fluid>

        <v-card color="grey lighten-3">
            <v-card-title>
                <span class="headline">Editar Usuario</span>
            </v-card-title>
            <v-card-text>
                <v-layout
                        row
                        wrap>
                    <v-flex xs12>
                        <v-text-field
                                box
                                label="Nombre"
                                ref="focoNuevo"
                                required
                                v-model="item.nombre"
                        ></v-text-field>
                    </v-flex>

                    <v-flex xs12>
                        <v-layout row>

                            <v-btn @click="clckPass()" icon large>
                                <v-icon color="blue-grey darken-2">remove_red_eye</v-icon>
                            </v-btn>
                            <v-text-field
                                    :type="pass"
                                    label="Contraseña"
                                    v-model="item.password"
                            ></v-text-field>
                        </v-layout>
                    </v-flex>


                    <v-flex xs12>
                        <v-card color="white"
                        >
                            <v-card-text>

                                <span> Seleccione una persona:</span>
                                <v-select
                                        :items="personas"
                                        @change="cbCambioNuevoUsuario"
                                        autocomplete color
                                        item-text="nombre"
                                        item-value="idPersona"
                                        placeholder="Seleccione"
                                        solo-inverted
                                        v-model="cbPersonaModel"
                                >
                                </v-select>
                            </v-card-text>

                        </v-card>
                    </v-flex>

                </v-layout>
            </v-card-text>


            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                        :color="colorDefecto"
                        @click.native="clckAceptar"
                        dark
                        depressed
                        large>Aceptar
                </v-btn>
                <v-btn
                        @click.native="clckCancelar"
                        color="blue-grey lighten-4"
                        depressed
                        large>Cancelar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script src="./usuario_editar.js">
</script>
