<template>
  <v-layout column> 
 
    <v-card flat >
        <v-container fluid grid-list-md>
          <v-layout row wrap>
            <br>
            <v-flex
              v-for="card in cards"
              :key="card.title"
              xs12 sm4
            >
              <v-card color="blue darken-4" dark  ripple  @click.native="clckVerMesas(card.id, card.color)">
              <v-container fluid grid-list-lg>
                <v-layout row>
                  <v-flex xs12>
                    <div>
                      <div class="headline">{{card.title}}</div>
                      <!-- <div>Ellie Goulding</div> -->
                    </div>
                  </v-flex>
                  <!-- <v-flex xs5>
                    <v-card-media
                      src="/storage/images/categorias/logoGamer.jpeg"
                      height="125px"
                      contain
                    ></v-card-media>
                  </v-flex> -->
                </v-layout>
              </v-container>
              <!-- <v-btn    fab :ripple="false"    :color="card.color" dark ><v-icon>device_hub</v-icon></v-btn> -->
              </v-card>
            </v-flex>
          </v-layout>
        </v-container>
      </v-card> 
  </v-layout>
</template>

<script src ="./cobrar_lugar.js">