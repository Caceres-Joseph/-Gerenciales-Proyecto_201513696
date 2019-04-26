<template>
    <v-container fluid>

        <v-card color="grey lighten-3">
            <v-card-title>
                <span class="headline">Editar sueldo base</span>
            </v-card-title>
            <v-card-text>
                <v-layout
                        row
                        wrap>
                    <v-flex xs12>
                        <v-layout
                                row
                                wrap
                        >

                            <!-- Seleccionar persona -->


                            <v-flex xs12 >
                                <v-card flat color="teal darken-3" dark>
                                    <v-card-text>

                                        <span class="headline"> <strong>{{this.itemEnviar.nombre}}</strong> </span>
                                        <br>
                                        <span class="headline"> Id: <strong>{{this.itemEnviar.idPersona}}</strong> </span>
                                        <br>
                                        <span class="headline"> Contraseña: <strong>{{this.itemEnviar.password}}</strong></span>
                                    </v-card-text>
                                </v-card>
                            </v-flex>


                            <v-divider inset></v-divider>
                            <br>
                            <v-divider inset></v-divider>
                            <br>

                            <v-flex xs12>
                                <eTiempo
                                        ref="tiempo"
                                        texto="Horas laborales al día - HH:mm "
                                >
                                </eTiempo>
                            </v-flex>


                            <v-flex xs12>
                                <v-card flat color="blue-grey lighten-4">
                                    <v-card-text>
                                        <v-layout
                                                row
                                                wrap
                                        >


                                            <v-flex
                                                    xs12>

                                                <span class="subheading">Calcular el sueldo por hora</span>
                                            </v-flex>
                                            <!-- Precio Venta -->
                                            <v-flex sm5 xs12>
                                                <v-text-field
                                                        box
                                                        label="Días"
                                                        placeholder="0"
                                                        v-mask-number
                                                        v-model="item2.dia"
                                                ></v-text-field>
                                            </v-flex>
                                            <v-spacer></v-spacer>
                                            <!-- Precio Venta -->
                                            <v-flex sm6 xs12>
                                                <v-text-field
                                                        box
                                                        label="Sueldo"
                                                        placeholder="0,00"
                                                        prefix="Q."
                                                        v-mask-decimal.us="2"
                                                        v-model="item2.sueldo"
                                                ></v-text-field>
                                            </v-flex>


                                            <!-- Precio Venta -->
                                            <v-flex   xs12>
                                                <span class="subheading">Sueldo diario: Q{{this.item2.sueldoDia}} </span>
                                            </v-flex>

                                        </v-layout>
                                    </v-card-text>
                                    <v-card-actions>

                                        <v-btn
                                                :color="colorDefecto"
                                                @click.native="clckCalcular"
                                                dark
                                                depressed
                                                large>Calcular
                                        </v-btn>

                                    </v-card-actions>
                                </v-card>
                            </v-flex>


                            <!-- Precio Hora -->
                            <v-flex xs12 sm5>
                                <v-text-field box label="Sueldo/Hora" placeholder="0,00" prefix="Q."
                                              v-mask-decimal.us="2" v-model="itemEnviar.sueldoHora"></v-text-field>
                                <!--  -->
                            </v-flex>
                            <v-spacer></v-spacer>
                            <!-- Precio Hora Extra -->
                            <v-flex xs12 sm6>
                                <v-text-field box label="Sueldo/Hora_Extra" placeholder="0,00"
                                              prefix="Q." v-mask-decimal.us="2"
                                              v-model="itemEnviar.sueldoExtra"></v-text-field>
                                <!--  -->
                            </v-flex>


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

<script src="./usuario_editar.js">
</script>
