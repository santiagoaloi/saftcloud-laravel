<template>
 <div v-if="selectedComponent">
  <v-app-bar color="transparent" flat dense>
   <v-tooltip transition="false" color="black" bottom>
    <template v-slot:activator="{ on }">
     <v-btn v-on="on" :disabled="previousComponentDisabled" @click="previousComponent()" class="mr-2" fab text x-small>
      <v-icon>mdi-chevron-left</v-icon>
     </v-btn>
    </template>
    <span>Previous component</span>
   </v-tooltip>
   <v-tooltip transition="false" color="black" bottom>
    <template v-slot:activator="{ on }">
     <v-btn v-on="on" :disabled="nextComponentDisabled" @click="nextComponent()" fab text x-small>
      <v-icon>mdi-chevron-right</v-icon>
     </v-btn>
    </template>
    <span>Next component</span>
   </v-tooltip>

   <v-spacer></v-spacer>

   <v-tooltip transition="false" color="black" bottom>
    <template v-slot:activator="{ on }">
     <v-btn v-on="on" @click.stop="secureComponentDrawer = false" fab text x-small>
      <v-icon>mdi-menu</v-icon>
     </v-btn>
    </template>
    <span>Hide</span>
   </v-tooltip>
  </v-app-bar>
 </div>
</template>

<script>
import { sync, call, get } from "vuex-pathify";

export default {
 name: "ComponentDrilldown",
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
