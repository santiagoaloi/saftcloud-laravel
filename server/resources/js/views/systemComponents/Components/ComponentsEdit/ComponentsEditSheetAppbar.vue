<template>
 <v-app-bar flat dense>
  <v-toolbar-title class="white--text">Editing <span class="grey--text"> Products </span></v-toolbar-title>

  <v-spacer></v-spacer>

  <v-btn dark class="mr-2" fab text x-small>
   <v-icon>mdi-chevron-left</v-icon>
  </v-btn>
  <v-btn class="mr-2" dark fab text x-small>
   <v-icon>mdi-chevron-right</v-icon>
  </v-btn>

  <v-btn dark class="mr-2" @click="componentEditSheet = false" fab text x-small>
   <v-icon>mdi-close</v-icon>
  </v-btn>
 </v-app-bar>
</template>

<script>
import axios from "axios";
import { sync, get } from "vuex-pathify";
export default {
 name: "ComponentsEditAppbar",

 data: () => ({}),

 computed: {
  ...sync("componentManagement", ["componentEditSheet"])
  // ...get("componentManagement", ["selectedComponent"]),
 },

 mounted() {},

 methods: {}
};
</script>
