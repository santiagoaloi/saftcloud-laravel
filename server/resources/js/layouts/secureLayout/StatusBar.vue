<template>
 <v-card class="transparent" flat tile>
  <v-divider />
  <v-card-actions class="pa-0 mr-3">
   <v-card-text class="py-2 white--text">
    {{ statusBarValue }}
    <span v-if="search" class="blue--text text--lighten-2"> matching "{{ search }}" in search.</span>
   </v-card-text>
   <v-spacer></v-spacer>
   <v-card-text class="py-2 white--text text-end"> {{ countComponentsFiltered }} <span class="ml-2">components found</span></v-card-text>
  </v-card-actions>
 </v-card>
</template>

<script>
import { get, sync } from "vuex-pathify";
export default {
 name: "StatusBar",
 components: {
  StatusBar: () => import(/* webpackChunkName: 'components-status-bar' */ "./StatusBar")
 },
 computed: {
  ...get("componentStatusBar", ["statusBarValue"]),
  ...get("componentManagement", ["countComponentsFiltered"]),
  ...sync("application", ["search"])
 }
};
</script>
