<template>
  <v-container fluid>

  <v-dialog v-model="dialog" max-width="500px">
      
      <v-card>
        <v-card-text>
          <span  >Confirmar eliminado</span>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="teal darken-4"  dark @click.native="eliminar">Eliminar</v-btn>
          <v-btn color="blue darken-1" flat @click.native="close">Cancelar</v-btn>
         
        </v-card-actions>
      </v-card>
      
    </v-dialog> 


    <v-card>
    <v-data-table
      :headers="headers"
      :items="categorias" 
      class="elevation-1"
      :search="buscar"
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
        
        
        <td class="justify-center layout px-0"> 
            <v-avatar 
                class="grey lighten-4"
                :size=50 
            >
                <img v-bind:src="props.item.imagen" alt="avatar">
            </v-avatar>
        </td> 
        <td class="text-xs-left">{{ props.item.rutaPadre }}</td>
        <td class="justify-center layout px-0"> 
          <v-btn icon class="mx-0" @click="editItem(props.item)">
            <v-icon color="teal">edit</v-icon>
          </v-btn>
          <v-btn icon class="mx-0" @click="deleteItem(props.item)">
            <v-icon color="pink">delete</v-icon>
          </v-btn>
        </td>

      </template>
      <template slot="no-data">
        <v-btn color="primary" @click="inicializar">No hay datos para mostrar</v-btn>
      </template>
    </v-data-table>
  </v-card>
    <v-btn
      fab
      bottom
      right
      color="teal darken-4"
      dark
      fixed 
      @click="nuevaCategoria"
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
    buscar:String
  },
  data: () => ({
    search: "",

    dialog: false,
    headers: [
      { text: "Nombre", value: "nombre" },
      { text: "Descripcion", value: "descripcion" },
      { text: "Imagen", sortable: false },
      { text: "Ruta Padre", value: "rutaPadre" }
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

  destroyed() {
    document.removeEventListener("keyup", this.atajos);
  },
  mounted() {
    document.addEventListener("keyup", this.atajos);
  },
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

    /*
    |--------------------------------------------------------------------------
    | Inicio
    |--------------------------------------------------------------------------
    */
    inicializar() {

      let uri = this.ip + "categoria_items";
      this.axios.get(uri).then(response => {
        this.categorias = response.data;
      });
    },
    editItem(item) {
      this.$router.push({
        name: "categoria_editar",
        params: { id: item.idCategoria }
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
      let uri = this.ip + `categoria_delete/${
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
        .catch(function() {
          //this.$log.info("FAILURE!!");
        });

      this.close();
    },
    nuevaCategoria() {
      this.$router.push({ name: "categoria_nuevo" });
    }
  }
};
</script>