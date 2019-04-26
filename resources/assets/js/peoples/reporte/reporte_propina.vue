<template>
  <v-container fluid>
  
    <v-card color="grey lighten-3">
      <v-card-title>
        <v-layout row wrap> 
            <v-flex xs3>
                <span class="headline">Reporte de Propinas</span> 
            </v-flex>
            <v-spacer></v-spacer>
            <v-flex xs3>
             <v-select :items="usuarios" item-text="nombre" autocomplete placeholder="Seleccione" @change="cbCambioUsuario">
            </v-select>
            </v-flex>  
            <v-flex xs4> 
                 
                <v-btn flat icon color="light-blue darken-4"  @click="clkGuardar">
                <v-icon>check</v-icon>
                </v-btn> 
                
            </v-flex> 
        </v-layout>
      </v-card-title>
      <v-card-text>
        <v-layout row wrap>
  
   <!-- aqui va una tabla con el reporte obtenido, jejeje -->
        </v-layout>
      </v-card-text>
  
    </v-card> 
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

export default {
    props: ['ip'],
  data() {
    return {
            /* SnackBar */
      snackColor: "teal darken-4",
      snackStatus: false,
      sanckText: " ",

      /* fasf */
      usuarios:[]


    };
  },
  computed: {
   
   
  },
  created() {
    this.cargarCombo();
  },
  methods: {
    
    /*
    +------------------------------------------------+
    |   Cargar combo box
    +------------------------------------------------+
    */
    cargarCombo() {
      let uri = this.ip + "Usuario_items";
      this.axios.get(uri).then(response => {
        this.usuarios = response.data;
      });
    },
    /*
    +------------------------------------------------+
    |   Cambio combo box
    |   Aqui cargo tambien las vistas si es que ya existe
    +------------------------------------------------+
    */

    cbCambioUsuario(e) {
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
    /*
    +------------------------------------------------+
    |   Cambio combo box
    |   Aqui cargo tambien las vistas si es que ya existe
    +------------------------------------------------+
    */
    clkGuardar(){

    }
  
  }
};
</script>


