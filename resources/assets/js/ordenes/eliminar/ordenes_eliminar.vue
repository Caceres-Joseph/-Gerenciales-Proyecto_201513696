<template> 
    <v-layout row wrap>
<!--        
    |- - - - - - - - - - - - 
    | NIVELES
    |- - - - - - - - - - - - 
-->   
     <v-flex xs12>
        <v-btn
            v-for="elem in ordenes"
            :key="elem.idOrden" 
            color="red darken-4"
            large
            depressed
            dark
            :ripple="false"
            @click="eliminarOrden(elem.idOrden)"
        >
             Orden #{{elem.idOrden}} 
        </v-btn>
    </v-flex>  

<!--     <v-flex xs12>
        <v-container fluid grid-list-md>
            
            <v-card flat color="blue darken-4">
                <v-data-iterator
                    :items="ordenes"
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

                </v-data-iterator> 
            </v-card>
        </v-container>
    </v-flex> -->


  </v-layout>
</template>

<script src ="./ordenes_eliminar.js">