<template>
    <v-container fluid>

        <v-card color="blue-grey lighten-4">
            <v-card color="red darken-3">
                <v-card-title primary-title>
                    <span class="headline white--text">Nuevo Gasto </span>
                </v-card-title>
            </v-card>


            <v-stepper
                    v-model="e6"
                    vertical>


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

                            <!-- Tipo Comprobante -->
                            <v-flex sm5 xs12>
                                <v-text-field ref="fcTxtNombre2" box label="Tipo Comprobante" placeholder="Tipo de comprobante"
                                              v-model="item.comprobante"></v-text-field>
                            </v-flex>
                            <v-spacer></v-spacer>
                            <!-- Num Comprobante -->
                            <v-flex sm6 xs12>
                                <v-text-field box label="Num. Comprobante" placeholder="Número de comprobante"
                                              v-model="item.numComprobante"></v-text-field>
                            </v-flex>

                            <!-- Fecha comprobante -->

                                <v-flex xs12 >
                                    <v-menu
                                            ref="menu2"
                                            :close-on-content-click="false"
                                            v-model="menu2"
                                            :nudge-right="40"
                                            :return-value.sync="date"
                                            lazy
                                            transition="scale-transition"
                                            offset-y
                                            full-width
                                            min-width="290px"
                                    >
                                        <v-text-field
                                                slot="activator"
                                                v-model="date"
                                                label="Fecha del comprobante"
                                                prepend-icon="event"
                                                readonly
                                        ></v-text-field>
                                        <v-date-picker locale="es" v-model="date" @input="$refs.menu2.save(date)"></v-date-picker>

                                    </v-menu>
                                </v-flex>

                        </v-layout>

                            <v-btn
                                    :disabled="(item.comprobante==null||item.comprobante=='')||(item.numComprobante==null||item.numComprobante=='')?true:false"
                                    @click.native="e6 = 2, focus2()"
                                    color="primary"
                                    dark
                                    depressed
                                    large>
                                Siguiente
                            </v-btn>
                            <v-btn
                                    @click.native="clckCancelarStepper"
                                    depressed
                                    large>Cancelar
                            </v-btn>

                    </v-card-text>
                </v-stepper-content>
                <v-stepper-step
                        :complete="e6 > 2"
                        step="2">Descripción del gasto
                </v-stepper-step>
                <v-stepper-content step="2">


                    <v-card-text>
                        <v-layout row wrap>
                            <!-- Tipo Comprobante -->
                            <v-flex sm8 xs12>
                                <v-text-field box label="Nombre" placeholder="nombre" ref="fcTxtNombre"
                                              v-model="item.nombre"></v-text-field>
                            </v-flex>

                            <v-spacer></v-spacer>

                            <!-- Num Comprobante -->
                            <v-flex sm3 xs12>
                                <v-text-field box label="Monto" placeholder="0,00" prefix="Q." v-mask-decimal.br="2"
                                              v-model="item.monto"></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-text-field box label="Observacion" placeholder="observacion"
                                              v-model="item.observacion"></v-text-field>
                            </v-flex>

                        </v-layout>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn @click.native="clckAceptar" large depressed color="red darken-4" dark large
                        >Aceptar
                        </v-btn>
                    </v-card-actions>
                </v-stepper-content>

            </v-stepper>
        </v-card>

        <v-snackbar
                :color="snackColor"
                :timeout=3000
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
<script src="./nuevo_gasto.js"/>