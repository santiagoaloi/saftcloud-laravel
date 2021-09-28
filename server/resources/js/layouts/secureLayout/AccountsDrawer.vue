<template>
 <v-navigation-drawer
  mobileBreakpoint="0"
  clipped
  :color="isDark ? '#2E3139' : '#edeff0'"
  width="350"
  v-model="secureAccountsDrawer"
  hideOverlay
  right
  app

 >
  <!-- Navigation menu fixed on top -->
  <template v-slot:prepend>
   <accounts-drilldown-bar />
  </template>

  <accounts-drilldown />
 </v-navigation-drawer>
</template>

<script>
import Vue from "vue";
import { sync, get } from "vuex-pathify";

Vue.component("AccountsDrilldown", () => import(/* webpackChunkName: 'accounts-navigation-drilldown' */ "@/components/Navigation/AccountsDrilldown"));
Vue.component("AccountsDrilldownBar", () =>
 import(/* webpackChunkName: 'accounts-navigation-drilldown-bar' */ "@/components/Navigation/AccountsDrilldownBar")
);

export default {
 name: "AccountComponentDrawer",
 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("drawers", ["secureAccountsDrawer"]),
  ...get("accountsManagement", ["selectedEntity"])
 },

 watch: {
  selectedEntity: {
   immediate: false,
   handler(val) {
    if (val || !this.secureAccountsDrawer) {
     this.secureAccountsDrawer = true;
    } else {
     this.secureAccountsDrawer = false;
    }
   }
  }
 }
};
</script>
