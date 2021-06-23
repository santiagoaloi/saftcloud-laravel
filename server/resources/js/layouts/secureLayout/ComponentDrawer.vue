<template>
 <v-navigation-drawer
  mobileBreakpoint="0"
  clipped
  :color="$vuetify.theme.dark ? '#2C2F33' : '#f6f8fa'"
  width="350"
  v-model="secureComponentDrawer"
  hideOverlay
  right
  app
  v-if="$route.name.startsWith('components')"
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

Vue.component("ComponentDrilldown", () => import("@/components/navigation/ComponentDrilldown"));
Vue.component("ComponentDrilldownBar", () => import("@/components/navigation/ComponentDrilldownBar"));

export default {
 name: "SecureComponentDrawer",
 computed: {
  ...sync("drawers", ["secureComponentDrawer"])
 }
};
</script>
