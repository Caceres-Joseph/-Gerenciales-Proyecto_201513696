<template>
  <v-container fluid> 
      
          <v-dialog v-model="dlgConfirmar" max-width="500px">
            <v-card  >
              <v-card-title>
                <span class="headline">¿Seguro que desea efectuar la operación?</span>
              </v-card-title> 

              <v-card-actions> 
                <v-btn color="green darken-4"  dark @click.native="clckDlgAceptar">Aceptar</v-btn>
                <v-btn color="blue darken-1" flat @click.native="dlgConfirmar = false">Cancelar</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>

    <!--Para las fracciones prro  -->
          <v-dialog v-model="dlgFraccion" max-width="500px">
            <v-card  color="grey lighten-3"> 
                  <v-card color="blue darken-4" flat>
                      <v-card-title primary-title> 
                          <v-layout row wrap>
                              <v-flex xs12>
                                  <span class="headline white--text" >{{this.fracNombreArticulo.nombre}}</span>
                              </v-flex>
                              <v-flex xs5>
                                  <span class="subheading white--text text-xs-left" >idArticulo:{{this.fracNombreArticulo.idArticulo}}</span>
                              </v-flex>
                              <v-spacer></v-spacer>
                              <v-flex xs5>
                                  <span class="subheading white--text text-xs-rigth" >Medida:{{this.fracNombreArticulo.nombreMedida}}</span>
                              </v-flex>
                          </v-layout> 
                      </v-card-title> 
                  </v-card>  
              <v-card-text> 
                  <v-layout row wrap>
                      <v-flex xs12>
                           <v-text-field disabled   prefix="Nota:"    placeholder="Ingrese en fracciones" ></v-text-field>
                          <!-- <span class="title gray--text" >Ingrese en fracciones</span> -->
                      </v-flex> 
                      <v-flex xs12>
                          <v-layout row wrap>
                            <v-flex xs4 v-if="fracNombreArticulo.entero!=null">
                                <v-text-field
                                    v-model="fracNombreArticulo.entero"
                                    label="entero/decimal" 
                                    solo
                                    flat
                                    
                                    ref="txtFraccion"
                                ></v-text-field>
                                
                            </v-flex> 
                            <v-icon>add</v-icon>
                            <v-flex xs4>
                                <v-layout row wrap>
                                    <v-flex xs12 v-if="fracNombreArticulo.numerador!=null">
                                        <!-- entero -->
                                        <v-text-field  
                                                v-model="fracNombreArticulo.numerador"
                                                label="numerador"  
                                                color="blue"
                                                flat
                                                solo
                                                v-mask-number
                                            ></v-text-field> 
                                    <v-divider></v-divider>
                                    </v-flex> 
                                    <v-flex xs12 v-if="fracNombreArticulo.denominador!=null">
                                        <v-text-field
                                                v-model="fracNombreArticulo.denominador"
                                                label="denominador" 
                                                flat
                                                solo-inverted
                                                v-mask-number
                                            ></v-text-field>
                                    </v-flex>
                                </v-layout>
                            </v-flex>
                        </v-layout>
                      </v-flex>
                  </v-layout>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-3" large  depressed dark @click.native="clckDlgAceptarFraccion">Aceptar</v-btn>
                <v-btn color="blue darken-1" flat @click.native="dlgFraccion = false">Cancelar</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>

    <!-- Nuevo  -->
    
    <v-card color="grey lighten-3">
      <v-card-title>
          <v-layout row wrap>
              <v-flex xs12>
                  <span class="headline">Menú compuesto</span>
              </v-flex>
              <v-flex xs12 class="text-xs-center">
                  
                  <span class="headline">{{this.$route.params.nombre}}</span>
                  <v-divider></v-divider>
              </v-flex>
              <v-flex xs5 class="text-xs-left">
                  <span class="caption">idArtículo:{{this.$route.params.id}} </span>  
              </v-flex> 
              <v-spacer></v-spacer> 
              <v-flex xs5 class="text-xs-rigth">
                  <span class="caption"> Medida:{{this.$route.params.medida}} </span>
              </v-flex>  
 

              
          </v-layout>
        
      </v-card-title>
      <v-card-text > 
        <v-layout row wrap>    
            <v-flex xs12 > 
                <v-select  solo :items="desserts" ref="cbProductosFocus" clearable :v-model="mbProductos" item-text="nombre" autocomplete   placeholder="Seleccione un producto" @change="cbCambioProducto" >
                </v-select>
            </v-flex> 
            <v-divider inset></v-divider>
            <br>   
            <v-flex xs12>
                <v-data-table
                :headers="headers"
                :items="subProductosItems" 
                class="elevation-1" 
                
                :disable-initial-sort="true"
                >
                <template slot="items" slot-scope="props">

                    <td  v-if="props.item.denominador_final==1" class="text-xs-left  "> 
                        {{ props.item.numerador_final }}
                    </td>
                   
                    <!-- <td v-else class="text-xs-left">{{ props.item.numerador_final }}/{{props.item.denominador_final}}</td>  -->
                    <td v-else class="text-xs-left">{{ improperFractionToMixedNumber(props.item.numerador,props.item.denominador)}}</td> 
                    
                    <td class="text-xs-left">{{ props.item.nombre }}</td> 
                    <td class="text-xs-left">{{ props.item.idArticulo }}</td>
                      
                    <td class="justify-left layout px-0">  
                    <!-- <v-btn icon class="mx-0" @click="deleteItem(props.item)">
                        <v-icon color="teal">edit</v-icon>
                    </v-btn> -->
                    <v-btn icon class="mx-0" @click="deleteItem(props.item)">
                        <v-icon color="pink">delete</v-icon>
                    </v-btn>
                    </td> 
                </template>
                <template slot="no-data">
                    <v-btn  flat @click="inicializar"> </v-btn>
                </template>
                </v-data-table>              
            </v-flex>
             <v-spacer></v-spacer>
             <br>
             <v-divider inset></v-divider>
            <br> 
        </v-layout> 
      </v-card-text> 
       <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-4"  large depressed dark @click.native="clckAceptarInventario">Aceptar</v-btn>
        <v-btn color="blue darken-1" flat @click.native="clckCancelar">Cancelar</v-btn>
      </v-card-actions>  
   </v-card> 

    <!-- Snackbar -->
    <v-snackbar 
        :timeout=4000
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

<script src ="./ingredientes.js">

</script>
 