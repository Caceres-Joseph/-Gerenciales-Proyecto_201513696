<template>
  <v-layout column> 
   <v-layout row wrap>
       <v-flex xs12>
    <v-select
    v-model="chips"
    label="Your favorite hobbies"
    chips
    tags
    solo
    prepend-icon="filter_list"
    append-icon=""  
  >
    <template slot="selection" slot-scope="data">
      <v-chip
        :selected="data.selected"
        close
        @input="remove(data.item)"
      >
        <strong>{{ data.item }}</strong>&nbsp; 
      </v-chip>
    </template>

  </v-select>
</v-flex>
<v-flex xs12>
  <v-btn color="success" @click="guardar">Guardar</v-btn>
</v-flex>
    
      
    
  </v-layout>

  
  </v-layout>
</template>

<script src ="./observaciones.js">