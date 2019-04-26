 <template>
  <v-container fluid>
 <!-- Nuevo  --> 
    <v-dialog v-model="dialogNuevo" max-width="500px">
      <v-card  >
        <!-- <v-card-title>
          <span class="headline">Pre Ticket</span>
        </v-card-title> -->
        <v-card-text>
            <v-layout row wrap>
                    <v-flex xs12 class="text-xs-center">
                        <span class="subheading" >== Cierre de Caja  ==</span>
                    </v-flex>  
                     <v-flex xs12 class="text-xs-center">
                       <span class="subheading" >Id Caja:{{this.ticket_tIdCaja}} </span>
                    </v-flex> 

                    <v-flex xs12 class="text-xs-center">
                        <span class="subheading" >{{this.ticket_tFecha}}</span>
                    </v-flex>
                    <v-flex xs12 class="text-xs-center">
                        <span class="subheading" >{{this.ticket_tHora}}</span>
                    </v-flex>
                    <v-flex xs12 class="text-xs-center">
                        <span class="subheading" >Cajero:{{this.ticket_tEncargado}}</span>
                    </v-flex>
                    <v-flex xs12 class="text-xs-center">
                        <span class="subheading" >---------------------</span>
                    </v-flex>
                    <v-flex xs6  >
                        <span class="subheading" >Total Ventas: Q</span>
                    </v-flex>
                     <v-flex xs6 class="text-xs-right">
                        <span class="subheading" >{{(this.ticket_tVentas).toFixed(2)}}</span>
                    </v-flex>
                    <v-flex xs6  >
                        <span class="subheading" >Caja Inicial: Q</span>
                    </v-flex>
                    <v-flex xs6 class="text-xs-right">
                        <span class="subheading" >{{(this.ticket_tCajaInicial).toFixed(2)}}</span>
                    </v-flex>
                    <v-flex xs6  >
                        <span class="subheading" >Abono: Q</span>
                    </v-flex>
                    <v-flex xs6 class="text-xs-right">
                        <span class="subheading" >{{(this.ticket_tAbono).toFixed(2)}}</span>
                    </v-flex>
                    <v-flex xs12 class="text-xs-right">
                        <span class="subheading" >------------</span>
                    </v-flex>
                    <v-flex xs12 class="text-xs-right">
                        <span class="subheading" >{{(this.ticket_tPrimerSuma).toFixed(2)}}</span>
                    </v-flex>
                    <v-flex xs12 class="text-xs-center">
                        <span class="subheading" >---------------------</span>
                    </v-flex>
                    <v-flex xs6  >
                        <span class="subheading" >Tarjeta: Q</span>
                    </v-flex>
                    <v-flex xs6 class="text-xs-right">
                        <span class="subheading" >{{(this.ticket_tTarjeta).toFixed(2)}}</span>
                    </v-flex>
                    <v-flex xs6  >
                        <span class="subheading" >Gastos: Q</span>
                    </v-flex> 
                    <v-flex xs6 class="text-xs-right">
                        <span class="subheading" >{{(this.ticket_tGastos).toFixed(2)}}</span>
                    </v-flex>
                    <v-flex xs6  >
                        <span class="subheading" >Efectivo en caja: Q</span>
                    </v-flex>
                    <v-flex xs6 class="text-xs-right">
                        <span class="subheading" >{{(this.ticket_tEfectivoActual).toFixed(2)}}</span>
                    </v-flex>
                    <v-flex xs12 class="text-xs-right">
                        <span class="subheading" >------------</span>
                    </v-flex>
                    <v-flex xs12 class="text-xs-right">
                        <span class="subheading" >{{(this.ticket_tSegundaSuma).toFixed(2)}}</span>
                    </v-flex>
                    <v-flex xs12 class="text-xs-right">
                        <span class="subheading" >------------</span>
                    </v-flex>
                    <v-flex xs6  >
                        <span class="subheading" >Diferencia</span>
                    </v-flex>
                    <v-flex xs6 class="text-xs-right">
                        <span class="subheading" >{{(this.ticket_tDiferencia).toFixed(2)}}</span>
                    </v-flex>  
            </v-layout> 
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-4"  dark @click.native="clckAceptarCierre">Aceptar</v-btn>
          <v-btn color="green darken-4"  dark @click.native="clckImprimir">Imprimir</v-btn>
          <v-btn color="blue darken-1" flat @click.native="dialogNuevo = false">Cancelar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-card v-if="!boolBtnAceptar" color="grey lighten-3">
        <v-card-title>
            <span class="headline">Cierre de Caja</span>
        </v-card-title>
        <v-card-text >
            <v-layout row wrap>
                <!-- Tipo Comprobante -->


                <v-spacer></v-spacer>

                <!-- Num Comprobante -->
                <v-flex  xs12>
                   <v-text-field autofocus box label="Efectivo actual" prefix="Q." v-model="item.efectivoActual" placeholder="0,00" v-mask-decimal.br="2"></v-text-field>
                </v-flex>
                <v-flex  xs12>
                   <v-text-field box label="Efectivo a dejar" prefix="Q." v-model="ticket_tEfectivoAdejar" placeholder="0,00" v-mask-decimal.br="2"></v-text-field>
                </v-flex>
                <v-flex  xs12>
                    <v-text-field box label="Observaciones" placeholder="observacion" v-model="ticket_tObservacion"></v-text-field>
                </v-flex> 
            </v-layout>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-4" large   dark @click.native="clckAceptar">Aceptar</v-btn> 
        </v-card-actions>
    </v-card> 
    <v-card v-else color="grey lighten-3" >
         <v-card-title>
            <span class="headline">Para cerrar caja, tiene que abrir una primero</span>
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
<script src ="./cerrar_caja.js">