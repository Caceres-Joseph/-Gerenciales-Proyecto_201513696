 <template>
  <v-container fluid>
 
    <v-card color="blue-grey lighten-4">
        <v-card color="teal darken-3">
            <v-card-title primary-title>
                 <span class="headline white--text">Nuevo Abono</span>
            </v-card-title>
        </v-card> 
        <v-card-text >
            <v-layout row wrap>
                <!-- Tipo Comprobante -->
                <v-flex sm8 xs12>
                    <v-text-field ref="fcTxtNombre" box label="Nombre" placeholder="nombre" v-model="item.nombre"></v-text-field>
                </v-flex>

                <v-spacer></v-spacer>

                <!-- Num Comprobante -->
                <v-flex sm3 xs12>
                   <v-text-field box label="Monto" prefix="Q." v-model="item.monto" placeholder="0,00" v-mask-decimal.br="2"></v-text-field>
                </v-flex>
                <v-flex  xs12>
                    <v-text-field box label="Observacion" placeholder="observacion" v-model="item.observacion"></v-text-field>
                </v-flex>


                <!-- Fecha comprobante -->
<!--                 <v-flex sm12 xs12>
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
                </v-flex> -->


            </v-layout>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn  v-shortkey="['enter']" @shortkey="clckAceptar" color="teal darken-4" large  dark @click.native="clckAceptar">Aceptar</v-btn> 
        </v-card-actions>
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
<script src ="./nuevo_abono.js">