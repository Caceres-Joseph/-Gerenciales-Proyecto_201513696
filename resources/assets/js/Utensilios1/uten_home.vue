<template>
    <v-app id="inspire">
        <v-toolbar
                :clipped-left="$vuetify.breakpoint.lgAndUp"
                app
                color="indigo darken-3"
                dark
                fixed
                tabs>
            <v-toolbar-title
                    class="ml-0 pl-3 hidden-sm-and-down"
                    style="width: 300px">

                <span>&nbsp;<span class="text">CHIMAL TV</span></span>
            </v-toolbar-title>
            <v-text-field
                    append-icon="search"
                    class="mx-3"
                    flat
                    label="Buscar"
                    prepend-inner-icon="search"
                    ref="focoBuscar"
                    solo-inverted
                    v-model="searchParent"></v-text-field>

            <dropdown
                    align="left"
                    ref="dropdown">
                <v-avatar
                        class="mr-3"
                        color="orange darken-4"
                        size="40px"
                        slot="btn">
                    <h2>{{this.inicial}}</h2>
                </v-avatar>
                <v-list slot="body">
                    <v-list-tile @click="inicio">
                        <v-list-tile-title>Inicio</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile @click="salir">
                        <v-list-tile-title>Salir</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile @click="atajos">
                        <v-list-tile-title>Atajos</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile @click="bug">
                        <v-list-tile-title>Reportar error</v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </dropdown>

            <v-tabs
                    centered
                    color="transparent"
                    slider-color="white"
                    slot="extension"
                    v-model="tabs">
                <v-tab
                        :key="0"
                        :ripple="false"
                        @click="clckCatgorias">
                    Categorías
                </v-tab>
                <v-tab
                        :key="1"
                        :ripple="false"
                        @click="clckPaquetes">
                    Listado
                </v-tab>
                <v-tab
                        :key="2"
                        :ripple="false"
                        @click="clckClientes">
                    Inventario
                </v-tab>
            </v-tabs>
        </v-toolbar>

        <v-content>

            <!-- Atajos  -->
            <v-dialog
                    max-width="500px"
                    v-model="dlgAtajos">
                <v-card class="title">
                    <v-card-title>
                        <v-divider></v-divider>
                        <v-flex
                                class="subheading"
                                xs12>
                            <span>1)Listado de roles</span>
                        </v-flex>
                        <v-flex
                                class="black--text"
                                xs12>
                            ctrl + alt + r
                        </v-flex>

                        <v-flex
                                class="subheading"
                                xs12>
                            <span>2)Listado de personas</span>
                        </v-flex>
                        <v-flex
                                class="black--text"
                                xs12>
                            ctrl + alt + p
                        </v-flex>

                        <v-flex
                                class="subheading"
                                xs12>
                            <span>3)Listado de usuarios</span>
                        </v-flex>
                        <v-flex
                                class="black--text"
                                xs12>
                            ctrl + alt + u
                        </v-flex>
                        <v-divider></v-divider>
                        <v-flex
                                class="subheading"
                                xs12>
                            <span>4)Buscar</span>
                        </v-flex>
                        <v-flex
                                class="black--text"
                                xs12>
                            ctrl + f
                        </v-flex>
                        <v-flex
                                class="subheading"
                                xs12>
                            <span>5)Nuevo</span>
                        </v-flex>
                        <v-flex
                                class="black--text"
                                xs12>
                            ctrl + n
                        </v-flex>

                        <v-flex
                                class="subheading"
                                xs12>
                            <span>6) Avanzar entre componentes</span>
                        </v-flex>
                        <v-flex
                                class="black--text"
                                xs12>
                            tab
                        </v-flex>

                        <v-flex
                                class="subheading"
                                xs12>
                            <span>7) Retroceder entre componentes</span>
                        </v-flex>
                        <v-flex
                                class="black--text"
                                xs12>
                            shift + tab
                        </v-flex>


                        <v-flex
                                class="subheading"
                                xs12>
                            <span>8) Recargar la página</span>
                        </v-flex>
                        <v-flex
                                class="black--text"
                                xs12>
                            ctrl + r
                        </v-flex>

                    </v-card-title>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                                @click.native="dlgAtajos = false"
                                color="blue-grey lighten-4"
                                depressed
                                large>Cerrar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <!-- Atajos  -->
            <v-dialog
                    max-width="500px"
                    v-model="dlgBug">
                <v-card>

                    <v-card-title>
                        <span class="headline">¿Cuál es el problema o sugerencia?</span>
                    </v-card-title>

                    <v-card-title>
                        <v-flex xs12>
                            <v-text-field
                                    ref="focoBug"
                                    required
                                    v-model="itemBug.descripcion"></v-text-field>
                        </v-flex>

                    </v-card-title>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                                @click.native="reportarBug"
                                color="teal darken-3"
                                dark
                                depressed
                                large>Enviar
                        </v-btn>
                        <v-btn
                                @click.native="dlgBug = false"
                                color="blue-grey lighten-4"
                                depressed
                                large>Cerrar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <v-flex
                    class="title"
                    xs12>
                <v-chip
                        color="blue-grey darken-2"
                        text-color="white">
                    Utensilios
                    <v-icon right>restaurant</v-icon>
                </v-chip>
                <!--

                <v-chip
                        color="blue-grey darken-2"
                        text-color="white">
                    San Pedro Necta
                    <v-icon right>location_on</v-icon>
                </v-chip>

                -->
            </v-flex>

            <router-view
                    :buscarGlobal="searchParent"
                    :colorDefecto="colorDefecto"
                    :itemsDisplayPersonas="itemsPersonas"
                    :itemsDisplayRols="itemsRols"
                    :itemsDisplayUsuarios="itemsUsuarios"
                    @accDisplayPersonas="setDisplayPersonas"
                    @accDisplayRols="setDisplayRols"
                    @accDisplayUsuarios="setDisplayUsuarios"
                    @accTabs="enviarTab"
                    @mensajeAdvertencia="mensajeAdvertencia"
                    @mensajeError="mensajeError"
                    @mensajeInfo="mensajeInfo"></router-view>
            <eSnack ref="rSnack"></eSnack>
            <!-- <v-flex
                xs12
                >
                <v-card flat>
                    <v-card-media
                        src="/storage/images/categorias/fondoPersonas.png"
                        :height="486"
                        :width="343">
            </v-card-media>

                </v-card>
            </v-flex>  -->


        </v-content>
        <v-footer
                color="grey lighten-5"
                height="auto">
            <v-layout
                    justify-center
                    row
                    wrap>
                <v-flex
                        --text
                        gray
                        py-3
                        text-xs-center
                        xs12>
                    <strong> &copy;{{ new Date().getFullYear() }}</strong> — josephccaceres@gmail.com
                </v-flex>
            </v-layout>
        </v-footer>
    </v-app>
</template>

<script src="./uten_home.js">
</script>
