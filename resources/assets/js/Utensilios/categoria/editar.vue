<template>


    <v-container fluid>
        <v-layout justify-center row wrap>
            <v-flex sm12 xs12>


                <v-card color="grey lighten-3">
                    <v-card-title>
                        <span class="headline">Editar Categoría</span>
                    </v-card-title>
                    <v-card-text>
                        <v-layout row wrap>
                            <!-- Nombre -->
                            <v-flex xs12>
                                <v-text-field
                                        :rules="nameRules"
                                        box
                                        color="blue"
                                        label="Nombre"
                                        ref="focoNuevo"
                                        required
                                        v-model="item.nombre"
                                ></v-text-field>
                            </v-flex>
                            <!-- Descripcion -->
                            <v-flex xs12>
                                <v-text-field
                                        :counter="50"
                                        box
                                        label="Descripcion"
                                        v-model="item.descripcion"
                                ></v-text-field>
                            </v-flex>
                            <!-- Categoría padre -->
                            <v-flex sm6 xs12>
                                <v-checkbox
                                        @change="checkBoxCambio"
                                        color="teal darken-3"
                                        hide-details
                                        label="Categoría Padre"
                                        v-model="item.check"
                                >
                                </v-checkbox>
                            </v-flex>
                            <v-flex xs12>

                                <v-flex xs12 >
                                    <v-select :items="categorias"
                                              @change="cbCambio"
                                              autocomplete item-text="nombre"
                                              item-value="idCategoria"
                                              placeholder="Seleccione"
                                              v-model="a1">
                                    </v-select>
                                </v-flex>
                            </v-flex>
                        </v-layout>
                        <!-- Boton   -->


                        <!--
                                 <div class="form-group">
                                  <button class="btn btn-primary">esteSi</button>
                                </div>  -->
                    </v-card-text>


                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                                @click.native="addItem"
                                color="orange darken-4"
                                dark
                                depressed
                                large
                        >Aceptar
                        </v-btn>
                        <v-btn
                                @click.native="clckCancelar"
                                color="blue-grey lighten-4"
                                depressed
                                large
                        >Cancelar
                        </v-btn>
                    </v-card-actions>

                </v-card>
            </v-flex>
        </v-layout>

        <!-- Snackbar -->
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

<script>
    export default {
        props: ['ip'],
        data() {
            return {
                item: {},
                title: "Preliminary report",
                email: "",
                description: "Report describing the state of California",
                snackbar: false,
                text: "Error al insertar la categoria, revise si los datos son correctos",

                snackColor: "teal darken-4",
                snackStatus: false,
                sanckText: " ",

                image: "",
                imageName: "",

                idCategoriaPadre: null,
                a1: null,
                categorias: [],
                files2: [],

                enabled: false,

                nameRules: [
                    v => !!v || "El nombre de la categoría es obligatorio"
                ],
                valid: false
            };
        },
        methods: {
            addItem() {


                let uri = this.ip + `uCategoria_update/${
                    this.$route.params.id
                    }`;

                if (this.item.nombre == "" || this.item.nombre == null) {
                    this.mensajeAdvertencia("Debe colocar un nombre");
                    return;
                }

                this.axios
                    .post(uri, this.item)
                    .then(response => {
                        this.clckCancelar();
                    })
                    .catch(error => {
                        this.mensajeError("Error al modificar el item");
                    });

            },
            cargarCategoriaPadre() {


                let uri = this.ip + `uCategoria_getItem/${
                    this.$route.params.id
                    }`;

                this.axios.get(uri).then(response => {
                    this.item = response.data;


                    let uri2 = this.ip + `uCategoria_getItems/${response.data.idCategoria}`;
                    this.axios.get(uri2).then(response2 => {
                        this.categorias = response2.data;
                        if (response.data.idPadre != null) {
                            //no tiene padre
                            this.item.check = true;
                            this.a1 = response.data.idPadre;
                            this.idCategoriaPadre = response.data.idPadre;
                        }
                    });
                });


            },
            cbCambio(e) {

                if (e == parseInt(e, 10)) {
                    this.item.idPadre = e;
                }

            },
            checkBoxCambio(e) {
                if (!e) {//si es falso
                    this.a1 = null;
                    this.item.idPadre = null;
                }
            },
            clckCancelar() {

                this.$router.push({
                    name: "categoria_display"
                });
            },
            /*
            *Mensajes medida
            */
            mensajeError(mensaje) {
                this.snackColor = "red";
                this.sanckText = "[Error] " + mensaje;
                this.snackStatus = true;
            },
            mensajeInfo(mensaje) {
                this.snackColor = "light-blue darken-4";
                this.sanckText = mensaje;
                this.snackStatus = true;
            },
            mensajeAdvertencia(mensaje) {
                this.snackColor = "amber darken-4";
                this.sanckText = "[Advertencia] " + mensaje;
                this.snackStatus = true;
            },
            inicializar() {
                this.cargarCategoriaPadre();
                this.focoInicio();
            },
            focoInicio() {
                setTimeout(() => {
                    this.$nextTick(this.$refs.focoNuevo.focus);
                }, 500);
            },
        },
        mounted: function () {
            this.inicializar();
        }
    };
</script>