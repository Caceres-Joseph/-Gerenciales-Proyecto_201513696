<template>
    <v-container fluid>

        <v-dialog
                max-width="500px"
                v-model="dlgConfirmar">
            <v-card>
                <v-card-title>
                    <span class="headline">¿Seguro que desea efectuar la operación?</span>
                </v-card-title>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                            @click.native="clckDlgAceptar"
                            color="green darken-4"
                            dark>Aceptar
                    </v-btn>
                    <v-btn
                            @click.native="dlgConfirmar = false"
                            color="blue darken-1"
                            flat>Cancelar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!--Para las fracciones prro  -->
        <v-dialog
                max-width="500px"
                v-model="dlgFraccion">
            <v-card color="grey lighten-3">
                <v-card
                        color="blue darken-4"
                        flat>
                    <v-card-title primary-title>
                        <v-layout
                                row
                                wrap>
                            <v-flex xs12>
                                <span class="headline white--text">{{this.dlgFracDatos.nombre}}</span>
                            </v-flex>
                            <v-flex xs5>
                                <span class="subheading white--text text-xs-left">idArticulo:{{this.dlgFracDatos.idArticulo}}</span>
                            </v-flex>
                        </v-layout>
                    </v-card-title>
                </v-card>
                <v-card-text>
                    <v-layout
                            row
                            wrap>
                        <v-flex xs12>
                            <v-text-field
                                    disabled
                                    placeholder="Ingrese en enteros"
                                    prefix="Nota:"></v-text-field>
                            <!-- <span class="title gray--text" >Ingrese en fracciones</span> -->
                        </v-flex>
                        <v-flex xs12>
                            <v-layout
                                    row
                                    wrap>
                                <v-flex
                                        v-if="dlgFracItems.entero!=null"
                                        xs10>
                                    <v-text-field
                                            flat
                                            label="Cantidad"
                                            ref="txtFraccion"
                                            v-mask-number
                                            v-model="dlgFracItems.entero"></v-text-field>
                                </v-flex>
                                        <v-flex
                                                v-if="dlgFracItems.numerator!=null"
                                                xs1>
                                            <!-- entero -->
                                            <v-text-field
                                                    color="blue"
                                                    flat
                                                    solo
                                                    :disabled="true"
                                                    v-mask-number
                                                    v-model="dlgFracItems.numerator"></v-text-field>
                                            <v-divider></v-divider>
                                        </v-flex>
                                        <v-flex
                                                v-if="dlgFracItems.denominator!=null"
                                                xs1>
                                            <v-text-field
                                                    flat
                                                    flat
                                                    :disabled="true"
                                                    v-mask-number
                                                    v-model="dlgFracItems.denominator"></v-text-field>
                                        </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                            @click.native="clckDlgAceptarFraccion"
                            color="blue darken-3"
                            dark
                            depressed
                            large>Aceptar
                    </v-btn>
                    <v-btn
                            @click.native="dlgFraccion = false"
                            color="blue darken-1"
                            flat>Cancelar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- Nuevo  -->
        <v-card color="grey lighten-3">
            <v-card-title>
                <span class="headline">Inventario</span>
            </v-card-title>
            <v-card-text>

                <!-- Productos a Ingresar -->

                <v-flex xs12>
                    <v-card color="white">
                        <v-layout
                                row
                                wrap>
                            <v-flex xs12>
                                <v-subheader>Producto</v-subheader>
                            </v-flex>

                            <v-flex xs2>

                            </v-flex>
                            <v-flex xs10>
                                <v-select
                                        :clearable="true"
                                        :items="desserts"
                                        @change="cbCambioProducto"
                                        autocomplete
                                        item-text="nombre"
                                        placeholder="Seleccione"
                                        ref="borrarProducto"
                                        :v-model="cbModelProductos"
                                >
                                </v-select>
                            </v-flex>

                        </v-layout>
                    </v-card>
                </v-flex>
            </v-card-text>
            <v-card-text>
                <v-layout
                        row
                        wrap>
                    <v-flex xs12>
                        <v-card color="orange darken-3">
                            <v-card-text>
                                <v-layout
                                        row
                                        wrap>
                                    <v-flex xs12>

                                        <v-btn
                                                :ripple="false"
                                                @click="clckImprimirPreTicket"
                                                color="orange darken-4"
                                                dark
                                                depressed
                                                large>
                                            <v-icon>print</v-icon>
                                            Pre-Ticket
                                        </v-btn>

                                        <v-btn
                                                :ripple="false"
                                                @click="clckAceptarInventario"
                                                color="red darken-4"
                                                dark
                                                depressed
                                                large> Aceptar
                                        </v-btn>
                                        <!-- <v-btn dark  large   depressed :ripple="false" color="orange darken-4" @click="clckImprimir" ><v-icon>print</v-icon> Imprimir</v-btn> -->
                                        <!-- <v-btn dark  large   depressed :ripple="false" color="orange darken-4" @click="clckInsertar" ><v-icon>add</v-icon> Insertar</v-btn> -->
                                    </v-flex>
                                    <v-flex
                                            md5
                                            xs12>
                                        <v-text-field
                                                dark
                                                flat
                                                label="idInventario"
                                                solo-inverted
                                                v-mask-number
                                                v-model="txtIdInventario"></v-text-field>
                                    </v-flex>
                                    <v-flex
                                            md7
                                            xs12>
                                        <v-btn
                                                :ripple="false"
                                                @click="clckInventarioAnterior"
                                                color="orange darken-4"
                                                dark
                                                depressed
                                                large> Cargar Inventario
                                        </v-btn>
                                    </v-flex>
                                </v-layout>
                            </v-card-text>
                        </v-card>

                    </v-flex>


                    <v-divider inset></v-divider>
                    <br>

                    <v-flex xs12>
                        <v-data-table
                                :disable-initial-sort="true"
                                :headers="headers"
                                :hide-actions="true"
                                :items="subProductosItems"
                                class="elevation-1">
                            <template
                                    slot="items"
                                    slot-scope="props">

                                <td class="text-xs-left">{{ props.item.idArticulo }}</td>
                                <td class="text-xs-left">{{ props.item.nombre }}</td>
                                <td class="text-xs-center">{{ props.item.stock }}</td>

                                <td
                                        class="text-xs-center"
                                        v-if="props.item.fraccionStockFisico.denominator==1">{{
                                    props.item.fraccionStockFisico.numerator }}
                                </td>

                                <td
                                        class="text-xs-center"
                                        v-else>{{
                                    improperFractionToMixedNumber(props.item.fraccionStockFisico.numerator,
                                    props.item.fraccionStockFisico.denominator) }}
                                </td>

                                <td class="justify-center layout px-0">
                                    <v-btn
                                            @click="editItem(props.item)"
                                            class="mx-0"
                                            icon>
                                        <v-icon color="black">edit</v-icon>
                                    </v-btn>

                                    <v-btn
                                            @click="deleteItem(props.item)"
                                            class="mx-0"
                                            icon>
                                        <v-icon color="pink">delete</v-icon>
                                    </v-btn>
                                </td>
                            </template>
                            <template slot="no-data">
                                <v-btn
                                        @click="inicializar"
                                        flat></v-btn>
                            </template>
                        </v-data-table>
                    </v-flex>
                    <v-spacer></v-spacer>
                    <br>
                    <v-divider inset></v-divider>

                    <br>
                </v-layout>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <!-- <v-btn color="blue darken-4"  dark @click.native="clckAceptarInventario">Aceptar</v-btn>
            <v-btn
                color="blue darken-1"
                flat
                @click.native="clckCancelar">Cancelar</v-btn> -->
            </v-card-actions>
        </v-card>

        <!-- Snackbar -->
        <v-snackbar
                :color="snackColor"
                :timeout=4000
                button
                v-model="snackStatus">
            {{ sanckText }}
            <!-- <v-btn    @click.native="snackStatus = false">Cerrar</v-btn> -->
            <div>
                <v-btn
                        :color="snackColor"
                        @click.native="snackStatus = false"
                        dark
                        depressed
                        small>Cerrar
                </v-btn>
            </div>
        </v-snackbar>
    </v-container>
</template>

<script src="./inventario.js">

</script>
