<template>
    <div class="eTiempo">

        <v-card flat color="white"
        >
            <v-card-text>

                <v-layout

                >
                    <span class="subheading"> {{this.texto}}</span>

                    <v-card color="white"
                            flat
                            width="200"
                    >
                        <v-layout
                                align-center justify-center

                        >
                            <v-select
                                    :items="horas"
                                    flat
                                    autocomplete
                                    v-model="mHoras"
                            >
                            </v-select>
                            <span class="headline"> &nbsp;:&nbsp;  </span>
                            <v-select
                                    :items="minutos"
                                    autocomplete
                                    flat
                                    v-model="mMinutos"
                            >
                            </v-select>
                        </v-layout>
                    </v-card>

                </v-layout>
            </v-card-text>

        </v-card>
    </div>
</template>

<script>
    export default {
        name: 'eTiempo',
        props: {
            texto: String,
        },

        data: () => ({
            minutos: [
                "00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59","60"
            ],
            horas:[
                "00","01","02","03","04","05","06","07","08","09","10","11","12"
            ],
            mMinutos:"00",
            mHoras:"00"
        }),

        methods: {

            getHora() {
                return [mMinutos, mHoras];
            }
        }
    };
</script>
