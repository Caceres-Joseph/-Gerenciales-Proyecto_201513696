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
                :headers="encabezado"
                :items="items"
                :search="buscar"
                class="elevation-1"
                item-key="nombre"
        >
            <template slot="items" slot-scope="props">


                <td class="text-xs-center"
                    v-for="(it, key, index) in props.item"
                >{{it }}
                </td>


                <td class="justify-center layout px-0">


                    <v-btn color="red darken-2" dark depressed @click="clckVer(props.item)" class="mx-0"

                    >
                        Deudas
                    </v-btn>
                    <v-btn  depressed  @click="clckVerCancelado(props.item)" class="mx-0"

                    >
                        Cancelados
                    </v-btn>
                </td>

            </template>
            <template slot="no-data">
                No hay datos
            </template>
        </v-data-table>

    </v-container>
</template>

<script src="./eTabla.js">
</script>

