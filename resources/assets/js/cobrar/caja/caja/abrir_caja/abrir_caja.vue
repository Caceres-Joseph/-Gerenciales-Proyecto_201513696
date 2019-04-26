 <template>
  <v-container fluid>
 
    <v-card v-if="boolBtnAceptar" color="grey lighten-3">
        <v-card-title>
            <span class="headline">Abrir Caja</span>
        </v-card-title>
        <v-card-text >
            <v-layout row wrap>
                <!-- Tipo Comprobante -->


                <v-spacer></v-spacer>

                <!-- Num Comprobante -->
                
                <v-flex  xs12>
                   <!-- <span class="title">Caja Inicial</span> -->
                   <v-text-field autofocus box label="Caja Inicial" prefix="Q." disabled v-model="item.cajaInicial" placeholder="0,00" v-mask-decimal.br="2"></v-text-field>
                </v-flex>
                <!-- <v-flex xs12>
                    <span class="title">Q.{{this.item.cajaInicial}}</span>
                </v-flex> -->
                <v-flex  xs12>
                    <v-text-field box label="Observaciones" placeholder="observacion" v-model="item.apertura_observacion"></v-text-field>
                </v-flex>

 
            </v-layout>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-4" large :disabled="!boolBtnAceptar" dark @click.native="clckAceptar">Aceptar</v-btn> 
        </v-card-actions>
    </v-card> 
    <v-card v-else color="grey lighten-3" >
         <v-card-title>
            <span class="headline">Para abrir una nueva caja, cierre la actual</span>
        </v-card-title>
    </v-card>

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
<script src ="./abrir_caja.js">