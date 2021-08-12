<template>
 <v-navigation-drawer
  mobileBreakpoint="0"
  clipped
  :color="isDark ? '#2C2F33' : '#edeff0'"
  width="350"
  v-model="secureComponentDrawer"
  hideOverlay
  right
  app
 >
  <!-- Navigation menu fixed on top -->
  <template v-slot:prepend>
   <component-drilldown-bar />
  </template>

  <component-drilldown />
 </v-navigation-drawer>
</template>

<script>
import Vue from "vue";
import { sync, get } from "vuex-pathify";

Vue.component("ComponentDrilldown", () =>
 import(/* webpackChunkName: 'components-navigation-drilldown' */ "@/components/Navigation/ComponentDrilldown")
);
Vue.component("ComponentDrilldownBar", () =>
 import(/* webpackChunkName: 'components-navigation-drilldown-bar' */ "@/components/Navigation/ComponentDrilldownBar")
);

export default {
 name: "SecureComponentDrawer",
 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("drawers", ["secureComponentDrawer"]),
  ...get("componentManagement", ["selectedComponent"])
 }

 //  watch: {
 //   selectedComponent(newVal, oldVal) {
 //    if (newVal) {
 //     this.secureComponentDrawer = true;
 //    } else {
 //     this.secureComponentDrawer = false;
 //    }
 //   }
 //  }
};
</script>
