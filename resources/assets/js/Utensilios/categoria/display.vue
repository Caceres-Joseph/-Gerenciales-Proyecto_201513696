<template>
    <v-container fluid>

        <v-dialog max-width="500px" v-model="dialog">

            <v-card>
                <v-card-text>
                    <span>Confirmar eliminado</span>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click.native="eliminar" color="teal darken-4" dark>Eliminar</v-btn>
                    <v-btn @click.native="close" color="blue darken-1" flat>Cancelar</v-btn>

                </v-card-actions>
            </v-card>

        </v-dialog>

        <v-card>


            <v-data-table
                    :disable-initial-sort="true"
                    :headers="headers"
                    :items="categorias"
                    :search="buscar"
                    class="elevation-1"
            >
                <template slot="items" slot-scope="props">

                    <!--<td class="justify-left layout px-0">
                      <v-btn icon class="mx-0" @click="editItem(props.item)">
                        <v-icon color="teal">edit</v-icon>
                      </v-btn>
                      <v-btn icon class="mx-0" @click="deleteItem(props.item)">
                        <v-icon color="pink">delete</v-icon>
                      </v-btn>
                        <v-avatar
                            class="grey lighten-4"
                            :size=30
                        >
                            <img v-bind:src="'/statics/greenleaf-logo.png'" alt="avatar">
                        </v-avatar>
                    </td>-->
                    <td class="text-xs-left">{{ props.item.nombre }}</td>
                    <td class="text-xs-left">{{ props.item.descripcion }}</td>
                    <td class="text-xs-left">{{ props.item.ruta }}</td>


                    <!--<td class="justify-center layout px-0">
                        <v-avatar
                            class="grey lighten-4"
                            :size=50
                        >
                            <img v-bind:src="props.item.imagen" alt="avatar">
                        </v-avatar>
                    </td> --><!--
                    <td class="text-xs-left">{{ props.item.rutaPadre }}</td>-->
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
                    No hay datos
                </template>
            </v-data-table>

        </v-card>

        <!-- Boton flotante -->
        <v-btn
                @click="nuevaCategoria"
                bottom
                color="orange darken-4"
                dark
                fab
                fixed
                right
        >
            <div>
                <v-icon>add</v-icon>
            </div>
        </v-btn>

    </v-container>
</template>

<script>
    export default {
        props: {
            ip: String,
            buscar: String
        },
        data: () => ({
            search: "",

            dialog: false,
            headers: [
                {text: "Nombre", value: "nombre"},
                {text: "Descripcion", value: "descripcion"},
                {text: "Ruta Padre", value: "rutaPadre"},
                {text: "Acciones", sortable: false, align: 'center'}
            ],
            items: [],
            editedIndex: -1,
            editedItem: {
                eAction: "",
                nombre: "",
                descripcion: "",
                rutaPadre: "",
                imagen: ""
            },
            defaultItem: {
                eAction: "",
                nombre: "",
                descripcion: "",
                rutaPadre: "",
                imagen: ""
            },

            categorias: [],

            itemEliminar: null
        }),

        computed: {
            formTitle() {
                return this.editedIndex === -1 ? "New Item" : "Edit Item";
            }
        },

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
        },

        methods: {
            atajos() {

                if (event.ctrlKey && event.code == "KeyN") {
                    this.nuevaCategoria();
                }
            },
            inicializar() {

                let uri2 = this.ip + 'uCategoria_getItems2';
                this.axios.get(uri2).then(response => {
                    this.categorias = response.data;
                });

            },
            editItem(item) {
                this.$router.push({
                    name: "categoria_editar",
                    params: {id: item.idCategoria}
                });
            },

            deleteItem(item) {
                this.itemEliminar = item;

                // confirm("Are you sure you want to delete this item?") &&

                this.dialog = true;
            },

            close() {
                //hay que eliminar
                this.dialog = false;
                /* setTimeout(() => {
                  this.editedItem = Object.assign({}, this.defaultItem);
                  this.editedIndex = -1;
                }, 300); */
            },

            eliminar() {
                let uri = this.ip + `uCategoria_delete/${
                    this.itemEliminar.idCategoria
                    }`;
                this.axios
                    .get(uri)
                    .then(response => {
                        var index = this.categorias.indexOf(this.itemEliminar);
                        //this.$log.info(index);
                        if (index > -1) {
                            this.categorias.splice(index, 1);

                        }
                        //this.inicializar();
                        //this.$router.push({ name: "categoria_display" });
                    })
                    .catch(function () {
                        //this.$log.info("FAILURE!!");
                    });

                this.close();
            },
            nuevaCategoria() {
                this.$router.push({name: "categoria_nuevo"});
            }
        }
    };
</script>