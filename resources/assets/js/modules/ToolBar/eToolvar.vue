<template id="etoolvar">

    <v-app id="inspire">
        <v-toolbar
                :clipped-left="$vuetify.breakpoint.lgAndUp"
                :color="colorBarra"
                app
                dark
                fixed
                tabs
        >
            <v-toolbar-title
                    class="ml-0 pl-3 hidden-sm-and-down"
                    style="width: 300px">
                <span>Restaurante&nbsp;<span class="text">El Mirador</span></span>
            </v-toolbar-title>
            <v-text-field
                    append-icon="search"
                    class="mx-3"
                    flat
                    label="Buscar"
                    prepend-inner-icon="search"
                    ref="focoBuscar"
                    solo-inverted
                    clearable
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
                        <v-list-tile-title>Sugerencias</v-list-tile-title>
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
                        :key="item.id"
                        :ripple="false"
                        :to="item.path"
                        v-for="item in subModulos"
                >
                    {{item.nombre}}
                </v-tab>
            </v-tabs>
        </v-toolbar>



        <!-- CONTENIDOS -->
        <v-content>

            <v-chip
                    v-if="chip.nombre!=''"
                    color="blue-grey darken-2"
                    text-color="white">
                {{chip.nombre}}
                <v-icon right>{{chip.icono}}</v-icon>
            </v-chip>

            <router-view
                    :colorDefecto="colorDefecto"
                    :buscar="searchParent"
                    @mensajeAdvertencia="mensajeAdvertencia"
                    @mensajeError="mensajeError"
                    @mensajeInfo="mensajeInfo"
            ></router-view>
            <v-flex xs12 height="250">
                <v-card  flat  >
                    <v-parallax src="/storage/images/categorias/fondoHome.png" :height="800"  >
                    </v-parallax>
                </v-card>
            </v-flex>
        </v-content>

        <!-- Atajos  -->
        <v-dialog
                max-width="500px"
                v-model="dlgAtajos">
            <v-card class="title">
                <v-card-title>
                    <v-flex
                            :key="item.id"
                            v-for="(item, index) in atajos1"
                            class="subheading"
                            xs12>
                        <v-card-text>

                            <span v-if="item.tipo==1">{{index}}){{item.nombre}}  <strong>{{item.combinacion}}</strong></span>
                            <span v-else><strong>{{item.nombre}}</strong></span>

                        </v-card-text>
                        <v-divider></v-divider>
                    </v-flex>
                </v-card-title>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                            @click.native="dlgAtajos = false"
                            color="blue-grey lighten-4"
                            depressed
                            ref="btnAtajos"
                            large>Cerrar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- BUG  -->
        <v-dialog
                max-width="500px"
                v-model="dlgBug">
            <v-card>

                <v-card-title>
                    <span class="headline">¿Cuál es su duda o sugerencia?</span>
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


        <!-- SNACK -->
        <eSnack ref="rSnack"></eSnack>

        <!-- FOOTER-->
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
                    <strong> &copy;{{ new Date().getFullYear() }}</strong> — josephccaceres@gmail.com - Cel:50363641
                </v-flex>
            </v-layout>
        </v-footer>

    </v-app>

</template>

<script src="./eToolbar.js">
</script>
