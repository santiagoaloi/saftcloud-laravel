<template>
 <v-card :class="{ transparent: isDark, 'grey darken-3 ': !isDark }" flat tile>
  <v-divider />
  <v-card-actions class="pa-0 mr-3">
   <small class="py-2 white--text col-9 text-truncate">
    {{ statusBarValue }}
    <span v-if="search" class="blue--text text--lighten-2"> matching "{{ search }}" in search.</span>
   </small>
   <v-spacer></v-spacer>
   <small class="py-2 white--text text-end col-3 text-truncate"> {{ countComponentsFiltered }} <span class="ml-2">components found</span></small>
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
  ...sync("theme", ["isDark"]),
  ...get("componentStatusBar", ["statusBarValue"]),
  ...get("componentManagement", ["countComponentsFiltered"]),
  ...sync("application", ["search"])
 }
};
</script>
