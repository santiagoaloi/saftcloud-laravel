<template>
  <div>
    <v-navigation-drawer color="white" width="350" v-model="secureComponentDrawer" hideOverlay right app class="elevation-1">
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

  data() {
    return {};
  },
  computed: {
    ...sync("drawers", ["secureComponentDrawer"])
  }
};
</script>
