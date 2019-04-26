<template>
    <v-container fluid>

        <v-card color="grey lighten-3">
            <v-card-title>
                <span class="headline">Nuevo registro de persona</span>
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
                    <v-flex sm4 xs12>
                        <v-text-field
                                box
                                label="Tipo Documento"
                                v-model="item.tipo_documento"
                        ></v-text-field>
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex sm7 xs12>
                        <v-text-field
                                box
                                label="No. Documento"
                                v-model="item.num_documento"
                        ></v-text-field>
                    </v-flex>
                    <v-flex sm7 xs12>
                        <v-text-field
                                box
                                label="direccion"
                                v-model="item.direccion"
                        ></v-text-field>
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex sm4 xs12>
                        <v-text-field
                                box
                                label="telefono"
                                v-model="item.telefono"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field
                                box
                                label="correo"
                                v-model="item.correo"
                        ></v-text-field>
                    </v-flex>


                    <v-flex xs12>
                        <v-card color="white"
                        >
                            <v-card-text>

                               <span > Seleccione un Rol:</span>
                                <v-select :items="roles"
                                          autocomplete
                                          item-text="nombre"
                                          item-value="idRol"
                                          placeholder="Rol"
                                          v-model="cbRolModel"
                                          color
                                          @change="cbCambioNuevoRol"
                                          solo-inverted
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

<script src="./personas_nuevo.js">
</script>
