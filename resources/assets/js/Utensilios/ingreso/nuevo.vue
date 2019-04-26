<template>
  <v-container fluid>
 
 <!-- CONFIRMAR -->


          <v-dialog v-model="dlgConfirmar" max-width="500px">
            <v-card  >
              <v-card-title>
                <span class="headline">¿Seguro que desea efectuar la operación?</span>
              </v-card-title> 

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="green darken-4"  dark @click.native="insertar">Aceptar</v-btn>
                <v-btn color="blue darken-1" flat @click.native="dlgConfirmar = false">Cancelar</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>



<!-- Nuevo  --> 
    <v-dialog v-model="dialogNuevoProducto" max-width="500px">
      <v-card  >
        <v-card-title>
          <span class="headline">{{this.itemSubProductoActual.nombre}}</span>
        </v-card-title>
        <v-card-text>
            <v-flex xs12>
                <v-text-field
                  label="Cantidad"  
                  v-model="itemSubProducto.cantidad"
                  required  
                  @keyup="keyUpSubProductoCantidad"
                ></v-text-field>
            </v-flex> 
            <v-flex  xs12>
                <v-text-field   @keyup="keyUpSubProductoCompra"  label="Precio Compra" prefix="Q." v-model="itemSubProducto.compra" placeholder="0,00" v-mask-decimal.br="2"></v-text-field>
            </v-flex>
            <br> 
            <v-flex xs12>
                <v-layout row wrap>
                <v-flex xs1>
                    <v-checkbox v-model="modelChekVencimiento"   hide-details color="blue darken-3" @change="checkBoxVencimiento"  >
                    </v-checkbox>                
                </v-flex> 
                <v-flex xs11 >
                    <v-menu
                        ref="menu2"
                        :close-on-content-click="false"
                        v-model="menu2"
                        :nudge-right="40"
                        :return-value.sync="date2"
                        lazy
                        transition="scale-transition"
                        offset-y
                        full-width
                        min-width="290px"
                        :disabled="!modelChekVencimiento"
                    >
                        <v-text-field
                        slot="activator"
                        v-model="date2"
                        label="Fecha de vencimiento"
                        prepend-icon="event"
                        readonly
                        ></v-text-field>
                        <v-date-picker v-model="date2" no-title scrollable>
                            <v-spacer></v-spacer>
                            <v-btn flat color="primary" @click="menu2 = false">Cancel</v-btn>
                            <v-btn flat color="primary" @click="$refs.menu2.save(date2)">OK</v-btn>
                        </v-date-picker>
                    </v-menu>
                </v-flex>   
                </v-layout>   
            </v-flex>
            <v-spacer></v-spacer>
            <v-flex  xs12>
                <v-text-field disabled label="Total"  prefix="Q."  v-model="itemSubProducto.total" placeholder="0" v-mask-decimal.br="2"></v-text-field>
            </v-flex>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-4"  dark @click.native="insertarSubProducto" >Aceptar</v-btn>
          <v-btn color="blue darken-1" flat @click.native="dialogNuevoProducto = false">Cancelar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    
    <!-- Nuevo  -->
    <v-card color="grey lighten-3">
      <v-card-title>
        <span class="headline">Nuevo Ingreso</span>
      </v-card-title>
      <v-card-text >
        <v-layout row wrap>
            <!-- <v-flex xs12 >
                <v-card flat color="grey lighten-3"  > 
                    <v-layout row wrap>
                        <v-flex xs12 sm4>
                            <v-checkbox v-model="modelChekBodega" hide-details color="blue darken-3" label="Bodega" @change="checkBoxProveedor">
                            </v-checkbox>
                        </v-flex>  
                    </v-layout>
                </v-card> 
            </v-flex>  --> 
            <!-- Tipo Comprobante -->
            <v-flex sm5 xs12>
                <v-text-field box label="Tipo Comprobante" placeholder="Tipo de comprobante" v-model="item.comprobante"></v-text-field>
            </v-flex>

            <v-spacer></v-spacer>

            <!-- Num Comprobante -->
            <v-flex sm6 xs12>
                <v-text-field box  label="Num. Comprobante" v-model="item.numComprobante" placeholder="Número de comprobante"></v-text-field>
            </v-flex>

            <!-- Fecha comprobante -->
            <v-flex sm12 xs12>
                <v-menu
                    ref="menu"
                    :close-on-content-click="false"
                    v-model="menu"
                    :nudge-right="40"
                    :return-value.sync="date"
                    lazy
                    transition="scale-transition"
                    offset-y
                    full-width
                    min-width="290px"
                >
                    <v-text-field
                    slot="activator"
                    v-model="date"
                    label="Fecha del comprobante"
                    prepend-icon="event"
                    readonly
                    ></v-text-field>
                    <v-date-picker v-model="date" no-title scrollable>
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                        <v-btn flat color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                    </v-date-picker>
                </v-menu>
            </v-flex>

            <v-divider inset></v-divider>
            <br> 
            <!-- Proveedor -->

            <v-flex xs12 >
                <v-card color="white" > 
                    <v-layout row wrap>
                        <v-flex xs12 sm4>
                            <v-checkbox v-model="modelChekProveedor" hide-details color="blue darken-3" label="Proveedor" @change="checkBoxProveedor">
                            </v-checkbox>
                        </v-flex>
                        <v-spacer></v-spacer>
                    
                        <v-flex xs12 sm8>
                            <v-select   :items="proveedores"  v-model="cbModelProveedor" item-text="nombre" autocomplete :disabled="!modelChekProveedor" placeholder="Seleccione" @change="cbCambioProveedor">
                            </v-select>
                        </v-flex>
                    </v-layout>
                </v-card> 
            </v-flex> 

            <v-divider inset></v-divider>
            <br> 

            <!-- Productos a Ingresar -->
            
            <v-flex xs12 >
                <v-card color="white" > 
                    <v-layout row wrap> 
                        <v-flex xs12  >
                            <v-subheader>Producto</v-subheader>  
                        </v-flex>  

                        <v-flex xs12 sm2 >
                             <v-btn fab @click="refrescarSubProductos" flat color="grey">
                               <v-icon>autorenew</v-icon>  
                            </v-btn> 
                        </v-flex> 
                        <v-flex xs12 sm10>
                            <v-select   :items="articulosCombo"  v-model="cbModelProductos" item-text="nombre" autocomplete   placeholder="Seleccione" @change="cbCambioProducto" >
                            </v-select>
                        </v-flex> 

                    </v-layout>
                </v-card> 
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
                    <td class="text-xs-left">{{ props.item.cantidad }}</td> 
                    <td class="text-xs-left">{{ props.item.nombre }}</td> 
                    <td class="text-xs-right">{{ props.item.compra }}</td> 
                    <td class="text-xs-right">{{ props.item.total }}</td> 
                    <td class="text-xs-left">{{ props.item.vencimiento }}</td> 

                    <td class="justify-center layout px-0"> 
                   <!--  <v-btn icon class="mx-0" @click="editItem(props.item)">
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
             <v-flex xs12>
               <h3>Total Q {{this.item.totalCompleto}}</h3>
             </v-flex>
            
            <br> 
         

        </v-layout>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-4"  dark @click.native="clckDlgAceptar">Aceptar</v-btn>
        <v-btn color="blue darken-1" flat @click.native="cancelar">Cancelar</v-btn>
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

<script src ="./nuevo.js">

</script>
 