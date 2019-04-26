<template>
  <v-container fluid> 
      
          <v-dialog v-model="dlgConfirmar" max-width="500px">
            <v-card  >
              <v-card-title>
                <span class="headline">¿Seguro que desea efectuar la operación?</span>
              </v-card-title> 

              <v-card-actions>
                <v-spacer></v-spacer>
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
                                  <span class="headline white--text" >{{this.dlgFracDatos.nombre}}</span>
                              </v-flex>
                              <v-flex xs5>
                                  <span class="subheading white--text text-xs-left" >idArticulo:{{this.dlgFracDatos.idArticulo}}</span>
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
                            <v-flex xs4 v-if="dlgFracItems.entero!=null">
                                <v-text-field
                                    v-model="dlgFracItems.entero"
                                    label="entero/decimal" 
                                    solo
                                    flat 
                                    ref="txtFraccion"
                                ></v-text-field> 
                            </v-flex> 
                            <v-icon>add</v-icon>
                            <v-flex xs4>
                                <v-layout row wrap>
                                    <v-flex xs12 v-if="dlgFracItems.numerator!=null">
                                        <!-- entero -->
                                        <v-text-field  
                                                v-model="dlgFracItems.numerator"
                                                label="numerador"  
                                                color="blue"
                                                flat
                                                solo
                                                v-mask-number
                                            ></v-text-field> 
                                    <v-divider></v-divider>
                                    </v-flex> 
                                    <v-flex xs12 v-if="dlgFracItems.denominator!=null">
                                        <v-text-field
                                                v-model="dlgFracItems.denominator"
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
        <span class="headline">Inventario</span>
      </v-card-title>
      <v-card-text>
           
            <!-- Productos a Ingresar -->
            
            <v-flex xs12 >
                <v-card color="white" > 
                    <v-layout row wrap> 
                        <v-flex xs12  >
                            <v-subheader>Producto</v-subheader>  
                        </v-flex>  

                        <v-flex xs2>
                            
                        </v-flex>
                        <v-flex xs10 >
                            <v-select      :items="desserts"   :clearable="true" v-model="cbModelProductos" item-text="nombre" autocomplete   placeholder="Seleccione" @change="cbCambioProducto" >
                            </v-select>
                        </v-flex> 

                    </v-layout>
                </v-card> 
            </v-flex> 
      </v-card-text>
      <v-card-text >
          <v-layout row wrap> 
                        <v-flex xs12>
                            <v-card color="orange darken-3">
                                <v-card-text>
                                    <v-layout row wrap>  
                                        <v-flex xs12 >
                                            
                                            <v-btn dark  large   depressed :ripple="false" color="orange darken-4" @click="clckImprimirPreTicket" ><v-icon>print</v-icon> Pre-Ticket</v-btn>
                                            
                                            
                                            <v-btn dark  large   depressed :ripple="false" color="red darken-4" @click="clckAceptarInventario" >  Aceptar</v-btn>
                                            <!-- <v-btn dark  large   depressed :ripple="false" color="orange darken-4" @click="clckImprimir" ><v-icon>print</v-icon> Imprimir</v-btn> -->
                                            <!-- <v-btn dark  large   depressed :ripple="false" color="orange darken-4" @click="clckInsertar" ><v-icon>add</v-icon> Insertar</v-btn> -->
                                        </v-flex>
                                        <v-flex xs12 md5>
                                            <v-text-field 
                                                label="idInventario" 
                                                v-mask-number
                                                flat
                                                solo-inverted
                                                dark
                                                v-model="txtIdInventario"
                                            ></v-text-field>
                                        </v-flex>
                                        <v-flex xs12 md7>
                                            <v-btn dark  large   depressed :ripple="false" color="orange darken-4" @click="clckInventarioAnterior" > Cargar Inventario</v-btn>
                                        </v-flex>
                                    </v-layout>
                                </v-card-text>
                            </v-card>

                        </v-flex> 


        <!-- <v-expansion-panel>
            <v-expansion-panel-content 
                key="1"
                >
                <div slot="header" ><v-icon>search</v-icon> Seleccionar productos </div>
                <v-card>
                    <v-layout row wrap> 
                        <v-flex xs12>
                            <v-card color="white"> 
                                <v-card-text> 
                                    <v-layout row wrap> 
                                            <v-flex 
                                                xs12    
                                            > 
                                                    <v-radio-group v-model="radioGroup">
                                                    <v-radio 
                                                        v-for="radio in radioButtons2 "
                                                        :key="radio.id"
                                                        :label="radio.nombre" 
                                                        :value="radio.id"
                                                        color="blue darken-4"
                                                    > 
                                                    </v-radio>
                                                </v-radio-group>      
                                            </v-flex>   
                                    </v-layout>  
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <v-flex xs12>
                            <v-card color="white">
                                <v-card-title >
                                    Nutrition
                                    <v-spacer></v-spacer>
                                    <v-text-field
                                        v-model="search"
                                        append-icon="search"
                                        label="Search"
                                        single-line
                                        hide-details
                                    ></v-text-field>
                                </v-card-title>  
                                <v-data-table
                                    v-model="selected"
                                    :headers="headers2"
                                    :items="desserts"
                                    :pagination.sync="pagination"
                                    select-all
                                    item-key="idArticulo"
                                    class="elevation-1"
                                    :search="search"
                                >
                                    <template slot="headers" slot-scope="props">
                                    <tr>
                                        <th>
                                        <v-checkbox
                                            :input-value="props.all"
                                            :indeterminate="props.indeterminate"
                                            color="orange darken-4"
                                            hide-details
                                            @click.native="toggleAll"
                                        ></v-checkbox>
                                        </th>
                                        <th
                                        v-for="header in props.headers"
                                        :key="header.idArticulo"
                                        :class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
                                        @click="changeSort(header.value)"
                                        >
                                        <v-icon small>arrow_upward</v-icon>
                                        {{ header.text }}
                                        </th>
                                    </tr>
                                    </template>
                                    <template slot="items" slot-scope="props">
                                    <tr :active="props.selected" @click="props.selected = !props.selected">
                                        <td>
                                        <v-checkbox
                                            :input-value="props.selected"
                                            color="orange darken-4"
                                            hide-details
                                        ></v-checkbox>
                                        </td>
                                        
                                        <td class="text-xs-left">{{ props.item.idArticulo }}</td>
                                        <td class="text-xs-left">{{ props.item.nombre }}</td>
                                          <td class="text-xs-left">{{ props.item.stock }}</td>
                                       
                                    </tr>
                                    </template>
                                </v-data-table> 
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-card>
            </v-expansion-panel-content>
 
        </v-expansion-panel>  --> 
            <v-divider inset></v-divider>
            <br> 

            <v-flex xs12>
                <v-data-table
                :headers="headers"
                :items="subProductosItems" 
                class="elevation-1" 
                :disable-initial-sort="true"
                :hide-actions="true"
                >
                <template slot="items" slot-scope="props">
                    
                    <td class="text-xs-left">{{ props.item.idArticulo }}</td>
                    <td class="text-xs-left">{{ props.item.nombre }}</td>
                    <td class="text-xs-center">{{ props.item.stock }}</td>
                   <!--  <td class="text-xs-left  ">
                        <v-card   flat    >
                            <v-text-field 
                                solo-inverted
                                flat
                                v-mask-number
                                v-model="props.item.stockFisico"
                            ></v-text-field>
                        </v-card>
                    </td>  -->

                    <td v-if="props.item.fraccionStockFisico.denominator==1" class="text-xs-center">{{ props.item.fraccionStockFisico.numerator }}</td>

                    <td v-else class="text-xs-center">{{ improperFractionToMixedNumber(props.item.fraccionStockFisico.numerator, props.item.fraccionStockFisico.denominator) }}</td>

                   

                    <td class="justify-center layout px-0">  
                    <v-btn icon class="mx-0" @click="editItem(props.item)">
                        <v-icon color="black">edit</v-icon>
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
            </v-flex>
             <v-spacer></v-spacer>
             <br>
             <v-divider inset></v-divider>
            
            <br> 
        </v-layout> 
      </v-card-text> 
       <v-card-actions>
        <v-spacer></v-spacer>
        <!-- <v-btn color="blue darken-4"  dark @click.native="clckAceptarInventario">Aceptar</v-btn>
        <v-btn color="blue darken-1" flat @click.native="clckCancelar">Cancelar</v-btn> -->
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

<script src ="./inventario.js">

</script>
 