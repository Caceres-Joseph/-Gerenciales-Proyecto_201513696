<template>
    <v-app id="inspire">
        <v-navigation-drawer app class="grey lighten-5" clipped fixed v-model="drawer">
            <v-list class="grey lighten-5" dense>
                <template v-for="(item, i) in items2">
                    <v-layout
                            :key="i"
                            align-center
                            row
                            v-if="item.heading"
                    >
                        <v-flex xs6>
                            <v-subheader v-if="item.heading">
                                {{ item.heading }}
                            </v-subheader>
                        </v-flex>
                        <v-flex class="text-xs-right" xs6>
                        </v-flex>
                    </v-layout>
                    <v-divider
                            :key="i"
                            class="my-3"

                            dark
                            v-else-if="item.divider"
                    ></v-divider>
                    <v-list-tile
                            :key="i"
                            :to="item.path"
                            v-else
                    >
                        <v-list-tile-action>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title class="grey_lighten-1--text">
                                {{ item.text }}
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </template>
            </v-list>
        </v-navigation-drawer>

        <!--  -->
        <v-toolbar
                :clipped-left="$vuetify.breakpoint.lgAndUp"
                app
                color="blue-grey darken-3"
                dark
                fixed
        >
            <v-toolbar-title class="ml-0 pl-3" style="width: 300px">
                <!-- <v-btn fab    color = "blue darken-3" @click="drawer = !drawer" ><v-icon>add</v-icon></v-btn> -->
                <v-toolbar-side-icon @click="drawer = !drawer"></v-toolbar-side-icon>
                <span>Q{{this.totalOrdenMostrar}}&nbsp; </span>
            </v-toolbar-title>
            <v-text-field
                    class="hidden-sm-and-down"
                    flat
                    label="Ordenes"
                    prepend-icon="search"
                    solo-inverted
            ></v-text-field>
            <v-spacer></v-spacer>
            <!-- <v-toolbar-title  >
              <span class="hidden-sm-and-down" >Q.123213.00&nbsp; </span>
            </v-toolbar-title> -->
            <v-btn @click="clckSubirDeCarpeta" color="white" dark flat icon large>
                <v-icon x-large>keyboard_arrow_up</v-icon>
            </v-btn>
            <v-menu bottom left>

                <v-avatar class="mr-3" size="40px" slot="activator">
                    <img
                            alt=""
                            src="/storage/images/categorias/logoGamer.jpeg"
                    >
                </v-avatar>
                <v-list>
                    <v-list-tile @click="inicio">
                        <v-list-tile-title>Inicio</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile @click="salir">
                        <v-list-tile-title>Salir</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile @click="salir">
                        <v-list-tile-title>Imprimir</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile @click="salir">
                        <v-list-tile-title>Cocina</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile @click="salir">
                        <v-list-tile-title>Barra</v-list-tile-title>
                    </v-list-tile>

                </v-list>
            </v-menu>
        </v-toolbar>
        <v-content>
            <!-- /*
            |__________________________________________________________________________
            | INICIO APLICACION
            |__________________________________________________________________________
            */ -->

            <v-container fluid>

                <!-- Nuevo  -->
                <v-dialog max-width="500px" v-model="dlgObservacion">
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{this.actualItemObservacion.producto}}</span>
                        </v-card-title>
                        <v-card-text>
                            <v-flex xs12>
                                <v-text-field
                                        label="Observación"
                                        v-model="modelObservacion"

                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                            </v-flex>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn @click.native="clckNuevaObservacion" color="green darken-4" dark>Aceptar</v-btn>
                            <v-btn @click.native="dlgObservacion = false" color="blue darken-1" flat>Cancelar</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <!-- Modificar cantidad  -->
                <v-dialog max-width="500px" v-model="dlgCantidad">
                    <v-card>
                        <v-card-title>
                            <span class="headline">Cant.{{this.actualItemObservacion.producto}}</span>
                        </v-card-title>
                        <v-card-text>
                            <v-flex xs12>
                                <v-text-field
                                        label="Observación"
                                        v-model="modelCantidad"

                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                            </v-flex>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn @click.native="clckNuevaCantidad" color="green darken-4" dark>Aceptar</v-btn>
                            <v-btn @click.native="dlgCantidad = false" color="blue darken-1" flat>Cancelar</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>


                <div class="wrap">
                    <v-layout row wrap>


                        <v-flex sm6 xs12>

                            <v-layout row wrap>
                                <v-flex xs12>
                                    <v-data-table
                                            :disable-initial-sort="true"
                                            :headers="headersCuenta"
                                            :items="arrayCuenta"
                                            class="elevation-1"
                                            hide-actions
                                    >
                                        <template slot="items" slot-scope="props">
                                            <td class="text-xs-left">
                                                {{ props.item.cantidad }}
                                            </td>
                                            <td class="text-xs-left">{{ props.item.producto }}</td>
                                            <td class="text-xs-left">{{ props.item.precio_unitario }}</td>
                                            <td class="text-xs-left">{{ props.item.precio_total }}</td>
                                            <td class="justify-center layout px-0">
                                                <!-- <v-btn icon class="mx-0" @click="editItem(props.item)">
                                                                        <v-icon color="teal">edit</v-icon>
                                                                      </v-btn> -->
                                                <v-btn @click="accObservacion(props.item)" class="mx-0" icon>
                                                    <v-icon color="light-blue darken-4">send</v-icon>
                                                </v-btn>
                                                <v-btn @click="accDelete(props.item)" class="mx-0" icon>
                                                    <v-icon color="pink">delete</v-icon>
                                                </v-btn>
                                                <v-btn @click="accDecrement(props.item)" class="mx-0" icon>
                                                    <v-icon color="blue-grey darken-3">remove_circle</v-icon>
                                                </v-btn>
                                                <v-btn @click="accIncrement(props.item)" class="mx-0" icon>
                                                    <v-icon color="blue-grey darken-3">add_circle</v-icon>
                                                </v-btn>
                                            </td>
                                            <td class="text-xs-left">{{ props.item.observacion }}</td>
                                        </template>

                                        <template slot="no-data">
                                            <v-btn flat></v-btn>
                                        </template>
                                    </v-data-table>
                                </v-flex>
                                <v-flex xs12>
                                    <v-layout row wrap>
                                    </v-layout>
                                </v-flex>
                            </v-layout>
                        </v-flex>


                        <v-flex sm6 xs12>
                            <div class="right">
                                <v-layout row wrap>

                                    <v-flex xs12>
                                        <v-card color="blue-grey darken-3">

                                            <!-- CARPETS -->
                                            <v-data-iterator
                                                    :items="categorias"
                                                    :pagination.sync="pagination"
                                                    :rows-per-page-items="rowsPerPageItems"
                                                    content-tag="v-layout"
                                                    dark
                                                    row
                                                    wrap
                                            >
                                                <v-flex
                                                        lg3
                                                        md4
                                                        slot="item"
                                                        slot-scope="props"
                                                        sm6
                                                        xs12
                                                >
                                                    <v-card @click.native="clckCategoria(props.item)" color="blue-grey darken-3" flat
                                                            ripple>
                                                        <v-card>
                                                            <v-card-media
                                                                    :src="props.item.imagen"
                                                                    contain
                                                                    height="100"
                                                            >
                                                            </v-card-media>
                                                        </v-card>
                                                        <v-card flat height="20">
                                                            {{ props.item.nombre }}
                                                        </v-card>
                                                    </v-card>
                                                </v-flex>
                                                <template slot="no-data">
                                                    <span class="white--text">No hay categorías que mostrar</span>
                                                </template>
                                            </v-data-iterator>
                                        </v-card>
                                        <v-card flat height="10">

                                        </v-card>
                                    </v-flex>
                                    <v-flex xs12>
                                        <!-- ARCHIVOS -->
                                        <v-data-iterator
                                                :items="articulos"
                                                :pagination.sync="pagination3"
                                                :rows-per-page-items="rowsPerPageItems3"
                                                content-tag="v-layout"
                                                row
                                                wrap
                                        >
                                            <v-flex
                                                    lg3
                                                    md4
                                                    slot="item"
                                                    slot-scope="props"
                                                    sm6
                                                    xs12
                                            >
                                                <v-card @click.native="clckArticulo(props.item)" ripple>
                                                    <v-card>
                                                        <v-card-media
                                                                :rows-per-page-items="rowsPerPageItems2"
                                                                :src="props.item.imagen"
                                                                contain
                                                                height="100"
                                                        >
                                                        </v-card-media>
                                                    </v-card>
                                                    <v-card height="20">
                                                        {{ props.item.nombre }}
                                                        Q.{{ props.item.precioVentaDefecto }}
                                                    </v-card>
                                                </v-card>
                                            </v-flex>
                                            <template slot="no-data">
                                                <span>No hay artículos que mostrar</span>
                                            </template>
                                        </v-data-iterator>
                                    </v-flex>
                                </v-layout>
                            </div>
                        </v-flex>


                    </v-layout>
                </div>
                <!-- Snackbar -->
                <v-snackbar
                        :color="snackColor"
                        :timeout=3000
                        button
                        v-model="snackStatus"
                >
                    {{ sanckText }}
                    <!-- <v-btn    @click.native="snackStatus = false">Cerrar</v-btn> -->
                    <div>
                        <v-btn :color="snackColor" @click.native="snackStatus = false" dark depressed small>Cerrar
                        </v-btn>
                    </div>
                </v-snackbar>
            </v-container>
            <!-- /*
            |__________________________________________________________________________
            | FIN APLICACION
            |__________________________________________________________________________
            */ -->
        </v-content>
    </v-app>
</template>
