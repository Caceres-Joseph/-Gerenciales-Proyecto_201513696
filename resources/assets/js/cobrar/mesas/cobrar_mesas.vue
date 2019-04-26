<template>
  <v-layout column> 
 
    <v-card flat >
        <v-container fluid grid-list-md>
          <v-layout row wrap>
            <br>

            <v-flex
              v-for="card in cards"
              :key="card.id"
              xs12 sm4
            >
            <v-card >
                 <v-card   
                  v-for="mesero in card.meseros"
                  :key="mesero.idOrden"  
                  color="amber darken-4"   
                  class="white--text"> 
                    <v-layout row wrap>
                      <v-flex xs6>
                        <span class="subheading" > Orden No.{{mesero.idOrden}}</span>
                      </v-flex>
                      <v-flex xx6 class="text-xs-rigth">
                        <span class="subheading" > Mesero:{{mesero.nombre}}</span>
                      </v-flex>
                      <v-flex xs12>
                        <span class="subheading" > {{mesero.hora}}</span>
                      </v-flex>
                      <v-flex xs12>
                        <v-divider></v-divider>
                        <v-divider></v-divider>
                      </v-flex>
                    </v-layout> 
                      <!-- <div class="subheading">{{mesero.idOrden}} <br> {{mesero.nombre}} </div> -->
                </v-card>   
                <!-- :color="card.color" class="white--text" --> 
                <v-card color=" light-blue darken-4"  >
                    <v-card-title primary-title>
                      <!-- <v-btn icon  flat  large  :color ="card.color">
                                <v-icon x-large>layers</v-icon>
                            </v-btn> -->
                    <!-- <v-btn    fab :ripple="false"    :color="card.color" dark ><v-icon>device_hub</v-icon></v-btn>     -->
                    <div class="headline white--text ">{{card.title}}</div>
                    </v-card-title>  
                    <v-btn large color="blue-grey lighten-5"   depressed :ripple="false" @click="pantallaOrden(card)"   >
                        <span class="subheading"> N. Orden</span>
                    </v-btn> 
            </v-card>
                <!-- <v-card color="light-blue darken-4">
                        <v-card-actions>
                            <v-spacer></v-spacer> 
                            <v-btn large color="blue-grey lighten-5"   depressed :ripple="false" @click="pantallaOrden(card)"   >
                                <v-icon  large medium >add</v-icon>
                            </v-btn> 
                        </v-card-actions>
                </v-card>  -->             
              </v-card>
            </v-flex>
          </v-layout>
        </v-container>
      </v-card> 
  </v-layout>
</template>

<script src ="./cobrar_mesas.js">