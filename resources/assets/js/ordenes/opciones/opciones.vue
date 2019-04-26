<template>
  <v-layout column> 


<!-- CORTESIA  --> 

    <v-dialog v-model="cuarentena.model" max-width="500px"  >
      <v-card>
        <v-card-title>
          <span  class="headline">Enviar a cuarentena.</span>
        </v-card-title>
        <v-card-text>
          <v-text-field 
          ref="fcTxtObservacion"
            label="Observación"
            v-model="cuarentena.txtObservacion"            
          ></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-4"  dark @click.native="clckAceptarCuarentena">Aceptar</v-btn>
          <v-btn color="blue darken-1" flat @click.native="cuarentena.model = false">Cancelar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

<!-- CONTENIDO  --> 
    <v-card flat >
        <v-container fluid grid-list-md>
          <v-layout row wrap>
            <br>
            <v-flex xs12> 
              <v-btn :ripple="false" depressed color="indigo darken-3" dark large :disabled="!desacBtnActualizar" @click="clckActualizar">Actualizar</v-btn>
            </v-flex>
            <v-flex
              v-for="card in ordenes"
              :key="card.idOrden"
              xs12 sm4
            >   
              <v-card color="indigo darken-3"  dark  > 
                <v-card-title primary-title>
                  <v-layout row wrap>
                    <v-flex xs6>
                      <span class="headline" > {{card.nombreLugar}}</span>
                    </v-flex>
                    <v-flex xs6 class="text-xs-right" >
                      <span class="headline" > {{card.nombreMesa}}</span>
                    </v-flex>
                    <v-flex xs12 >
                      <span class="headline" > Orden #{{card.idOrden}}</span>
                    </v-flex>
                    <v-flex  xs12>
                      <span class="subheading"  >{{card.hora}} </span> 
                    </v-flex>

                    <v-flex  xs6>
                      <span class="subheading"  > Total: </span> 
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex xs6 class="text-xs-right">
                      <span class="title" >Q{{card.total}} </span>
                    </v-flex>
                  </v-layout>
                </v-card-title>
                <v-card-actions>
                  <v-btn depressed :ripple="false" large color="deep-purple darken-4" @click="clckDividir(card.idOrden)">Dividir</v-btn>
                 <v-btn v-if="card.total==0.0" depressed :ripple="false" large  color="red darken-4" @click="clckEliminar(card.idOrden)">Eliminar</v-btn>
                 <v-btn v-else :ripple="false" large color="amber darken-4" @click="clckCuarentena(card.idOrden, card.total)">Cuarentena</v-btn>
                </v-card-actions> 
              </v-card> 
            </v-flex>
          </v-layout>
        </v-container>
    </v-card>
  
    <v-snackbar 
        :timeout=3000
        button   
        v-model="snackStatus"
        :color= "snackColor"
        >
        {{ sanckText }} 
        <div>
            <v-btn  depressed small  dark :color="snackColor" @click.native="snackStatus = false" >Cerrar</v-btn>
        </div>
    </v-snackbar> 

  </v-layout>
</template>

<script src ="./opciones.js">