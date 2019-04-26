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

                <tr @click="props.expanded = !props.expanded">
                    <td class="text-xs-center"
                        v-for="(it, key, index) in props.item"
                    >{{it }}
                    </td>
                </tr>

            </template>
            <template slot="no-data">
                No hay datos
            </template>

            <template slot="expand" slot-scope="props" >
                <v-card color="blue-grey lighten-5" flat>
                    <!--<v-card-actions>
                        <v-btn @click="clckVer(props.item)" class="mx-0" color="light-blue darken-3" dark depressed
                        >
                            Asistencia
                        </v-btn>

                    </v-card-actions>-->


                    <v-card-actions>
                        <v-btn
                                @click.native="clckAsistencia(props.item)"
                                color="blue-grey lighten-4"
                                depressed
                                large
                        >
                            Asistencia
                        </v-btn>
                        <v-btn
                                color="light-blue darken-3"
                                dark
                                depressed
                                large
                        >
                            Abono
                        </v-btn>
                        <v-btn
                                color="orange darken-2"
                                depressed
                                large
                                dark
                        >
                            Retiro
                        </v-btn>
                        <v-btn
                                color="teal darken-2"
                                dark
                                depressed
                                large
                        >
                            Saldo
                        </v-btn>
                        <v-spacer></v-spacer>
                    </v-card-actions>

                </v-card>
            </template>

        </v-data-table>

    </v-container>
</template>

<script src="./eTabla.js">
</script>

