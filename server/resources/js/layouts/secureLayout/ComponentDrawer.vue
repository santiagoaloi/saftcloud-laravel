<template>
 <v-navigation-drawer
  mobileBreakpoint="0"
  clipped
  :color="isDark ? '#2E3139' : '#edeff0'"
  width="350"
  :value="drawer"
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
import { isEmpty} from 'lodash';
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
  ...get("componentManagement", ["selectedComponent"]),

  drawer(){

      
          if ( !this.selectedComponent || !this.secureComponentDrawer) {
return false
    } else {
     return true

    }
  }
 },

//  watch: {
//   selectedComponent: {
//    immediate: false,
//    handler(val) {
//     if (isEmpty(val) || this.secureComponentDrawer) {
//          this.secureComponentDrawer = false;

//     } else {
//      this.secureComponentDrawer = true;
//     }
//    }
//   }
//  }
};
</script>
