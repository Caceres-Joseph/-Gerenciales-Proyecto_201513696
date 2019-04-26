<template>
  <v-container fluid>
<!-- Eliminar  --> 
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-card-title>
          <span  class="headline">Confirmar eliminado</span>
        </v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-4"  dark @click.native="eliminar">Eliminar</v-btn>
          <v-btn color="blue darken-1" flat @click.native="close">Cancelar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
<!-- Nuevo  --> 
    <v-dialog v-model="dialogNuevo" max-width="500px">
      <v-card  >
        <v-card-title>
          <span class="headline">Nueva Ubicacion</span>
        </v-card-title>
        <v-card-text>
            <v-flex xs12>
                <v-text-field
                  label="Nombre"  
                  v-model="item.nombre"
                  required 
                  :rules="campoObligatorio"
                ></v-text-field>
            </v-flex>
           <v-flex xs12>
               <v-checkbox v-model="item.estado" label="Disponible"  hide-details color="blue darken-3"   >
              </v-checkbox>  
           </v-flex>
            <v-flex xs12 >
                <v-select  autocomplete :items="roles"   v-model="cbRolModel" item-text="nombre"    placeholder="Seleccione" @change="cbCambioNuevoRol">
                </v-select>
            </v-flex>
             

        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-4"  dark @click.native="insertar">Aceptar</v-btn>
          <v-btn color="blue darken-1" flat @click.native="dialogNuevo = false">Cancelar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
<!-- Editar  --> 
    <v-dialog v-model="dialogModificar" max-width="500px">
      <v-card color ="grey lighten-3">
        <v-card-title>
          <span class="headline">Modificar Ubicacion</span>
        </v-card-title>
        <v-card-text>
            <v-flex xs12>
                <v-text-field
                  label="Nombre"  
                  v-model="itemM.nombre"
                  required 
                  :rules="campoObligatorio"
                  box
                ></v-text-field>
            </v-flex>
            <!-- <v-flex xs12 >
                <v-select  autocomplete :items="roles" item-value="idRol"  v-model="itemM.rol" item-text="nombre"    placeholder="Seleccione" @change="cbCambioNuevoRol">
                </v-select>
            </v-flex> -->
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-4"  dark @click.native="modificar">Aceptar</v-btn>
          <v-btn color="blue darken-1" flat @click.native="dialogModificar = false">Cancelar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>


<!-- Tabla  --> 
    <v-data-table
      :headers="headers"
      :items="medidas" 
      class="elevation-1"
      :search="buscar"
      :disable-initial-sort="true"
    >
      <template slot="items" slot-scope="props">
        
        <td class="text-xs-left">{{ props.item.nombre }}</td> 
        <td class="text-xs-left">{{ props.item.lugar }}</td> 
        <td class="text-xs-left">{{ props.item.status }}</td>

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
        <v-btn  flat @click="inicializar"> </v-btn>
      </template>
    </v-data-table>

<!-- Boton flotante -->
    <v-btn
      fab
      bottom
      right
      color="teal darken-3"
      dark
      fixed 
      @click="nuevaCategoria"
    >
        <div>

            <v-icon>add</v-icon>
        </div>
    </v-btn>

<!-- Snackbar -->
    <v-snackbar 
      :timeout=3000
      button   
      v-model="snackStatus"
      :color= "snackColor"
    >
      {{ sanckText }}
      <!-- <v-btn    @click.native="snackStatus = false">Cerrar</v-btn> -->
      <div>
        <v-btn  depressed small  dark :color="snackColor" @click.native="snackStatus = false" >Cerrar</v-btn>
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
      { text: "Nombre", value: "nombre" },
      { text: "Lugar", value: "lugar" },
      { text: "Disponible", value: "status" },
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
    checkModelStatus:true,
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
    rolSeleccionado: null
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
  },

  methods: {
      atajos(event) {
          if (event.ctrlKey && event.code == "KeyN") {
              this.nuevaCategoria();
          }
      },
    inicializar() {
      let uri = this.ip + "Mesa_items";
      this.axios.get(uri).then(response => {
        this.medidas = response.data;
      });

      let uri2 = this.ip + "Lugar_items";
      this.axios.get(uri2).then(response => {
        this.roles = response.data;
      });

      //chek true
      this.item.estado=true;
    },
    editItem(item) {
      this.itemM.idMesa=item.idMesa;
      
             this.dialogModificar = true;
      /*this.itemM.nombre = item.nombre;
      this.itemM.idPersona = item.idPersona;

      this.itemM.tipo_documento = item.tipo_documento;
      this.itemM.num_documento = item.num_documento;
      this.itemM.direccion = item.direccion;
      this.itemM.telefono = item.telefono;
      this.itemM.correo = item.correo; */
      //tengo que ir a traer el id rol
      this.$log.info(item); 


     /*  let uri = this.ip + `Persona_item/${item.idPersona}`;
      this.axios.get(uri).then(response => {
        this.dialogModificar = true;
        this.itemM.nombre = item.nombre;
        this.itemM.idPersona = item.idPersona;

        this.itemM.tipo_documento = item.tipo_documento;
        this.itemM.num_documento = item.num_documento;
        this.itemM.direccion = item.direccion;
        this.itemM.telefono = item.telefono;
        this.itemM.correo = item.correo;

        this.itemM.rol = response.data.idRol;
        this.getSearchItem = item;

      });

        */
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
      let uri = this.ip + `Mesa_delete/${
        this.itemEliminar.idMesa
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
      setTimeout(() => {}, 3000);
    },
    insertar() {
      if (this.item.nombre != null) {
        let uri = this.ip + "Mesa_insert";

        this.axios
          .post(uri, this.item)
          .then(response => {
            this.mensajeInfo("Item agregado exitosamente");
            this.inicializar();
            //hay que obtener el indice
            /* this.getLatestItem();
            setTimeout(() => {
              this.medidas.splice(0, 0, this.getSearchItem);

              this.item = {};
            }, 200); */
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
        let uri = this.ip + `Mesa_update/${
          this.itemM.idMesa
        }`;
        this.axios
          .post(uri, this.itemM)
          .then(response => {
            var index = this.medidas.indexOf(this.getSearchItem);
            //this.$log.info(index);
            if (index > -1) {
              var temp = this.medidas[index];
              temp.nombre = this.itemM.nombre; 
              //temp.rol = this.rolSeleccionado.nombre;
               setTimeout(() => {
                 this.inicializar();
              }, 900);
            }

            this.mensajeInfo("Item modificado exitosamente");
          })
          .catch(error => {
            //this.mensajeError("Error al modificar");
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
      let uri = this.ip + "Persona_latest";
      this.axios.get(uri).then(response => {
        this.getSearchItem = response.data;
        this.$log.info(this.getSearchItem.idPersona);
      });
    },

    /*
    *REOLS 
     */
    cbCambioNuevoRol(item2) {
      this.item.idLugar = item2.idLugar;
      this.rolSeleccionado = item2; 
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