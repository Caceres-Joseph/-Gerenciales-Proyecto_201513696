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
    <v-card color="grey lighten-3">
      <v-card-title>
        <span class="headline">Editar Producto</span>
      </v-card-title>
      <v-card-text >
        <v-layout row wrap>
  
          <!-- Nombre -->
          <v-flex xs12>
            <v-text-field ref="focoNuevoNombre" box label="Nombre" v-model="item.nombre" required :rules="campoObligatorio" placeholder="Nombre del producto"></v-text-field>
          </v-flex>
  
          <!-- Descripcion -->
          <v-flex sm6 xs12>
            <v-text-field box label="Descripción" v-model="item.descripcion"></v-text-field>
          </v-flex>
  
          <v-spacer></v-spacer>
          <!-- Codigo de barras -->
          <v-flex sm5 xs12>
            <v-text-field box  label="Código" v-model="item.codigo" placeholder="Código de barras"></v-text-field>
          </v-flex>
  
          <!-- Stock Minimo -->
          <v-spacer></v-spacer>
          <v-flex sm3 xs12>
            <v-text-field box label="Stock Minimo" v-model="item.stockMinimo" placeholder="0" v-mask-number></v-text-field>
            <!--  -->
          </v-flex>
          <v-spacer></v-spacer>
          <!-- Precio compra -->
          <v-flex sm4 xs12>
            <v-text-field box label="Precio Compra" prefix="Q." v-model="item.precioCompraDefecto" placeholder="0,00" v-mask-decimal.br="2"></v-text-field>
            <!--  -->
          </v-flex>
          <v-spacer></v-spacer>
          <!-- Precio Venta -->
          <v-flex sm4 xs12>
            <v-text-field box label="Precio Venta" prefix="Q." v-model="item.precioVentaDefecto" placeholder="0,00" v-mask-decimal.br="2"></v-text-field>
            <!--  -->
          </v-flex>
  
          <!-- Categoria -->
            <v-flex xs12>
                <v-card color="white">
                    <v-layout row wrap>
                        <v-flex xs12 sm4>
                            <v-checkbox v-model="modelChekCategoria" hide-details color="blue darken-3" label="Categoría" @change="checkBoxCategoria">
                            </v-checkbox>
                        </v-flex>
                        <v-flex xs12 sm8>
                            <v-select  deletable-chips item-value="idCategoria" :items="categorias" :filter="customFilter" v-model="categoriaModel" item-text="nombre" placeholder="Seleccione" autocomplete :disabled="!modelChekCategoria" ref="focoNuevoCategoria" @change="cbCambioNuevoCategoria">
                            
                                <template slot="selection" slot-scope="data">
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
                                        <v-list-tile-title class="black--text">{{data.item.nombre}}</v-list-tile-title>
                                        <v-list-tile-sub-title class="#ECEFF1 --text">{{data.item.rutaPadre}}</v-list-tile-sub-title>
                                        <v-list-tile-sub-title>
                                        <v-divider> </v-divider>
                                        </v-list-tile-sub-title>
                                    </v-list-tile-content>
                                    </template>
                                </template>   
                            </v-select>
                        </v-flex>  
                    </v-layout>
                </v-card> 
            </v-flex> 

            <v-divider inset></v-divider>
            <br>  

            <v-divider inset></v-divider>
            <br> 
            <!-- SubProuductos  item-value=".idArticulo" -->
            
            <v-flex xs12>
                <v-card color="white">
                    <v-layout row wrap> 

                        <v-flex xs8  >
                            <v-checkbox v-model="modelChekSubProducto" hide-details color="blue darken-3" label="Sub Producto" @change="checkBoxSubProducto">
                            </v-checkbox>
                            <span>Nota: máximo 3 decimales</span>
                        </v-flex>
                        <v-flex xs4>
                            <!-- <v-btn fab @click="refrescarSubProductos" flat color="success">
                               <v-icon>autorenew</v-icon>  
                            </v-btn>  -->
                        </v-flex>
                        <br> 
                        <v-flex xs12 >
                            <v-select  multiple    :items="articulosCombo" :filter="customFilter" v-model="subProductosModel" item-text="nombre" placeholder="Seleccione" autocomplete :disabled="!modelChekSubProducto"   @change="cbCambioNuevoSubProducto">
                                <template slot="selection" slot-scope="data">
                                <v-chip 
                                @input="data.parent.selectItem(data.item)"
                                close
                                :selected="data.selected"
                                class="chip--select-multi"
                                :key="JSON.stringify(data.item)"
                               
                                > 
                                <v-avatar  class="blue darken-3 white--text">{{data.item.idCategoria}}</v-avatar>
                                    {{ data.item.nombre }}
                                </v-chip>
                                </template>

                                <template slot="item" slot-scope="data">
                                    <template v-if="typeof data.item !== 'object'">
                                    <v-list-tile-content v-text="data.item"></v-list-tile-content>
                                    </template>
                                    <template v-else>
                                    <v-list-tile-content>
                                        <v-list-tile-title class="black--text">{{data.item.nombre}}</v-list-tile-title> 
 
                                    </v-list-tile-content>
                                    </template>
                                </template>   
                            </v-select>
                        </v-flex>
                        <v-spacer></v-spacer>  
                    </v-layout>
                </v-card> 
            </v-flex> 
             <v-spacer></v-spacer>
             <br>
            <!-- Agregar Producto Hijo -->
            <!-- <v-flex xs12>
                <div>
                    <v-toolbar tabs>
                    <v-btn icon @click.native="addSubproducto">
                        <v-icon>add</v-icon>
                    </v-btn>
                    Agregar sub-artículo
                    </v-toolbar>
                    <v-tabs show-arrows slot="extension" align-with-title v-model="modelTabs">
                    <v-tab v-for="productoHijo in subProductos" :key="productoHijo.id">
                        s 
                    </v-tab>
                    <v-tab-item v-for="productoHijo in subProductos" :key="productoHijo.id">
                        <v-card flat>
                        <v-container fluid>
                            <v-layout row wrap>
                            <v-flex xs3 sm3>
                                <v-text-field label="Cantidad " placeholder="1" v-mask-number v-model="productoHijo.modelCantidad"></v-text-field>
                            </v-flex>
                            <v-spacer></v-spacer>
                            <v-flex xs5 sm5>
                                <v-select :items="articulosCombo" :filter="customFilter" label="Seleccione" item-text="nombre" autocomplete @change="cbCambioProductoHijo">
                                </v-select>
                            </v-flex>
                            <v-spacer></v-spacer>
                            <v-flex xs3 sm3>
                                <v-btn icon @click.native="removeSubproducto(productoHijo)">
                                <v-icon color="pink">delete</v-icon>
                                </v-btn>
                            </v-flex>
                            </v-layout>
                        </v-container>
                        </v-card>
                    </v-tab-item>
                    </v-tabs>
                </div>
            </v-flex> -->
            <v-divider inset></v-divider>
            <br> 
            
            <v-divider inset></v-divider>
            <br> 

            <!-- Imagen -->
            <v-flex xs12>
                <div v-if="!image">
                    <v-flex xs12 sm6>
                    <v-subheader v-text="'Seleccione una imagen'"></v-subheader>
                    </v-flex>
                    <input type="file" @change="onFileChange">
                </div>
                
                <div v-else>
                    <v-card>
                    <v-card-media :src="image" height="200px">
                    </v-card-media>
                    <v-card-actions>
                        <v-btn flat color="red" @click.native="removeImage">Eliminar Imagen</v-btn>
                    </v-card-actions>
                    </v-card>
                    <div>
                
                    </div>
                </div>
            </v-flex>

        </v-layout>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-4"  dark @click.native="insertar">Aceptar</v-btn>
        <v-btn color="blue darken-1" flat @click.native="cancelar">Cancelar</v-btn>
      </v-card-actions>
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

<script src ="./editar.js">

</script>
 