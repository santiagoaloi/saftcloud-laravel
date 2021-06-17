<template>
 <v-navigation-drawer
  mobileBreakpoint="0"
  clipped
  :color="$vuetify.theme.dark ? '#2C2F33' : 'grey lighten-5'"
  width="350"
  v-model="secureComponentDrawer"
  hideOverlay
  right
  app
  class="elevation-3"
  v-if="$route.name == 'components'"
 >
  <!-- Navigation menu fixed  -->
  <template v-slot:prepend>
   <component-drilldown-bar />
  </template>

  <component-drilldown />
 </v-navigation-drawer>
</template>

<script>
import Vue from "vue";
import { sync } from "vuex-pathify";

Vue.component("ComponentDrilldownBar", () => import("@/components/navigation/ComponentDrilldownBar"));
Vue.component("ComponentDrilldown", () => import("@/components/navigation/ComponentDrilldown"));

export default {
 name: "SecureComponentDrawer",
 computed: {
  ...sync("drawers", ["secureComponentDrawer"])
 }
};
</script>
