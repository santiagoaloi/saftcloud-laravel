<template>
 <div class="mt-3" v-if="selectedComponent">
  <v-app-bar color="transparent" flat dense>
   <v-tooltip transition="false" color="black" bottom>
    <template v-slot:activator="{ on }">
     <v-btn v-on="on" :disabled="previousComponentDisabled" @click="previousComponent()" class="ml-n2 mr-2 mt-n2" fab text x-small>
      <v-icon>mdi-chevron-left</v-icon>
     </v-btn>
    </template>
    <span>Previous component</span>
   </v-tooltip>
   <v-tooltip transition="false" color="black" bottom>
    <template v-slot:activator="{ on }">
     <v-btn v-on="on" :disabled="nextComponentDisabled" @click="nextComponent()" class=" mt-n2" fab text x-small>
      <v-icon>mdi-chevron-right</v-icon>
     </v-btn>
    </template>
    <span>Next component</span>
   </v-tooltip>

   <v-spacer />

   <v-tooltip transition="false" color="black" bottom>
    <template v-slot:activator="{ on }">
     <v-btn v-on="on" @click.stop="secureComponentDrawer = false" class=" mt-n2 mr-n1" fab text x-small>
      <v-icon>mdi-menu</v-icon>
     </v-btn>
    </template>
    <span>Hide</span>
   </v-tooltip>
  </v-app-bar>
  <v-divider></v-divider>
 </div>
</template>

<script>
import { sync, call, get } from "vuex-pathify";

export default {
 name: "ComponentDrilldown",
 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("drawers", ["secureAccountsDrawer"]),
  ...sync("accountsManagement", ["componentCardGroup"]),
  ...get("accountsManagement", ["previousComponentDisabled", "nextComponentDisabled", "selectedComponent"])
 },

 methods: {
  ...call("accountManagement/*")
 }
};
</script>
