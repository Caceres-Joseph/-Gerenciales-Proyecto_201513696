<template>
    <v-container fluid>

        <v-card color="grey lighten-3">
            <v-card-title>
                <span class="headline">Nueva Categoria</span>
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
                                required
                                v-model="item.nombre"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field
                                label="Descripcion"
                                box
                                v-model="item.descripcion"
                        ></v-text-field>
                    </v-flex>


                    <v-flex xs12 >
                        <v-checkbox
                                label="Categoría padre."
                                v-model="item.activo"
                                hide-details
                                :color="colorDefecto"
                        ></v-checkbox>
                    </v-flex>
                    <v-flex xs12 >
                        <v-layout row wrap>

                            <v-icon>home</v-icon>
                            <v-select
                                    prepend-icon="home" box :items="categorias" @change="cbCambioNuevoUsuario" :disabled="!item.activo" autocomplete item-text="nombre"
                                      placeholder="Seleccione" v-model="cbPersonaModel">
                            </v-select>
                        </v-layout>
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

<script src="./uCategoria_nuevo.js">
</script>
