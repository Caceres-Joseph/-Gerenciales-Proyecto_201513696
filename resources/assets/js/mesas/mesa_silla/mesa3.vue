<template>
  <v-container fluid>
<!-- Eliminar  --> 
  <v-dialog v-model="dlgEliminarMesa" max-width="500px">
    <v-card>
      <v-card-title>
        <span  class="headline">¿Está seguro que desea eliminar el elemento?</span>
      </v-card-title>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="green darken-4"  dark @click.native="eliminarMesa">Eliminar</v-btn>
        <v-btn color="blue darken-1" flat @click.native="dlgEliminarMesa=false">Cancelar</v-btn> 
      </v-card-actions>
    </v-card>
  </v-dialog>

<!-- Eliminar  --> 
  <v-dialog v-model="dlgEliminarSilla" max-width="500px">
    <v-card>
      <v-card-title>
        <span  class="headline">¿Está seguro que desea eliminar el elemento?</span>
      </v-card-title>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="green darken-4"  dark @click.native="eliminarSilla">Eliminar</v-btn>
        <v-btn color="blue darken-1" flat @click.native="dlgEliminarSilla=false">Cancelar</v-btn> 
      </v-card-actions>
    </v-card>
  </v-dialog>

<!-- Dialog  --> 
    <v-dialog v-model="dlgMesaNombre" max-width="500px">
      <v-card  >
        <v-card-title>
          <span class="headline">No. mesa</span>
        </v-card-title>
        <v-card-text>
            <v-flex xs12>
       <!--  v-mask-number -->
        <v-text-field
         v-mask-number
          label="Número de mesa"
          v-model="txtId" 
        ></v-text-field>
              </v-flex>

        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" @click="clkNumeroMesaGuardar" dark >Aceptar</v-btn>
          <v-btn color="blue darken-1" flat @click.native="dlgMesaNombre = false">Cancelar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-card color="grey lighten-3">
      <v-card-title>
        <v-layout row wrap> 
            <v-flex xs3>
                <span class="headline">Diseño de Mesas</span> 
            </v-flex>
            <v-spacer></v-spacer>
            <v-flex xs3>
            <!--   <v-select ref="focoMedida" :items="medidas" :filter="customFilter" v-model="MedidaModel" item-text="nombre" autocomplete :disabled="!modelChekMedida" placeholder="Seleccione" @change="cbCambioNuevoMedida"> -->
            <v-select :items="lugares" item-text="nombre" autocomplete placeholder="Seleccione" @change="cbCambioLugar">
            </v-select>
            </v-flex> 
            
            <v-flex xs4>
                <v-btn  flat icon color="amber darken-3" @click="addTable">
                <v-icon>layers</v-icon>
                </v-btn>
                
                <!-- <v-btn  flat icon color="amber darken-4"  @click="addChair">
                <v-icon>airline_seat_recline_normal</v-icon>
                </v-btn> -->

                <v-btn flat icon color="light-blue darken-4"  @click="clkGuardar">
                <v-icon>check</v-icon>
                </v-btn>
                
                
            </v-flex>


        </v-layout>
      </v-card-title>
      <v-card-text>
        <v-layout row wrap>
  
  
  
          <dnd-grid-container :layout.sync="layout" :cellSize="cellSize" :maxColumnCount="maxColumnCount" :maxRowCount="maxRowCount" :margin="margin" :bubbleUp="bubbleUp">
            <dnd-grid-box v-for="item in layout" :boxId="item.id" :key="item.id" dragSelector="div.card-header" >
              <!-- color="blue-grey darken-2" -->
              <div class="card demo-box">
                <v-card   class="white--text card demo-box " :color="item.color" height="20">
                  <div class="card-header " v-on:dblclick="clkNumeroMesa(item)"   >
                    {{item.tipo}}.{{item.idChild}}
                  </div>
                  
                </v-card>
                <v-btn v-if="item.tipo=='M'"  icon flat small color="teal darken-4"  @click="addChair(item)" @click.right="deleteTable(item)"  >
                <v-icon>add</v-icon>
                </v-btn> 
                <v-btn v-else  icon flat small color="light-blue darken-4"  @click.right="deleteChair(item)">
                <v-icon>airline_seat_recline_normal</v-icon>
                </v-btn>
              </div>
            </dnd-grid-box>

                      <!-- <v-btn color="info" @click="cambio(layout[number])">
                          +
                          </v-btn>  -->
          <!--   <dnd-grid-box :boxId="23" @focus="cambio(4)" >
                @mouseover="cambio(5)"  @mouseout="cambio(6)"
              <v-btn color="teal darken-4" @click="cambio(4)" v-show="visible">
                +
              </v-btn>
  
            </dnd-grid-box>-->
          </dnd-grid-container>


          <!-- Mesas -->
<!--           <dnd-grid-container :layout.sync="layoutMesas" :cellSize="cellSize" :maxColumnCount="maxColumnCount" :maxRowCount="maxRowCount" :margin="margin" :bubbleUp="bubbleUp">
            <dnd-grid-box v-for="number in boxCount" :boxId="number" :key="number" dragSelector="div.card-header" >
              <div class="card demo-box">
                <v-card   class="white--text card demo-box " color="light-blue darken-4" height="20">
                  <div class="card-header ">
                    M. {{number}}
                  </div>
                  <v-card-text>

                  </v-card-text>
                </v-card>
              </div>
            </dnd-grid-box>
          </dnd-grid-container> -->
  
        </v-layout>
      </v-card-text>
  
    </v-card>
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

<style>
.demo-box {
  width: 100%;
  height: 100%;
}
</style>
<script>
import { Container, Box } from "@dattn/dnd-grid";
import "@dattn/dnd-grid/dist/dnd-grid.css";
export default {
    props: ['ip'],
  components: {
    DndGridContainer: Container,
    DndGridBox: Box
  },
  data() {
    return {
      /* SnackBar */
      snackColor: "teal darken-4",
      snackStatus: false,
      sanckText: " ",
      /* 
      *Dnd-grid
      */
      visible: true,
      cellSize: {
        w: 55,
        h: 55
      },
      maxColumnCount: 14,
      maxRowCount: Infinity,
      bubbleUp: false,
      margin: 5,
      boxCount: 2,
      tableCount: 0,
      layout: [
        /*         {
          id: 1,
          hidden: false,
          pinned: false,
          tipo: "M",
          color: "teal darken-4",
          position: {
            x: 4,
            y: 0,
            w: 2,
            h: 1
          }
        },
        {
          id: 2,
          hidden: false,
          pinned: false,
          tipo: "S",
          color: "light-blue darken-3",
          position: {
            x: 6,
            y: 0,
            w: 1,
            h: 1
          }
        } */
      ],

      /* 
      *Combo Box
      */
      lugares: [],
      /* 
      *Dialog
      */
      dlgMesaNombre: false,
      txtId: "",
      actualItem: null,
      /* 
      *Dialog eliminar
      */
      dlgEliminarMesa: false,
      dlgEliminarSilla: false,
      itemActualDelete:null,
      /* Par guardar */
      idLugarActual: null
    };
  },
  computed: {
    layoutWithoutSettings() {
      return this.layout.filter(box => {
        return box.id !== "settings";
      });
    }
  },
  created() {
    this.cargarCombo();
  },
  methods: {
    onLayoutUpdate(evt) {
      this.layout = evt.layout;
    },
    cambio(e) {
      /*       this.$log.info(e);
      if (e == 5) {
        this.visible = true;
      } else if (e == 6) {
        //this.visible=false;
      } */
      this.$log.info(e);
    },
    /*
    +------------------------------------------------+
    |   Cargar combo box
    +------------------------------------------------+
    */
    cargarCombo() {
      let uri = this.ip + "Lugar_items";
      this.axios.get(uri).then(response => {
        this.lugares = response.data;
      });
    },
    /*
    +------------------------------------------------+
    |   Cambio combo box
    |   Aqui cargo tambien las vistas si es que ya existe
    +------------------------------------------------+
    */

    cbCambioLugar(e) {
      if (e != null) {
        this.idLugarActual = e.idLugar;
        /* Recuperando valores */
        let uri = this.ip + `Mesa_Silla_items/${
          this.idLugarActual
        }`;

        this.axios
          .get(uri)
          .then(response => {
            this.limpiarArregloMesa();
            response.data.forEach(element => {
              if (element.tipo == "M") {
                //Insertando mesa
                this.drawTable(element);
              } else if (element.tipo == "S") {
                //Insertando silla
                this.drawChair(element);
              }
            });
          })
          .catch(error => {
            this.$log.info("Error al recuperar mesas");
          });
      }
    },
    drawTable(element) {
      this.tableCount++;

      this.boxCount++;
      var indice = this.boxCount;

      var mesa = {
        id: element.id,
        idChild: element.idChild,
        countChair: element.countChair,
        idParent: element.idParent,
        hidden: false,
        pinned: false,
        tipo: "M",
        color: "orange accent-4",
        position: {
          x: element.x,
          y: element.y,
          w: element.w,
          h: element.h
        }
      };

      this.layout.push(mesa);
    },
    drawChair(element) {
      this.boxCount++;

      var indice = this.boxCount;
      var silla = {
        id: element.id,
        idChild: element.idChild,
        countChair: element.countChair,
        idParent: element.idParent,
        hidden: false,
        pinned: false,
        tipo: "S",
        color: "light-blue darken-3",
        position: {
          x: element.x,
          y: element.y,
          w: element.w,
          h: element.h
        }
      };
      this.layout.push(silla);
    },
    limpiarArregloMesa() {
      this.boxCount = 2;
      this.tableCount = 0;
      this.layout = [];
    },
    /*
    +------------------------------------------------+
    |   Nueva mesa y silla
    +------------------------------------------------+
    */

    addTable() {
      //para incrementar el id de las mesas
      this.tableCount++;

      this.boxCount++;
      this.boxCount=this.comprobarRepetido(this.boxCount);
      var indice = this.boxCount;

      var mesa = {
        id: indice,
        idChild: parseInt(this.tableCount),
        countChair: 0,
        idParent: -1,
        hidden: false,
        pinned: false,
        tipo: "M",
        color: "orange accent-4",
        position: {
          x: 0,
          y: 0,
          w: 1,
          h: 2
        }
      };
      mesa.id=this.comprobarRepetido(mesa.id);
      this.layout.push(mesa);
    },
    addChair(item) {
      item.countChair++;

      this.boxCount++;
      this.boxCount=this.comprobarRepetido(this.boxCount);
      var indice = this.boxCount;
      var mesa = {
        id: indice,
        idChild: parseInt(item.countChair),
        countChair: 0,
        idParent: item.id,
        hidden: false,
        pinned: false,
        tipo: "S",
        color: "light-blue darken-3",
        position: {
          x: 0,
          y: 0,
          w: 1,
          h: 1
        }
      };
      mesa.id=this.comprobarRepetido(mesa.id);
      this.layout.push(mesa);
    },
    comprobarRepetido(indice){
      for (let index = 0; index < this.layout.length; index++) {
        const element = this.layout[index];
        if(indice==element.id){
          //esta repetido
          indice++;
          this.comprobarRepetido(indice);
        }
      }
      return indice;
    }
    ,
    /*
    +------------------------------------------------+
    |   Eliminar mesa y silla
    +------------------------------------------------+
    */

    deleteTable(item) {
      //this.tableCount--;
      this.dlgEliminarMesa = true;
      this.itemActualDelete=item;
    },

    deleteChair(item) {
      this.dlgEliminarSilla = true;
      this.itemActualDelete=item;
    },
    eliminarMesa() {
      this.dlgEliminarMesa=false;
      var item=this.itemActualDelete;
      this.deleteRecursivo(item, 0);

      var index = this.layout.indexOf(item);
      if (index > -1) {
        this.layout.splice(index, 1);
      }
      this.clkGuardar();
    },
    eliminarSilla() {
      this.dlgEliminarSilla=false;
      var item=this.itemActualDelete;
      var index = this.layout.indexOf(item);
      if (index > -1) {
        this.layout.splice(index, 1);
      }
      this.clkGuardar();

    },

    deleteRecursivo(item, contador) {
      for (let index = 0; index < this.layout.length; index++) {
        var element = this.layout[index];
        if (element.idParent == item.id) {
          var index2 = this.layout.indexOf(element);
          if (index2 > -1) {
            this.layout.splice(index2, 1);
            //Regreso al ciclo
            //if (contador < this.layout.length) {
            //salir
            contador++;
            this.deleteRecursivo(item, contador);
            //}
            break;
          }
        }
      }
    },
    /*
    +------------------------------------------------+
    |   Editar mesa
    +------------------------------------------------+
    */
    clkNumeroMesa(item) {
      this.txtId = item.idChild;
      this.dlgMesaNombre = true;
      this.actualItem = item;
    },
    clkNumeroMesaGuardar() {
      if (this.txtId != null || this.txtId != "") {
        this.actualItem.idChild = this.txtId;
        //procedo a guardar, jejeje
      }
      this.dlgMesaNombre = false;
    },
    /*
    +------------------------------------------------+
    |   Guardar el diseño
    +------------------------------------------------+
    */

    //idChild
    //id
    //idParent
    //tipo
    //h
    //w
    //x
    //y
    //countChair

    clkGuardar() {
      //this.$log.info(this.layout);
      //recorriendo el vector

      //ingresando primero las mesas
      /*       for (let index = 0; index < this.layout.length; index++) {
        const element = this.layout[index];        
        if(element.tipo="M"){
          
        }
      } */

      /* Insertando el articulo */

      if (this.idLugarActual == null) {
        this.mensajeAdvertencia("Debe de seleccionar un lugar");
        return;
      }
      let uri3 = this.ip + `Mesa_Silla_insertMultipleItems/${
        this.idLugarActual
      }`;
      //this.$log.info(this.subProductos);
      this.axios
        .post(uri3, this.layout)
        .then(response => {
          this.mensajeInfo("Cambio efecutado exitosamente");
          this.$log.info("Mesas insertadas exisotsamente");
        })
        .catch(error => {
          this.mensajeError("Error al insertar las mesas");
          this.$log.info("Error al insertar mesas");
        });
    },
    /*
    +------------------------------------------------+
    |   Mensajes
    +------------------------------------------------+
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


