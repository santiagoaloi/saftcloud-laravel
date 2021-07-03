<template>
 <div v-if="selectedComponent">
  <v-app-bar class="pa-0 mt-1" color="transparent" flat dense>
   <v-btn :disabled="previousComponentDisabled" @click="previousComponent()" class="mr-2" fab text x-small>
    <v-icon>mdi-chevron-left</v-icon>
   </v-btn>
   <v-btn :disabled="nextComponentDisabled" @click="nextComponent()" fab text x-small>
    <v-icon>mdi-chevron-right</v-icon>
   </v-btn>
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
