<template>
    <v-container fluid>

        <v-card color="grey lighten-3">
            <v-card-title>
                <span class="headline">Nuevo Usuario</span>
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
                    <v-flex sm6 xs12>
                        <v-text-field
                                box
                                label="Contraseña"
                                type="password"
                                v-model="item.password"
                        ></v-text-field>
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex sm5 xs12>
                        <v-text-field
                                box
                                label="Repita la contraseña"
                                type="password"
                                v-model="item.password1"
                        ></v-text-field>
                    </v-flex>


                    <v-flex xs12>
                        <v-card color="white"
                        >
                            <v-card-text>

                                <span> Seleccione una persona:</span>
                                <v-select
                                        :items="personas" @change="cbCambioNuevoUsuario" autocomplete color
                                        item-text="nombre" placeholder="Seleccione"
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

<script src="./usuario_nuevo.js">
</script>
