<template>
 <v-snackbar v-model="snack" :timeout="6000" :color="snackbar.color" transition="slide-y-reverse-transition" multi-line>
  {{ snackbar.text }}
  <template v-slot:action="{ attrs }">
   <v-btn dark text fab x-small v-bind="attrs" @click="snack = false">
    <v-icon>mdi-close</v-icon>
   </v-btn>
  </template>
 </v-snackbar>
</template>

<script>
// Utilities
import { get, sync } from "vuex-pathify";

export default {
 name: "DefaultSnackbar",

 computed: {
  snackbar: sync("snackbar"),
  snack: sync("snackbar/value")
 },

 watch: {
  snack(val) {
   if (!val) return;
   val = false;
  }
 }
};
</script>
