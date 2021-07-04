<template>
 <div v-if="selectedComponent">
  <v-app-bar class="pa-0 mt-1" color="transparent" flat dense>
   <v-tooltip transition="false" color="black" bottom>
    <template v-slot:activator="{ on, attrs }">
     <v-btn v-on="on" dark :disabled="previousComponentDisabled" @click="previousComponent()" class="mr-2" fab text x-small>
      <v-icon>mdi-chevron-left</v-icon>
     </v-btn>
    </template>
    <span>Previous component</span>
   </v-tooltip>
   <v-tooltip transition="false" color="black" bottom>
    <template v-slot:activator="{ on, attrs }">
     <v-btn v-on="on" dark :disabled="nextComponentDisabled" @click="nextComponent()" fab text x-small>
      <v-icon>mdi-chevron-right</v-icon>
     </v-btn>
    </template>
    <span>Next component</span>
   </v-tooltip>

   <v-spacer></v-spacer>

   <v-btn @click.stop="secureComponentDrawer = false" fab text x-small>
    <v-icon>mdi-menu</v-icon>
   </v-btn>
  </v-app-bar>
 </div>
</template>

<script>
import { sync, call, get } from "vuex-pathify";
import { store } from "@/store";

export default {
 name: "ComponentDrilldown",

 data: () => ({}),

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("drawers", ["secureComponentDrawer"]),
  ...sync("componentManagement", ["componentCardGroup"]),
  ...get("componentManagement", ["previousComponentDisabled", "nextComponentDisabled", "selectedComponent"])
 },

 methods: {
  ...call("componentManagement/*")
 }
};
</script>
