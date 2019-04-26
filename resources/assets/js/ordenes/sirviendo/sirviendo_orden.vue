<template>
  <v-layout column> 
 
    <v-card flat >
        <v-container fluid grid-list-md>
          <v-layout row wrap>
            <br>
            <v-flex xs12> 
              <v-btn :ripple="false" depressed color="teal darken-4" dark large :disabled="!desacBtnActualizar" @click="clckActualizar">Actualizar</v-btn>
            </v-flex>
            <v-flex
              v-for="card in ordenes"
              :key="card.idOrden"
              xs12 sm4
            >   

      <v-card color="teal darken-4"  dark  @click.native="clckVerMesas(card)" > 
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
               <span class="subheading"  > SubTotal: </span> 
            </v-flex>
            <v-spacer></v-spacer>
            <v-flex xs6 class="text-xs-right">
               <span class="title" >Q{{card.subtotal}} </span>
            </v-flex>
            <v-flex  xs6>
               <span class="subheading"  >Propina 10%: </span> 
            </v-flex>
            <v-spacer></v-spacer>
            <v-flex xs6 class="text-xs-right">
               <span class="title" >Q{{card.propina}} </span>
            </v-flex>
            <v-flex xs12 class="text-xs-right" >
              <span class="subheading"  >---------------------</span> 
            </v-flex>
            <v-flex  xs6>
               <span class="subheading"  > Total: </span> 
            </v-flex>
            <v-spacer></v-spacer>
            <v-flex xs6 class="text-xs-right">
               <span class="title" >Q{{card.total}} </span>
            </v-flex>
 
          </v-layout>
          <!-- <div>
            <h3 class="headline mb-0">Kangaroo Valley Safari</h3>
            
            <div>Located two hours south of Sydney in the <br>Southern Highlands of New South Wales, ...</div>
          </div> -->
        </v-card-title>
      </v-card> 
            </v-flex>
          </v-layout>
        </v-container>
      </v-card> 
  </v-layout>
</template>

<script src ="./sirviendo_orden.js">