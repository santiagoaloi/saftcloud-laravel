<template>
 <v-app-bar color="#24292e" flat dense>
  <v-toolbar-title class="white--text"
   >Editing <span class="accent--text text--lighten-4"> {{ selectedComponent.config.general_config.title }} </span></v-toolbar-title
  >

  <v-spacer></v-spacer>

  <v-fade-transition>
   <div v-if="hasUnsavedChanges(selectedComponent)">
    <v-btn rounded :color="isDark ? 'grey darken-3' : 'white'" class="mx-2" small @click="rollbackChanges(selectedComponent)"
     ><span> Rollback changes</span>
    </v-btn>
   </div>
  </v-fade-transition>

  <v-tooltip transition="false" color="black" bottom>
   <template v-slot:activator="{ on }">
    <v-btn color="green lighten-2" v-on="on" @click="validateBeforeSave(selectedComponent)" class="mr-2" x-small text fab>
     <v-icon> mdi-check </v-icon>
    </v-btn>
   </template>
   <span>Save changes</span>
  </v-tooltip>

  <v-tooltip transition="false" color="black" bottom>
   <template v-slot:activator="{ on }">
    <v-btn v-on="on" @click="isDark = !isDark" fab class="mx-2" color="white" text x-small>
     <v-icon v-if="isDark">mdi-lightbulb-on-outline</v-icon>
     <v-icon v-else>mdi-lightbulb-outline</v-icon></v-btn
    >
   </template>
   <span> {{ isDark ? " Light mode" : "Dark mode" }}</span>
  </v-tooltip>

  <v-divider inset vertical class="mx-3 grey" />

  <v-tooltip transition="false" color="black" bottom>
   <template v-slot:activator="{ on }">
    <v-btn v-on="on" dark :disabled="previousComponentDisabled" @click="validateBeforePrevious()" class="mr-2" fab text x-small>
     <v-icon>mdi-chevron-left</v-icon>
    </v-btn>
   </template>
   <span>Previous component</span>
  </v-tooltip>

  <v-tooltip transition="false" color="black" bottom>
   <template v-slot:activator="{ on }">
    <v-btn v-on="on" dark :disabled="nextComponentDisabled" @click="validateBeforeNext()" fab text x-small>
     <v-icon>mdi-chevron-right</v-icon>
    </v-btn>
   </template>
   <span>Next component</span>
  </v-tooltip>

  <v-tooltip transition="false" color="black" bottom>
   <template v-slot:activator="{ on }">
    <v-btn v-on="on" dark class="mx-2" @click="validateBeforeHide()" fab text x-small>
     <v-icon>mdi-chevron-down</v-icon>
    </v-btn>
   </template>
   <span>Hide</span>
  </v-tooltip>
 </v-app-bar>
</template>

<script>
import { store } from "@/store";
import { sync, get, call } from "vuex-pathify";
export default {
 name: "ComponentsEditAppbar",
 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["componentEditSheet", "componentEditDrawerActiveMenu"]),
  ...get("componentManagement", [
   "previousComponentDisabled",
   "nextComponentDisabled",
   "selectedComponent",
   "hasUnsavedChanges",
   "hasValidationErrors"
  ])
 },

 methods: {
  ...call("componentManagement/*"),

  validateBeforeSave(selectedComponent) {
   if (!this.hasValidationErrors) {
    this.saveComponent(selectedComponent);
   } else {
    store.set("snackbar/value", true);
    store.set("snackbar/text", "There are input validation errors, check it out and try again");
    store.set("snackbar/color", "pink darken-1");
   }
  },

  validateBeforePrevious() {
   if (!this.hasValidationErrors) {
    this.previousComponent();
   } else {
    store.set("snackbar/value", true);
    store.set("snackbar/text", "There are input validation errors, check it out and try again");
    store.set("snackbar/color", "pink darken-1");
   }
  },

  validateBeforeNext() {
   if (!this.hasValidationErrors) {
    this.nextComponent();
   } else {
    store.set("snackbar/value", true);
    store.set("snackbar/text", "There are input validation errors, check it out and try again");
    store.set("snackbar/color", "pink darken-1");
   }
  },

  validateBeforeHide() {
   if (!this.hasValidationErrors) {
    this.componentEditSheet = false;
   } else {
    store.set("snackbar/value", true);
    store.set("snackbar/text", "There are input validation errors, check it out and try again");
    store.set("snackbar/color", "pink darken-1");
   }
  }
 }
};
</script>
