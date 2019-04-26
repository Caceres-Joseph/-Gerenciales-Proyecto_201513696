<template>
    <v-container fluid>

        <!-- CONFIRMAR -->


        <!--<v-dialog max-width="500px" v-model="dlgConfirmar">
            <v-card>
                <v-card-title>
                    <span class="headline">¿Seguro que desea efectuar la operación?</span>
                </v-card-title>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click.native="insertar" color="green darken-4" dark>Aceptar</v-btn>
                    <v-btn @click.native="dlgConfirmar = false" color="blue darken-1" flat>Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>-->


        <!-- CONFIRMAR -->

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
                            @click.native="insertar"
                            color="green darken-4"
                            dark
                            depressed
                            large
                            ref="focoFinalizar">
                        Aceptar
                    </v-btn>

                    <v-btn
                            @click.native="dlgConfirmar = false"
                            color="blue-grey lighten-4"
                            depressed
                            large>
                        Cancelar
                    </v-btn>
                </v-card-actions>

            </v-card>
        </v-dialog>


        <!-- Nuevo  -->
        <v-dialog max-width="500px" v-model="dialogNuevoProducto">
            <v-card>
                <v-card-title>
                    <span class="headline">{{this.itemSubProductoActual.nombre}}</span>
                </v-card-title>
                <v-card-text>
                    <v-flex xs12>
                        <v-text-field
                                @keyup="keyUpSubProductoCantidad"
                                label="Cantidad"
                                ref="txtCantidad"
                                required
                                v-model="itemSubProducto.cantidad"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field @keyup="keyUpSubProductoCompra" label="Precio Compra" placeholder="0,00"
                                      prefix="Q." v-mask-decimal.br="2"
                                      v-model="itemSubProducto.compra"></v-text-field>
                    </v-flex>
                    <br>
                    <v-flex xs12>
                        <v-layout row wrap>
                            <v-flex xs1>
                                <v-checkbox @change="checkBoxVencimiento" color="blue darken-3" hide-details
                                            v-model="modelChekVencimiento">
                                </v-checkbox>
                            </v-flex>
                            <!--<v-flex xs11>
                                <v-menu
                                        :close-on-content-click="false"
                                        :disabled="!modelChekVencimiento"
                                        :nudge-right="40"
                                        :return-value.sync="date2"
                                        full-width
                                        lazy
                                        min-width="290px"
                                        offset-y
                                        ref="menu2"
                                        transition="scale-transition"
                                        v-model="menu2"
                                >
                                    <v-text-field
                                            label="Fecha de vencimiento"
                                            prepend-icon="event"
                                            readonly
                                            slot="activator"
                                            v-model="date2"
                                    ></v-text-field>
                                    <v-date-picker no-title scrollable v-model="date2">
                                        <v-spacer></v-spacer>
                                        <v-btn @click="menu2 = false" color="primary" flat>Cancel</v-btn>
                                        <v-btn @click="$refs.menu2.save(date2)" color="primary" flat>OK</v-btn>
                                    </v-date-picker>
                                </v-menu>
                            </v-flex>-->

                            <!-- Fecha comprobante -->

                            <v-flex xs11>
                                <v-menu
                                        :close-on-content-click="false"
                                        :disabled="!modelChekVencimiento"
                                        :nudge-right="40"

                                        :return-value.sync="date"
                                        full-width
                                        lazy
                                        min-width="290px"
                                        offset-y
                                        ref="menu2"
                                        transition="scale-transition"
                                        v-model="menu2"
                                >
                                    <v-text-field
                                            label="Fecha del comprobante"
                                            prepend-icon="event"
                                            readonly
                                            slot="activator"
                                            v-model="date2"
                                    ></v-text-field>
                                    <v-date-picker @input="$refs.menu2.save(date2)" locale="es"
                                                   v-model="date2"></v-date-picker>

                                </v-menu>
                            </v-flex>

                        </v-layout>
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex xs12>
                        <v-text-field disabled label="Total" placeholder="0" prefix="Q." v-mask-decimal.br="2"
                                      v-model="itemSubProducto.total"></v-text-field>
                    </v-flex>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click.native="insertarSubProducto" color="green darken-4" dark>Aceptar</v-btn>
                    <v-btn @click.native="dialogNuevoProducto = false" color="blue darken-1" flat>Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- Steep -->

        <v-stepper
                v-model="e6"
                vertical>
            <!-- Nuevo  -->
            <v-card-title>
                <span class="headline">Nuevo Ingreso</span>
            </v-card-title>

            <v-stepper-step
                    :complete="e6 > 1"
                    editable
                    step="1">
                Datos del comprobante
                <small>Numero de factura/recibo</small>
            </v-stepper-step>
            <v-stepper-content step="1">

                <v-card-text>
                    <v-layout row wrap>
                        <!-- <v-flex xs12 >
                            <v-card flat color="grey lighten-3"  >
                                <v-layout row wrap>
                                    <v-flex xs12 sm4>
                                        <v-checkbox v-model="modelChekBodega" hide-details color="blue darken-3" label="Bodega" @change="checkBoxProveedor">
                                        </v-checkbox>
                                    </v-flex>
                                </v-layout>
                            </v-card>
                        </v-flex>  -->
                        <!-- Tipo Comprobante -->
                        <v-flex sm5 xs12>
                            <v-text-field autofocus box label="Tipo Comprobante" placeholder="Tipo de comprobante"
                                          ref="txtTipoComprobante"
                                          v-model="item.comprobante"></v-text-field>
                        </v-flex>

                        <v-spacer></v-spacer>

                        <!-- Num Comprobante -->
                        <v-flex sm6 xs12>
                            <v-text-field box label="Num. Comprobante" placeholder="Número de comprobante"
                                          v-model="item.numComprobante"></v-text-field>
                        </v-flex>


                        <v-flex xs12>
                            <v-menu
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    :return-value.sync="date"
                                    full-width
                                    lazy
                                    min-width="290px"
                                    offset-y
                                    ref="menu"
                                    transition="scale-transition"
                                    v-model="menu"
                            >
                                <v-text-field
                                        label="Fecha del comprobante"
                                        prepend-icon="event"
                                        readonly
                                        slot="activator"
                                        v-model="date"
                                ></v-text-field>
                                <v-date-picker @input="$refs.menu.save(date)" locale="es"
                                               v-model="date"></v-date-picker>

                            </v-menu>
                        </v-flex>
                        <v-btn
                                :disabled="(item.comprobante==null||item.comprobante=='')||(item.numComprobante==null||item.numComprobante=='')?true:false"
                                @click.native="e6 = 2,focoProveedor()"
                                color="primary"
                                dark
                                depressed
                                large>
                            Siguiente
                        </v-btn>
                        <v-btn
                                @click.native="cancelar"
                                depressed
                                large>Cancelar
                        </v-btn>

                    </v-layout>
                </v-card-text>
            </v-stepper-content>
            <v-stepper-step
                    :complete="e6 > 2"
                    step="2">Ingresar productos
            </v-stepper-step>
            <v-stepper-content step="2">
                <!-- Proveedor -->

                <v-layout row wrap>
                    <v-flex xs12>
                        <v-layout row wrap>
                            <v-flex sm4 xs12>
                                <v-checkbox @change="checkBoxProveedor" color="blue darken-3" hide-details
                                            label="Proveedor"
                                            ref="checkProveedor" v-model="modelChekProveedor">
                                </v-checkbox>
                            </v-flex>
                            <v-spacer></v-spacer>

                            <!--<v-flex sm8 xs12>
                                <v-select :disabled="!modelChekProveedor" :items="proveedores" @change="cbCambioProveedor"
                                          autocomplete item-text="nombre"
                                          placeholder="Seleccione" v-model="cbModelProveedor">
                                </v-select>
                            </v-flex>-->

                            <v-flex
                                    sm8
                                    xs12>
                                <v-select

                                        :clearable="true"
                                        :disabled="!modelChekProveedor"
                                        :items="proveedores"
                                        @change="cbCambioProveedor"
                                        autocomplete
                                        item-text="nombre"
                                        placeholder="Seleccione"
                                        v-model="cbModelProveedor">
                                </v-select>
                            </v-flex>


                        </v-layout>
                    </v-flex>

                    <v-flex xs12>
                        <v-card class="white--text" color="blue-grey darken-2"
                                v-if="cbModelProveedor != null&&modelChekProveedor == true">
                            <v-card-title primary-title>
                                <div class="subheading text-center">¿Se canceló la compra?</div>
                                <v-divider></v-divider>
                                <br>
                                <div class="subheading text-xs-center" v-if="item.checkCancelado"> Si</div>
                                <div class="subheading text-xs-center" v-else>No</div>
                            </v-card-title>
                            <v-card-actions class="text-xs-center">
                                <v-checkbox
                                        color="yellow accent-2"
                                        hide-details
                                        ref="checkCancelado"
                                        v-model="item.checkCancelado"
                                >
                                </v-checkbox>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                    <v-divider inset></v-divider>
                    <br>

                    <!-- Productos a Ingresar -->

                    <v-flex xs12>
                        <v-layout row wrap>
                            <v-flex xs12>
                                <v-subheader>Producto</v-subheader>
                            </v-flex>

                            <v-flex sm2 xs12>
                                <v-btn @click="refrescarSubProductos,focoProductos" color="grey" fab flat>
                                    <div>
                                        <v-icon>autorenew</v-icon>
                                    </div>
                                </v-btn>
                            </v-flex>
                            <v-flex sm10 xs12>
                                <v-select
                                        :items="articulosCombo"
                                        @change="cbCambioProducto" autocomplete
                                        item-text="nombre" placeholder="Seleccione" ref="focoProductos"
                                        v-model="cbModelProductos">
                                </v-select>
                            </v-flex>

                        </v-layout>
                    </v-flex>

                    <v-divider inset></v-divider>
                    <br>

                    <v-flex xs12>
                        <v-data-table
                                :disable-initial-sort="true"
                                :headers="headers"
                                :items="subProductosItems"
                                class="elevation-1"
                        >
                            <template slot="items" slot-scope="props">
                                <td class="text-xs-left">{{ props.item.cantidad }}</td>
                                <td class="text-xs-left">{{ props.item.nombre }}</td>
                                <td class="text-xs-right">{{ props.item.compra }}</td>
                                <td class="text-xs-right">{{ props.item.total }}</td>
                                <td class="text-xs-left">{{ props.item.vencimiento }}</td>

                                <td class="justify-center layout px-0">
                                    <!--  <v-btn icon class="mx-0" @click="editItem(props.item)">
                                         <v-icon color="teal">edit</v-icon>
                                     </v-btn> -->
                                    <v-btn @click="deleteItem(props.item)" class="mx-0" icon>
                                        <v-icon color="pink">delete</v-icon>
                                    </v-btn>
                                </td>

                            </template>
                            <template slot="no-data">
                                <v-btn @click="inicializar" flat></v-btn>
                            </template>
                        </v-data-table>
                    </v-flex>
                    <v-spacer></v-spacer>
                    <br>
                    <v-divider inset></v-divider>
                    <v-flex xs12>
                        <h3>Total Q {{this.item.totalCompleto}}</h3>
                    </v-flex>

                    <br>


                </v-layout>

                <v-card-actions class="text-xs-center">
                    <v-checkbox
                            :class="item.checkGasto=!modelChekProveedor || (cbModelProveedor == null) || item.checkCancelado"
                            color="blue darken-4"
                            hide-details
                            label="Agregar a gastos"
                            v-model="item.checkGasto"
                    >
                    </v-checkbox>
                </v-card-actions>


                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                            @click.native="dlgConfirmar=true,focoFinalizar()"
                            color="blue darken-4"
                            dark
                            depressed
                            large>
                        Aceptar
                    </v-btn>
                    <v-btn
                            @click.native="cancelar"
                            color="blue-grey lighten-4"
                            depressed
                            large>
                        Cancelar
                    </v-btn>
                </v-card-actions>

            </v-stepper-content>

        </v-stepper>

        <!-- Snackbar -->
        <v-snackbar
                :color="snackColor"
                :timeout=4000
                button
                v-model="snackStatus"
        >
            {{ sanckText }}
            <!-- <v-btn    @click.native="snackStatus = false">Cerrar</v-btn> -->
            <div>
                <v-btn :color="snackColor" @click.native="snackStatus = false" dark depressed small>Cerrar</v-btn>
            </div>
        </v-snackbar>
    </v-container>
</template>

<script src="./nuevo.js">

</script>
 