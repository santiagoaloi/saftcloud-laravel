<template>
 <v-navigation-drawer
  mobileBreakpoint="0"
  clipped
  :color="isDark ? '#2C2F33' : '#f0f3f5'"
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

Vue.component("ComponentDrilldown", () =>
 import(/* webpackChunkName: 'components-navigation-drilldown' */ "@/components/navigation/ComponentDrilldown")
);
Vue.component("ComponentDrilldownBar", () =>
 import(/* webpackChunkName: 'components-navigation-drilldown-bar' */ "@/components/navigation/ComponentDrilldownBar")
);

export default {
 name: "SecureComponentDrawer",
 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("drawers", ["secureComponentDrawer"])
 }
};
</script>
