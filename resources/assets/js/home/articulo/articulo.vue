<template>
    <v-container fluid>
        <!-- Dialog para eliminar -->
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
        <!-- Dialog para Ver -->
        <v-dialog max-width="500px" v-model="verDialogModel">

            <v-card>
                <v-card-media
                        :height="verSizeImagen"
                        :src="verImagen"
                >
                </v-card-media>
                <v-card-text>
                    <v-layout row wrap>
                        <v-flex xs12>
                            <h2 class="headline mb-0">{{this.verNombre}}</h2>
                        </v-flex>
                        <v-flex xs6>
                            <v-list-tile-title><span class="grey--text">Descripción: </span> {{this.verDescripcion}}
                            </v-list-tile-title>
                        </v-flex>
                        <v-spacer></v-spacer>
                        <v-flex xs6>
                            <v-list-tile-title><span class="grey--text">Código: </span>{{this.verCodigo}}
                            </v-list-tile-title>
                        </v-flex>
                        <v-flex xs6>
                            <v-list-tile-title><span class="grey--text">Stock Minimo: </span>{{this.verStockMinimo}}
                            </v-list-tile-title>
                        </v-flex>
                        <v-spacer></v-spacer>
                        <v-flex xs6>
                            <v-list-tile-title><span class="grey--text">Precio Compra: Q.</span>{{this.verPrecioCompra}}
                            </v-list-tile-title>
                        </v-flex>
                        <v-flex xs6>
                            <v-list-tile-title><span class="grey--text">Precio Venta: Q.</span>{{this.verPrecioVenta}}
                            </v-list-tile-title>
                        </v-flex>
                        <v-spacer></v-spacer>
                        <v-flex xs6>
                            <v-list-tile-title><span class="grey--text">UnidadDeMedida: </span>{{this.verUnidadDeMedida}}
                            </v-list-tile-title>
                        </v-flex>
                        <v-flex xs6>
                            <v-list-tile-title><span class="grey--text">Categoria: {{this.verCategoriaPadre}}</span>{{this.verCategoria}}
                            </v-list-tile-title>
                        </v-flex>
                        <v-flex xs6>
                            <v-list-tile-title><span class="grey--text">Lugar donde se sirve: </span>{{this.verLugarServir}}
                            </v-list-tile-title>
                        </v-flex>

                    </v-layout>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="cerrarVerDialog" color="orange" flat>Cerrar</v-btn>
                </v-card-actions>
            </v-card>

        </v-dialog>


        <!-- Tabla de Items -->
        <v-data-table :disable-initial-sort="true" :headers="tablaEncabezado" :items="tableItems" :search="buscar"
                      class="elevation-1">
            <template slot="items" slot-scope="props">
                <td class="text-xs-left">{{ props.item.idArticulo }}</td>
                <td class="text-xs-left">{{ props.item.nombre }}</td>
                <td class="text-xs-left">{{ props.item.nombreMedida }}</td>
                <td class="text-xs-left">{{ props.item.descripcion }}</td>
                <td class="text-xs-left">{{ props.item.stockMinimo }}</td>
                <td class="text-xs-left">{{ props.item.precioCompraDefecto }}</td>
                <td class="text-xs-left">{{ props.item.precioVentaDefecto }}</td>

                <td class="justify-center layout px-0">
                    <v-btn @click="addIngrediente(props.item)" class="mx-0" icon>
                        <v-icon color="grey darken-3">extension</v-icon>
                    </v-btn>
                    <v-btn @click="viewItem(props.item)" class="mx-0" icon>
                        <v-icon color="grey darken-3">remove_red_eye</v-icon>
                    </v-btn>
                    <v-btn @click="editItem(props.item)" class="mx-0" icon>
                        <v-icon color="teal">edit</v-icon>
                    </v-btn>
                    <v-btn @click="deleteItem(props.item)" class="mx-0" icon>
                        <v-icon color="pink">delete</v-icon>
                    </v-btn>
                </td>
            </template>

            <template slot="no-data">
                <!-- <v-btn color="primary" @click="inicializar">
                  No hay datos para mostrar</v-btn> -->
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
            /*
            items: [], */
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

            itemEliminar: null,

            /*
              *----------------------------
              *Dialog ver
              *----------------------------
            */

            verDialogModel: false,
            verNombre: "",
            verDescripcion: "",
            verCodigo: "",
            verStockMinimo: "",
            verPrecioCompra: "",
            verPrecioVenta: "",
            verUnidadDeMedida: "",
            verCategoria: "",
            verCategoriaPadre: "",
            verLugarServir: "",
            verImagen: "",
            verSizeImagen: "",

            verGroupModel: "Sub Productos",
            verGroupModelBoolean: false,
            verGroupItems: [
                {
                    icono: "extension",
                    texto: "Sub Productos",
                    active: false,
                    items: [
                        {
                            texto: "Breakfast & brunch"
                        },
                        {
                            texto: "New American"
                        },
                        {
                            texto: "Sushi"
                        }
                    ]
                }
            ],
            verGroupSubProductos: [],
            /*
              *----------------------------
              *Para el Menu
              *----------------------------
            */

            menuModel: false,

            checkDescripcion: false,
            checkCodigo: false,
            checkStockMinimo: false,
            checkCompra: false,
            checkVenta: false,
            checkCategoria: false,
            checkMedida: false,
            /*
              *----------------------------
              *Para la Tabla
              *----------------------------
            */
            tableItems: [],
            tableHeader: [],
            tableModel: [],
            tablaEncabezado: [
                {
                    text: "id",
                    value: "idArticulo"
                },
                {
                    text: "Nombre",
                    value: "nombre"
                },
                {
                    text: "Medida",
                    value: "nombreMedida"
                },
                {
                    text: "Descripcion",
                    value: "descripcion"
                },
                {
                    text: "Stock Minimo",
                    value: "stockMinimo"
                },
                {
                    text: "P.Compra",
                    value: "precioCompraDefecto"
                },
                {
                    text: "P.Venta",
                    value: "precioVentaDefecto"
                },
                {
                    text: "Acciones",
                    sortable: false
                }
            ]
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
            window.scrollTo(0, 0);
        },

        methods: {
            atajos(event) {
                if (event.ctrlKey && event.code == "KeyN") {
                    this.nuevaCategoria();
                }

            },
            inicializar() {


                let uri = this.ip + "Articulo_items";
                this.axios.get(uri).then(response => {
                    this.tableItems = response.data;
                });
            },
            editItem(item) {
                this.$router.push({
                    name: "articulo_editar",
                    params: {
                        id: item.idArticulo
                    }
                });
            },

            deleteItem(item) {
                this.itemEliminar = item;
                this.dialog = true;
            },
            viewItem(item) {
                //Para cerrar el group model
                this.verGroupModelBoolean = false;
                /* Obteniendo el id de  */
                let uri = this.ip + `categoria_getitem/${item.idCategoria}`;
                this.axios.get(uri).then(response => {
                    this.verCategoriaPadre = response.data.rutaPadre;
                    this.verCategoria = response.data.nombre;
                });

                let uri2 = this.ip + `Medida_item/${item.idMedida}`;
                this.axios.get(uri2).then(response => {
                    this.verUnidadDeMedida = response.data.nombre;
                });

                let uri4 = this.ip + `LugarServir_item/${item.idLugarServir}`;
                this.axios.get(uri4).then(response => {
                    this.verLugarServir = response.data.nombre;
                });


                //this.$log.info(item.idArticulo);
                let uri3 = this.ip + `ArticuloDetalle_getItemsHijos/${item.idArticulo}`;
                this.axios.get(uri3).then(response => {
                    this.verGroupSubProductos = response.data;
                    var temp = response.data;
                    for (let index = 0; index < temp.length; index++) {
                        var element = temp[index];
                        let uri4 = this.ip + `Articulo_item/${
                            element.idArticulo
                            }`;
                        this.axios.get(uri4).then(response => {
                            this.verGroupSubProductos[index].nombreSubProducto =
                                response.data.nombre;
                        });
                    }
                });

                if (item.imagen == "/storage/images/categorias/nada.png") {
                    this.verSizeImagen = "0";
                } else {
                    this.verSizeImagen = "300";
                }
                this.verNombre = item.nombre;
                this.verDescripcion = item.descripcion;
                this.verCodigo = item.codigo;
                this.verStockMinimo = item.stockMinimo;
                this.verPrecioCompra = item.precioCompraDefecto;
                this.verPrecioVenta = item.precioVentaDefecto;
                this.verImagen = item.imagen;
                this.verDialogModel = true;
            },
            cerrarVerDialog() {
                this.verDialogModel = false;
            },
            close() {
                this.dialog = false;
            },

            eliminar() {
                let uri = this.ip + `Articulo_delete/${
                    this.itemEliminar.idArticulo
                    }`;
                this.axios
                    .get(uri)
                    .then(response => {
                        var index = this.tableItems.indexOf(this.itemEliminar);
                        //this.$log.info(index);
                        if (index > -1) {
                            this.tableItems.splice(index, 1);
                            this.$log.info("Eliminado");

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
                this.$router.push({
                    name: "articulo_nuevo"
                });
            },

            addIngrediente(e) {
                this.$router.push({
                    name: "ingredientes",
                    params: {
                        id: e.idArticulo,
                        nombre: e.nombre,
                        medida: e.nombreMedida
                    }
                });
            }
        }
    };
</script>