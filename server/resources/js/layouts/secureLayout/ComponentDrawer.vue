<template>
  <div>
    <v-navigation-drawer
      v-if="secureComponentDrawer"
      stateless
      color="white"
      width="350"
      v-model="secureComponentDrawer"
      hideOverlay
      right
      app
      class="elevation-1"
    >
      <component-drilldown />
    </v-navigation-drawer>
  </div>
</template>

<script>
import Vue from "vue";
import { sync } from "vuex-pathify";

Vue.component("ComponentDrilldown", () =>
  import(/* webpackChunkName: 'Drawer-Menu' */ "@/components/navigation/ComponentDrilldown")
);

export default {
  name: "SecureComponentDrawer",
  computed: {
    ...sync("drawers", ["secureComponentDrawer"]),
    ...sync("componentManagement", ["componentCardGroup"])
  },
  watch: {
    componentCardGroup(val) {
      if (val === undefined) {
        this.secureComponentDrawer = false;
      }
    }
  }
};
</script>
<style scoped></style>
