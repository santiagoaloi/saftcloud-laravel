<template>
 <v-app-bar color="#24292e" flat dense>
  <v-toolbar-title class="white--text"
   >Editing <span class="grey--text"> {{ selectedComponent.config.title }} </span></v-toolbar-title
  >

  <v-spacer></v-spacer>

  <v-fade-transition>
   <div v-if="hasUnsavedChanges(selectedComponent)">
    <v-btn :color="isDark ? 'grey darken-3' : 'grey lighten-5'" class="mx-2" small @click="rollbackChanges(selectedComponent)"
     ><span class="red--text text--lighten-2  mr-2"> Unsaved </span> | rollback
    </v-btn>
   </div>
  </v-fade-transition>

  <v-btn class="mr-2" x-small color="white" outlined text fab>
   <v-icon color="green lighten-2"> mdi-check </v-icon>
  </v-btn>

  <v-tooltip transition="false" color="black" bottom>
   <template v-slot:activator="{ on, attrs }">
    <v-btn v-on="on" @click="isDark = !isDark" fab class="mx-2" color="white" text x-small fab>
     <v-icon v-if="isDark">mdi-lightbulb-on-outline</v-icon>
     <v-icon v-else>mdi-lightbulb-outline</v-icon></v-btn
    >
   </template>
   <span> {{ isDark ? " Light mode" : "Dark mode" }}</span>
  </v-tooltip>

  <v-divider inset vertical class="mx-3 grey" />

  <v-btn dark :disabled="previousComponentDisabled" @click="previousComponent()" class="mr-2" fab text x-small>
   <v-icon>mdi-chevron-left</v-icon>
  </v-btn>
  <v-btn dark :disabled="nextComponentDisabled" @click="nextComponent()" fab text x-small>
   <v-icon>mdi-chevron-right</v-icon>
  </v-btn>

  <v-btn dark class="mr-2" @click="close()" fab text x-small>
   <v-icon>mdi-chevron-down</v-icon>
  </v-btn>
 </v-app-bar>
</template>

<script>
import axios from "axios";
import { sync, get, call } from "vuex-pathify";
export default {
 name: "ComponentsEditAppbar",

 data: () => ({}),

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["componentEditSheet"]),
  ...get("componentManagement", ["previousComponentDisabled", "nextComponentDisabled", "selectedComponent", "hasUnsavedChanges"])
 },

 methods: {
  ...call("componentManagement/*"),

  close() {
   this.componentEditSheet = false;
  }
 }
};
</script>
