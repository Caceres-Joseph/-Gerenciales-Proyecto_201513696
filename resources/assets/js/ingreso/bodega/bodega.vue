<template>
  <v-container fluid>
    <!-- Dialog para eliminar -->
    <v-dialog v-model="dialog" max-width="500px">
  
      <v-card>
        <v-card-text>
          <span>Confirmar eliminado</span>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="teal darken-4" dark @click.native="eliminar">Eliminar</v-btn>
          <v-btn color="blue darken-1" flat @click.native="close">Cancelar</v-btn>
  
        </v-card-actions>
      </v-card>
  
    </v-dialog>
    <!-- Dialog para Ver -->
    <v-dialog v-model="verDialogModel" max-width="500px">
  
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
                    <v-list-tile-title  ><span class="grey--text">Descripción: </span> {{this.verDescripcion}}</v-list-tile-title>
                </v-flex>  
                <v-spacer></v-spacer>
                <v-flex xs6 >
                    <v-list-tile-title ><span class="grey--text">Código: </span>{{this.verCodigo}}</v-list-tile-title>
                </v-flex> 
                 <v-flex xs6>
                    <v-list-tile-title ><span class="grey--text">Stock Minimo: </span>{{this.verStockMinimo}}</v-list-tile-title>
                </v-flex> 
                <v-spacer></v-spacer>
                <v-flex xs6>
                    <v-list-tile-title ><span class="grey--text">Precio Compra: Q.</span>{{this.verPrecioCompra}}</v-list-tile-title>
                </v-flex>   
                <v-flex xs6 >
                    <v-list-tile-title ><span class="grey--text">Precio Venta: Q.</span>{{this.verPrecioVenta}}</v-list-tile-title>
                </v-flex>  
                <v-spacer></v-spacer>
                <v-flex xs6>
                    <v-list-tile-title ><span class="grey--text">UnidadDeMedida: </span>{{this.verUnidadDeMedida}}</v-list-tile-title>
                </v-flex> 
                <v-flex xs6 >
                    <v-list-tile-title ><span class="grey--text">Categoria: {{this.verCategoriaPadre}}</span>{{this.verCategoria}}</v-list-tile-title>
                </v-flex> 
                <v-flex xs6 >
                    <v-list-tile-title ><span class="grey--text">Lugar donde se sirve: </span>{{this.verLugarServir}}</v-list-tile-title>
                </v-flex> 

                <v-flex xs12 >
                    <v-list>
                      <v-list-group v-model="verGroupModelBoolean" v-for="item in verGroupItems" :key="item.title" :prepend-icon="item.icono" :no-action="true">
                          <v-list-tile slot="activator">
                              <v-list-tile-content>
                                  <v-list-tile-title>{{ item.texto }}</v-list-tile-title>
                              </v-list-tile-content>
                          </v-list-tile>
                          <v-list-tile v-for="subItem in verGroupSubProductos" :key="subItem.idArticulo">
                              <v-list-tile-content>
                                  <v-list-tile-title>{{ subItem.cantidad }}.  {{ subItem.nombreSubProducto }}</v-list-tile-title>
                              </v-list-tile-content> 
                          </v-list-tile>
                      </v-list-group>
                    </v-list>
                </v-flex> 
          </v-layout>
        </v-card-text>
        <v-card-actions>
          <v-btn flat color="orange" @click="cerrarVerDialog" >Cerrar</v-btn> 
        </v-card-actions> 
      </v-card>
  
    </v-dialog>
    <!-- Opciones de menu -->
    <v-card-title>
      <span class="grey--text hidden-xs-only">Articulos</span><br>
      <v-spacer></v-spacer>
      <v-text-field append-icon="search" label="Buscar" single-line hide-details v-model="search"></v-text-field>
      <!-- <v-menu offset-x :close-on-content-click="false" :nudge-width="200" v-model="menuModel">
        <v-btn icon slot="activator">
          <v-icon color="grey">more_vert</v-icon>
        </v-btn>
        <v-card>
          <v-list>
            <v-layout row wrap>
              <v-flex xs12>
                <v-checkbox v-model="checkDescripcion" hide-details color="blue darken-3"  label="Descripción">
                </v-checkbox>
              </v-flex>
              <v-flex xs12>
                <v-checkbox v-model="checkCodigo" hide-details color="blue darken-3" label="Codigo">
                </v-checkbox>
              </v-flex>
              <v-flex xs12>
                <v-checkbox v-model="checkStockMinimo" hide-details color="blue darken-3" label="StockMinimo">
                </v-checkbox>
              </v-flex>
              <v-flex xs12>
                <v-checkbox v-model="checkCompra" hide-details color="blue darken-3" label="Compra">
                </v-checkbox>
              </v-flex>
              <v-flex xs12>
                <v-checkbox v-model="checkVenta" hide-details color="blue darken-3" label="Venta">
                </v-checkbox>
              </v-flex>
              <v-flex xs12>
                <v-checkbox v-model="checkCategoria" hide-details color="blue darken-3" label="Categoría">
                </v-checkbox>
              </v-flex>
              <v-flex xs12>
                <v-checkbox v-model="checkMedida" hide-details color="blue darken-3" label="Medida">
                </v-checkbox>
              </v-flex>
            </v-layout>
          </v-list>
        </v-card>
      </v-menu> -->
    </v-card-title>
  
    <!-- Tabla de Items -->
    <v-data-table :disable-initial-sort="true"  :headers="tablaEncabezado"   :items="tableItems" class="elevation-1" :search="search"  >
      <template slot="items" slot-scope="props">
              <td class="text-xs-left">{{ props.item.nombre }}</td>
              <td class="text-xs-left">{{ props.item.descripcion }}</td> 
              <td class="text-xs-left">{{ props.item.codigo }}</td>
              <td class="text-xs-left">{{ props.item.stockMinimo }}</td>
              <td class="text-xs-left">{{ props.item.precioCompraDefecto }}</td> 
              <td class="text-xs-left">{{ props.item.precioVentaDefecto }}</td> 
              
              <td class="justify-center layout px-0"> 
                <v-btn icon class="mx-0" @click="viewItem(props.item)">
                  <v-icon  color="grey darken-3">remove_red_eye</v-icon>
                </v-btn>
                <v-btn icon class="mx-0" @click="editItem(props.item)">
                  <v-icon color="teal">edit</v-icon>
                </v-btn>
                <v-btn icon class="mx-0" @click="deleteItem(props.item)">
                  <v-icon color="pink">delete</v-icon>
                </v-btn>
              </td>  
      </template>

      <template slot="no-data">
        <!-- <v-btn color="primary" @click="inicializar">
          No hay datos para mostrar</v-btn> -->
      </template>
    </v-data-table> 

    <v-btn
        fab
        bottom
        right
        color="teal darken-4"
        dark
        fixed 
        @click="nuevaCategoria"
      >
      <v-icon>add</v-icon>
    </v-btn>
     
    
  </v-container>
</template>

<script>
export default {
    props: ['ip'],
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
    verLugarServir:"",
    verImagen: "",
    verSizeImagen: "",

    verGroupModel: "Sub Productos",
    verGroupModelBoolean:false,
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
        text: "Nombre",
        value: "nombre"
      },
      {
        text: "Descripcion",
        value: "descripcion"
      },
      {
        text: "Código",
        value: "codigo"
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

  created() {
    this.inicializar();
  },

  methods: {
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
      this.verGroupModelBoolean=false;
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
    cerrarVerDialog(){
      this.verDialogModel=false;
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
        .catch(function() {
          //this.$log.info("FAILURE!!");
        });

      this.close();
    },
    nuevaCategoria() {
      this.$router.push({
        name: "articulo_nuevo"
      });
    }
  }
};
</script>