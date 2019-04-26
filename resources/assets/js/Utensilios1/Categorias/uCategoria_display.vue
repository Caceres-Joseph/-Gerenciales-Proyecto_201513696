<template>
    <v-container fluid>

        <!-- Dialogo  -->
        <v-dialog
                max-width="500px"
                v-model="dlgEliminar">

            <v-card>
                <v-card-title>
                    <span class="headline">Confirmar eliminado</span>
                </v-card-title>
                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                            @click.native="btnEliminar"
                            color="red darken-3"
                            dark
                            depressed
                            large>Eliminar
                    </v-btn>
                    <v-btn
                            @click.native="dlgEliminar = false"
                            color="blue-grey lighten-4"
                            depressed
                            large>Cancelar
                    </v-btn>
                </v-card-actions>
            </v-card>

        </v-dialog>


        <!-- Tabla  -->
        <v-data-table
                :disable-initial-sort="true"
                :headers="headers"
                :items="items"
                :search="buscarGlobal"
                class="elevation-1"
                item-key="nombre"
        >
            <template slot="items" slot-scope="props">

                <td class="text-xs-left">{{ props.item.nombre }}</td>
                <td class="text-xs-left">{{ props.item.persona }}</td>
                <td class="text-xs-left">
                    <v-checkbox
                            disabled
                            hide-details
                            v-model="props.item.activo"
                    ></v-checkbox>
                </td>
                <td class="justify-center layout px-0">
                    <v-btn
                            @click="clckEditar(props.item)"
                            class="mx-0" icon >
                        <v-icon color="teal">edit</v-icon>
                    </v-btn>
                    <v-btn
                            @click="clckEliminar(props.item)"
                            class="mx-0" icon >
                        <v-icon color="pink">delete</v-icon>
                    </v-btn>
                </td>

            </template>
            <template slot="no-data">
                No hay datos
            </template>
        </v-data-table>

        <!-- Boton flotante -->
        <v-btn
                :color="colorDefecto"
                @click="clckNuevo"
                bottom
                dark
                fab
                fixed
                right
        >
            <div>
                <v-icon medium>add</v-icon>
            </div>
        </v-btn>


    </v-container>
</template>

<script src="./uCategoria_display.js">
</script>

