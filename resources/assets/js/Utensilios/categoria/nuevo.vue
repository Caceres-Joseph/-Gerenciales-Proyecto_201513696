<template>


    <v-container fluid>
        <v-layout justify-center row wrap>
            <v-flex sm12 xs12>


                <v-card color="grey lighten-3">
                    <v-card-title>
                        <span class="headline">Nuevo Categoría</span>
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
                                <v-select
                                        :disabled="!item.check"
                                        :filter="customFilter"
                                        :items="categorias"
                                        @change="cbCambio"
                                        autocomplete
                                        item-text="nombre"
                                        label="Seleccione"
                                        v-model="a1"
                                >

                                    <template slot="selection" slot-scope="data">
                                        <v-chip
                                                :key="JSON.stringify(data.item)"

                                                :selected="data.selected"
                                                @input="data.parent.selectItem(data.item)"
                                                class="chip--select-multi"

                                        >
                                            {{ data.item.nombre }}
                                        </v-chip>
                                    </template>
                                    <template slot="item" slot-scope="data">
                                        <template v-if="typeof data.item !== 'object'">
                                            <v-list-tile-content v-text="data.item"></v-list-tile-content>
                                        </template>
                                        <template v-else>
                                            <v-list-tile-content>
                                                <v-list-tile-title class="black--text">{{data.item.nombre}}
                                                </v-list-tile-title>
                                                <v-list-tile-sub-title class="#ECEFF1 --text">{{data.item.rutaPadre}}
                                                </v-list-tile-sub-title>
                                                <v-list-tile-sub-title>
                                                    <v-divider></v-divider>
                                                </v-list-tile-sub-title>
                                            </v-list-tile-content>
                                        </template>
                                    </template>
                                </v-select>
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
                customFilter(item, queryText, itemText) {
                    const hasValue = val => (val != null ? val : "");
                    const text = hasValue(item.nombre);
                    const query = hasValue(queryText);
                    return (
                        text
                            .toString()
                            .toLowerCase()
                            .indexOf(query.toString().toLowerCase()) > -1
                    );
                },
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


                let uri = this.ip + "uCategoria_insertItem";

                if (this.item.nombre == "" || this.item.nombre == null) {
                    this.mensajeAdvertencia("Debe colocar un nombre");
                    return;
                }


                this.axios
                    .post(uri, this.item)
                    .then(response => {
                        this.mensajeInfo("Categoría creada con éxito");
                        this.item = {};
                        this.inicializar();


                    })
                    .catch(error => {
                        this.snackColor = "red";
                        this.snackbar = true;
                        this.$log.info(error.response);
                    });

            },
            subirImagen() {
                if (!this.files2.length) return;
                this.subirImag(this.files2[0]);
            },
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                this.files2 = e.target.files || e.dataTransfer.files;
                this.imageName = files[0].name;

                this.$log.info(files[0].name);

                if (!files.length) return;
                this.createImage(files[0]);
            },
            subirImag(file) {
                let formData = new FormData();
                let uri = this.ip + "upload";
                formData.append("file", file);

                this.axios
                    .post(uri, formData)
                    .then(function () {
                        //this.$log.info("SUCCESS!!");
                    })
                    .catch(function () {
                        //this.$log.info("FAILURE!!");
                    });
            },
            createImage(file) {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = e => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            removeImage: function (e) {
                this.image = "";
                this.files2 = [];
            },
            cargarCategoriaPadre() {

                let uri2 = this.ip + `uCategoria_getItems/0`;
                this.axios.get(uri2).then(response => {
                    this.categorias = response.data;
                });

            },
            cbCambio(e) {

                if (e.idCategoria == parseInt(e.idCategoria, 10)) {
                    this.item.idPadre = e.idCategoria;
                }

            },
            checkBoxCambio(e) {
                if (!e) {//si es falso
                    this.a1 = null;
                    this.item.idPadre=null;
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