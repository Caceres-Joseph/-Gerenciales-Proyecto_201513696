<template>

  <v-layout column> 
    <v-layout row wrap>
          <v-dialog v-model="dlgPassword" max-width="500px">
            <v-card  >
              <v-card-title>
                <span class="headline">Escriba la contraseña para realizar la operación</span>
              </v-card-title>
              <v-card-text>
                  <v-flex xs12>
                      <v-text-field  v-model="txtPassword" prepend-icon="lock" name="password" label="Contraseña" type="password"></v-text-field>
                    </v-flex> 
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="green darken-4"  dark @click.native="clckPasswordAceptar">Aceptar</v-btn>
                <v-btn color="blue darken-1" flat @click.native="dlgPassword = false">Cancelar</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>

            <!--        
              |- - - - - - - - - - - - 
              | NIVELES
              |- - - - - - - - - - - - 
            -->   
    <v-flex xs12>
        <v-container fluid grid-list-md>
            <v-card flat color="blue darken-4">
                <v-data-iterator
                    :items="cards"
                    content-tag="v-layout" 
                    hide-actions  
                    row
                    wrap  
                    >

                    <v-flex
                        slot="item"
                        slot-scope="props" 
                        sm3
                    >
                    <!-- <v-card  flat   @click.native="clckCategoria(props.item)" >  -->
                    <!-- ripple -->
                    
                    <v-card color="blue darken-2"     @click.native="clckVerMesas(props.item.id)">
                        <br> 
                        <v-layout row>
                            <v-flex xs12>
                                <div>
                                <div class="headline white--text text-xs-center">{{props.item.title}}</div> 
                                </div>
                            </v-flex> 
                        </v-layout>  
                         <br> 
                    </v-card>     
                    </v-flex>
                    
                    <v-spacer></v-spacer> 
                        <template slot="no-data">
                            <span class="white--text">No hay datos que mostrar</span>
                            </template>
                </v-data-iterator> 
            </v-card>
        </v-container>
    </v-flex>
            <!--        
              |- - - - - - - - - - - - 
              | MESAS
              |- - - - - - - - - - - - 
            -->   
    <v-flex xs12>
        <v-container fluid grid-list-md>
            <v-card flat color="orange darken-4">
                <v-data-iterator
                    :items="arrayMesasColor"
                    content-tag="v-layout" 
                    hide-actions  
                    row
                    wrap  
                    >

                    <v-flex
                        slot="item"
                        slot-scope="props" 
                        sm3
                    >
                    <!-- <v-card  flat   @click.native="clckCategoria(props.item)" >  -->
                    <!-- ripple -->
                    
                    <v-card :color="props.item.color"     @click.native="clckVerOrdenes(props.item.idMesa)">
                        <br> 
                        <v-layout row>
                            <v-flex xs12>
                                <div>
                                <div class="headline white--text text-xs-center">{{props.item.nombre}}</div> 
                                </div>
                            </v-flex> 
                        </v-layout>  
                         <br> 
                    </v-card>     
                    </v-flex>
                    
                    <v-spacer></v-spacer> 
                        <template slot="no-data">
                            <span class="white--text">No hay datos que mostrar</span>
                            </template>
                </v-data-iterator> 
            </v-card>
        </v-container>
    </v-flex> 
            <!--        
              |- - - - - - - - - - - - 
              | ORDENES
              |- - - - - - - - - - - - 
            -->   
    <v-flex xs12>
        <v-container fluid grid-list-md>
            <v-card flat color="green darken-4">
                <v-data-iterator
                    :items="arrayOrdenes"
                    content-tag="v-layout" 
                    hide-actions  
                    row
                    wrap  
                    >

                    <v-flex
                        slot="item"
                        slot-scope="props" 
                        sm3
                    >
                    <!-- <v-card  flat   @click.native="clckCategoria(props.item)" >  -->
                    <!-- ripple -->
                    
                    <v-card color="green darken-3"      > 
                        <v-card-text>
                          <v-layout row wrap>
                            <v-flex xs12>
                              <span class="headline white--text  ">Orden #{{props.item.idOrden}}</span> 
                            </v-flex>
                            <v-flex xs12>
                              <span class="title white--text  ">{{props.item.nombre}}</span> 
                            </v-flex>
                            <v-flex xs12>
                              <span class="title white--text ">{{props.item.hora}}</span>
                            </v-flex>
                          </v-layout>
                        </v-card-text>
                        <v-card-actions>
                          <v-btn dark   @click="clckVerOrden(props.item.idOrden)" color="green darken-4">Ver</v-btn>
                          <!-- <v-btn dark   @click="clckEliminarOrden(props.item)"  color="red darken-4">Eliminar</v-btn> -->
                        </v-card-actions>
                    </v-card>     
                    </v-flex>
                    
                    <v-spacer></v-spacer> 
                        <template slot="no-data">
                            <span class="white--text">No hay datos que mostrar</span>
                            </template>
                </v-data-iterator> 
            </v-card>
        </v-container>
    </v-flex> 
    </v-layout> 
 
  </v-layout>
</template>

<script src ="./cobrar_ordenesMesas.js">