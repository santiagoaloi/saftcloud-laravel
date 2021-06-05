<template>
 <v-navigation-drawer
  v-if="secureComponentDrawer"
  color="white"
  width="350"
  v-model="secureComponentDrawer"
  hideOverlay
  right
  app
  class="elevation-0"
 >
  <component-drilldown />
 </v-navigation-drawer>
</template>

<script>
import Vue from "vue";
import { sync } from "vuex-pathify";

Vue.component("ComponentDrilldown", () => import("@/components/navigation/ComponentDrilldown"));

export default {
 name: "SecureComponentDrawer",
 computed: {
  ...sync("drawers", ["secureComponentDrawer"])
  // ...sync("componentManagement", ["componentCardGroup"])
 }
 // watch: {
 //   componentCardGroup(val) {
 //     if (val === undefined) {
 //       this.secureComponentDrawer = false;
 //     }
 //   }
 // }
};
</script>
