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
                    <span class="headline">Nuevo Usuario</span>
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
                                label="Contraseña"
                                v-model="item.password"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-select :items="personas" @change="cbCambioPersona" autocomplete item-text="nombre"
                                  placeholder="Seleccione" v-model="cbRolModel">
                        </v-select>
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
                    <span class="headline">Modificar Usuario</span>
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
                                box
                                label="Contraseña"
                                v-model="itemM.password"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-select :items="personas" @change="cbCambioPersonaEdit" autocomplete item-text="nombre"
                                  item-value="idPersona" placeholder="Seleccione" v-model="itemM.idPersona">
                        </v-select>
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
                <td class="text-xs-left">{{ props.item.password }}</td>
                <td class="text-xs-left">{{ props.item.persona }}</td>

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
                color="amber accent-4"
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
                {text: "Contraseña", value: "password"},
                {text: "Persona", value: "persona"},
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
            sanckText: " ",

            /*
            *COMBO TIPO
             */
            cbRolModel: null,
            roles: [],
            rolSeleccionado: null,
            /*
            *Personas
            */

            personas: []
        }),

        computed: {},

        watch: {
            dialog(val) {
                val || this.close();
            }
        },

        destroyed() {
            document.removeEventListener("keyup", this.atajos);
        },
        mounted() {
            document.addEventListener("keyup", this.atajos);
        },
        created() {
            this.inicializar();
            this.inicializarPersonas();
        },

        methods: {
            atajos(event) {
                if (event.ctrlKey && event.code == "KeyN") {
                    this.nuevaCategoria();
                }
            },
            inicializar() {
                let uri = this.ip + "Usuario_items";
                this.axios.get(uri).then(response => {
                    this.medidas = response.data;
                });
            },
            inicializarPersonas() {
                let uri2 = this.ip + "Persona_items";
                this.axios.get(uri2).then(response => {
                    this.personas = response.data;
                });
            },
            editItem(item) {
                // this.inicializarPersonas();
                let uri = this.ip + `Usuario_item/${item.idUsuario}`;
                this.axios.get(uri).then(response => {
                    this.itemM.idUsuario = item.idUsuario;
                    this.itemM.nombre = item.nombre;
                    this.itemM.password = item.password;
                    this.itemM.idPersona = response.data.idPersona;
                    this.getSearchItem = item;
                    this.dialogModificar = true;
                });

                //no vino categoria

                // this.idMedidaPadre = respuesta.idMedida;

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
                let uri = this.ip + `Usuario_delete/${
                    this.itemEliminar.idUsuario
                    }`;
                this.axios
                    .get(uri)
                    .then(response => {
                        this.inicializar();
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
                this.inicializarPersonas();
            },
            sleep2() {
                setTimeout(() => {
                }, 3000);
            },
            insertar() {
                if (this.item.nombre != null) {
                    let uri = this.ip + "Usuario_insert";
                    this.$log.info(this.item);
                    this.axios
                        .post(uri, this.item)
                        .then(response => {
                            this.mensajeInfo("Item agregado exitosamente");

                            //hay que obtener el indice
                            this.inicializar();
                            this.item = {};
                        })
                        .catch(error => {
                            this.mensajeError("Error al insertar");
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
                if (this.itemM.nombre != null) {
                    let uri = this.ip + `Usuario_update/${
                        this.itemM.idUsuario
                        }`;
                    this.axios
                        .post(uri, this.itemM)
                        .then(response => {
                            this.inicializar();
                            this.mensajeInfo("Item modificado exitosamente");
                        })
                        .catch(error => {
                            this.mensajeError("Error al modificar");
                        });
                } else {
                    this.mensajeAdvertencia("Tiene que llenar todos los campos");
                }
                this.dialogModificar = false;
            },

            getItem(id) {
                let uri = this.ip + `Persona_item/${id}`;
                this.axios.get(uri).then(response => {
                    this.getSearchItem = response.data;
                });
            },
            getLatestItem() {
                let uri = this.ip + "Usuario_latest";
                this.axios.get(uri).then(response => {
                    this.getSearchItem = response.data;
                    this.$log.info(this.getSearchItem.idPersona);
                });
            },

            /*
            *REOLS
             */
            cbCambioPersona(item2) {
                if (item2.idPersona == parseInt(item2.idPersona, 10)) {
                    this.item.idPersona = item2.idPersona;
                }
            },
            cbCambioPersonaEdit(item) {
                if (item != null) {
                    this.itemM.idPersona = item;
                    this.$log.info(item);
                }

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