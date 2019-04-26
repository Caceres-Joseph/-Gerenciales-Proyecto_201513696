<template>
    <v-container fluid>

        <v-card color="grey lighten-3">
            <v-card-title>
                <span class="headline">Editar registro de persona</span>
            </v-card-title>
            <v-card-text>
                <v-layout
                        row
                        wrap>
                    <v-flex xs12>
                        <v-text-field
                                label="Nombre"
                                ref="focoNuevo"
                                box
                                v-model="item.nombre"
                                required
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm4>
                        <v-text-field
                                label="Tipo Documento"
                                box
                                v-model="item.tipo_documento"
                        ></v-text-field>
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex xs12 sm7>
                        <v-text-field
                                label="No. Documento"
                                box
                                v-model="item.num_documento"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm7>
                        <v-text-field
                                label="direccion"
                                box
                                v-model="item.direccion"
                        ></v-text-field>
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex xs12 sm4>
                        <v-text-field
                                label="telefono"
                                box
                                v-model="item.telefono"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field
                                label="correo"
                                box
                                v-model="item.correo"
                        ></v-text-field>
                    </v-flex>
  
                    <v-flex xs12>
                        <v-card color="white"
                        >
                            <v-card-text>

                                <span > Seleccione un Rol:</span>
                                <v-select

                                          color
                                          solo-inverted
                                          :items="roles"
                                          @change="cbCambioNuevoRol"
                                          autocomplete
                                          item-text="nombre"
                                          item-value="idRol"
                                          placeholder="Seleccione"
                                          v-model="cbRolModel"
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

<script src="./personas_editar.js">
</script>
