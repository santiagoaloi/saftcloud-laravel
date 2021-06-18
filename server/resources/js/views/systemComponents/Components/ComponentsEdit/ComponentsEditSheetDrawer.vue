<template>
 <v-navigation-drawer
  v-model="componentEditSheet"
  mobileBreakpoint="0"
  :color="$vuetify.theme.dark ? '#2C2F33' : 'grey lighten-5'"
  width="350"
  hideOverlay
  class="elevation-3"
 >
  <!-- Navigation menu fixed  -->
  <template v-slot:prepend>
   <!-- <component-drilldown-bar /> -->
  </template>
 </v-navigation-drawer>
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
