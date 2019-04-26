<template>
 

  <v-container fluid>
    <v-layout row wrap justify-center>
      <v-flex xs12 sm12 >
 


    <v-card color="grey lighten-3">
      <v-card-title>
        <span class="headline">Nuevo Categoría</span>
      </v-card-title>
      <v-card-text >
            <v-layout row wrap>
  <!-- Nombre -->              
              <v-flex xs12>
                <v-text-field
                  box
                  label="Nombre"
                  v-model="item.nombre" 
                  color = "blue"
                  required
                  autofocus
                  :rules="nameRules"
                ></v-text-field>
              </v-flex>
   <!-- Descripcion -->             
              <v-flex xs12>
                <v-text-field
                  box
                   label="Descripcion"
                  v-model="item.descripcion" 
                  :counter="50"   
                ></v-text-field>
              </v-flex>
  <!-- Categoría padre -->
                <v-flex xs12 sm6>
                    <v-checkbox 
                      v-model="enabled" 
                      hide-details 
                      color="teal darken-3"
                      label="Categoría Padre"
                      @change="checkBoxCambio"
                    >
                    </v-checkbox> 
                </v-flex> 
                <v-flex xs12>
                    <v-select
                        :items="categorias"
                        :filter="customFilter"
                        v-model="a1"
                        item-text="nombre"
                        label="Seleccione"
                        autocomplete  
                        @change="cbCambio"
                        :disabled="!enabled"
                        >  
                        
                        <template slot="selection" slot-scope="data" >
                            <v-chip 
                            @input="data.parent.selectItem(data.item)"
                            
                            :selected="data.selected"
                            class="chip--select-multi"
                            :key="JSON.stringify(data.item)"
                            
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
                                <v-list-tile-title class="black--text" >{{data.item.nombre}}</v-list-tile-title>
                                <v-list-tile-sub-title class="#ECEFF1 --text" >{{data.item.rutaPadre}}</v-list-tile-sub-title>
                                <v-list-tile-sub-title ><v-divider >  </v-divider></v-list-tile-sub-title>
                            </v-list-tile-content>
                            </template>
                        </template>
                    </v-select>
                </v-flex>
  <!-- Imagen -->
        <v-flex xs12>
            
            <div v-if="!image">
               <v-flex xs12 sm6>
                    <v-subheader v-text="'Seleccione una imagen'"></v-subheader>
                </v-flex>
                <input type="file" @change="onFileChange">
            </div>
            <div v-else> 
                <v-avatar 
                    class="grey lighten-4"
                    :size=200
                    >
                    <img :src="image" />
                </v-avatar>
                <div>
                    <v-btn depressed   @click.native="removeImage">Eliminar Imagen</v-btn>
                </div> 
            </div> 
        </v-flex>


 
            </v-layout>
            
 
   <!-- Boton   -->    
        <v-flex xs12>
            <div>
                <v-btn 
                    depressed   
                    color="teal darken-3"
                    @click.native="addItem" 
                    dark
                >Aceptar</v-btn>
            </div>
        </v-flex>
        
 
<!-- 
         <div class="form-group"> 
          <button class="btn btn-primary">esteSi</button>
        </div>  --> 
 </v-card-text >
        </v-card>
      </v-flex>
    </v-layout>
 

 


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
      snackColor: "teal darken-3",

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
      let uri = this.ip + "categoria";

      if (!this.files2.length) {
        //si es vacio
        this.item.imagen = "nada.png";
      } else {
        //lo voy a gaurdar en el servidor
        this.subirImag(this.files2[0]); //con est estoy subiendo la imagen al servidor
        this.item.imagen = this.imageName;
      }
 

      if (this.idCategoriaPadre == null) {
        //no seleccionaron idCategoriaPadre
        this.item.idCategoriaPadre = -1;
      } else {
        this.item.idCategoriaPadre = this.idCategoriaPadre;
      }

      this.axios
        .post(uri, this.item)
        .then(response => {
          this.$router.push({ name: "categoria_display" });
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
        .then(function() {
          //this.$log.info("SUCCESS!!");
        })
        .catch(function() {
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
    removeImage: function(e) {
      this.image = "";
      this.files2 = [];
    },
    cargarCategoriaPadre() {
      //this.$log.info('Se cargo, jejeje');
      let uri = this.ip + "categoria_items";
      this.axios.get(uri).then(response => {
        this.categorias = response.data;
      });
    },
    cbCambio(e) {
      this.idCategoriaPadre = e.idCategoria;
    },
    checkBoxCambio(e){ 
      if(!e){//si es falso
        this.a1=null;
      }
    }
  },
  mounted: function() {
    this.cargarCategoriaPadre();
  }
};
</script>