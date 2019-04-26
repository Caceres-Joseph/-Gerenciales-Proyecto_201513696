<template>
    <v-container fluid>
        <!-- Eliminar  -->
        <v-dialog max-width="500px" v-model="dialog">
            <v-card>
                <v-card-title>
                    <span class="headline">Confirmar eliminado</span>
                </v-card-title>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click.native="eliminar" color="green darken-4" dark>Eliminar</v-btn>
                    <v-btn @click.native="close" color="blue darken-1" flat>Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- Nuevo  -->
        <v-dialog max-width="500px" v-model="dialogNuevo">
            <v-card>
                <v-card-title>
                    <span class="headline">Nueva unidad de medida</span>
                </v-card-title>
                <v-card-text>
                    <v-flex xs12>
                        <v-text-field
                                :rules="campoObligatorio"
                                label="Nombre"
                                required
                                v-model="item.nombre"

                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field
                                :required="requerido"
                                :rules="campoObligatorio"
                                label="Abreviatura."
                                placeholder="Ejemplo(Kg.)"

                                v-model="item.prefijo"

                        ></v-text-field>
                    </v-flex>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click.native="insertar" color="green darken-4" dark>Aceptar</v-btn>
                    <v-btn @click.native="dialogNuevo = false" color="blue darken-1" flat>Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- Editar  -->
        <v-dialog max-width="500px" v-model="dialogModificar">
            <v-card color="grey lighten-3">
                <v-card-title>
                    <span class="headline">Modificar unidad de medida</span>
                </v-card-title>
                <v-card-text>
                    <v-flex xs12>
                        <v-text-field
                                :rules="campoObligatorio"
                                box
                                label="Nombre"
                                required
                                v-model="itemM.nombre"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field
                                :required="requerido"
                                :rules="campoObligatorio"
                                box
                                label="Abreviatura."

                                placeholder="Ejemplo(Kg.)"
                                v-model="itemM.prefijo"
                        ></v-text-field>
                    </v-flex>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click.native="modificar" color="green darken-4" dark>Aceptar</v-btn>
                    <v-btn @click.native="dialogModificar = false" color="blue darken-1" flat>Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- Tabla  -->
        <v-data-table
                :disable-initial-sort="true"
                :headers="headers"
                :items="medidas"
                :search="buscar"
                class="elevation-1"
        >
            <template slot="items" slot-scope="props">

                <td class="text-xs-left">{{ props.item.nombre }}</td>
                <td class="text-xs-left">{{ props.item.prefijo }}</td>

                <td class="justify-center layout px-0">
                    <v-btn @click="editItem(props.item)" class="mx-0" icon>
                        <v-icon color="teal">edit</v-icon>
                    </v-btn>
                    <v-btn @click="deleteItem(props.item)" class="mx-0" icon>
                        <v-icon color="pink">delete</v-icon>
                    </v-btn>
                </td>

            </template>
            <template slot="no-data">
                <v-btn @click="inicializar" flat></v-btn>
            </template>
        </v-data-table>

        <!-- Boton flotante -->
        <v-btn
                @click="nuevaCategoria"
                bottom
                color="green darken-4"
                dark
                fab
                fixed
                right
        >
            <div>

                <v-icon>add</v-icon>
            </div>
        </v-btn>

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
        props: {
            ip: String,
            buscar: String
        },
        data: () => ({
            /*
            *Display items
            */
            search: "",

            dialog: false,
            headers: [
                {text: "Nombre", value: "nombre"},
                {text: "Prefijo", value: "prefijo"},
                {text: "Acciones", sortable: false}
            ],
            items: [],
            medidas: [],

            itemEliminar: null,

            /*
            *Nueva medida
            */
            dialogNuevo: false,
            item: {},
            exitoso: false,
            requerido: true,

            /*
            *Modificar medida
            */
            dialogModificar: false,
            itemM: {},
            getSearchItem: "",
            /*
            *Funciones
            */
            campoObligatorio: [v => !!v || "Este campo es obligatorio"],

            snackColor: "teal darken-4",
            snackStatus: false,
            sanckText: " "
        }),

        destroyed() {
            document.removeEventListener("keyup", this.atajos);
        },
        mounted() {
            document.addEventListener("keyup", this.atajos);
        },
        computed: {},

        watch: {
            dialog(val) {
                val || this.close();
            }
        },

        created() {
            this.inicializar();
            window.scrollTo(0, 0);
        },

        methods: {
            atajos(event) {
                if (event.ctrlKey && event.code == "KeyN") {
                    this.nuevaCategoria();
                }

            },
            inicializar() {
                let uri = this.ip + "Medida_items";
                this.axios.get(uri).then(response => {
                    this.medidas = response.data;
                });
            },
            editItem(item) {
                this.dialogModificar = true;
                this.itemM.nombre = item.nombre;
                this.itemM.prefijo = item.prefijo;
                this.itemM.idMedida = item.idMedida;
                this.getSearchItem = item;
                /*         this.$router.push({
                  name: "categoria_editar",
                  params: { id: item.idCategoria }
                }); */
            },

            deleteItem(item) {
                this.itemEliminar = item;
                this.dialog = true;
            },

            close() {
                this.dialog = false;
            },

            eliminar() {
                let uri = this.ip + `Medida_delete/${
                    this.itemEliminar.idMedida
                    }`;
                this.axios
                    .get(uri)
                    .then(response => {
                        var index = this.medidas.indexOf(this.itemEliminar);
                        //this.$log.info(index);
                        if (index > -1) {
                            this.medidas.splice(index, 1);
                        }
                        this.mensajeInfo("Item eliminado exitosamente");
                    })
                    .catch(error => {
                        this.mensajeError("No se pudo eliminar el item");
                    });

                this.close();
            },
            /*
            *Nueva medida
            */
            nuevaCategoria() {
                this.dialogNuevo = true;
            },
            sleep2() {
                setTimeout(() => {
                }, 3000);
            },
            insertar() {
                if (this.item.nombre != null && this.item.prefijo != null) {
                    let uri = this.ip + "Medida_insert";


                    this.axios
                        .post(uri, this.item)
                        .then(response => {
                            this.mensajeInfo("Unidad de medida agregada exitosamente");

                            //hay que obtener el indice
                            this.getLatestItem();
                            setTimeout(() => {
                                this.medidas.splice(0, 0, this.getSearchItem);

                                this.item = {};

                            }, 200);

                        })
                        .catch(error => {
                            this.mensajeError("Error al inserta la unidad de medida");
                        });
                    this.requerido = false;
                } else {
                    this.mensajeAdvertencia("Tiene que llenar todos los campos");
                }
                this.dialogNuevo = false;
            },
            sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            },

            /*
            *Modificar medida
            */
            modificar() {
                if (this.itemM.nombre != null && this.itemM.prefijo != null) {
                    let uri = this.ip + `Medida_update/${this.itemM.idMedida}`;
                    this.axios
                        .post(uri, this.itemM)
                        .then(response => {
                            var index = this.medidas.indexOf(this.getSearchItem);
                            //this.$log.info(index);
                            if (index > -1) {
                                var temp = this.medidas[index];
                                temp.nombre = this.itemM.nombre;
                                temp.prefijo = this.itemM.prefijo;
                            }

                            this.mensajeInfo("Unidad de medida modificada exitosamente");
                        })
                        .catch(error => {
                            this.mensajeError("Error al modificar la unidad de medida");
                        });
                } else {
                    this.mensajeAdvertencia("Tiene que llenar todos los campos");
                }
                this.dialogModificar = false;
            },

            getItem(id) {
                let uri = this.ip + `Medida_item/${id}`;
                this.axios.get(uri).then(response => {
                    this.getSearchItem = response.data;
                });
            },
            getLatestItem() {
                let uri = this.ip + "Medida_latest";
                this.axios.get(uri).then(response => {
                    this.getSearchItem = response.data;
                    this.$log.info(this.getSearchItem.idMedida);
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
            }
        }
    };
</script>