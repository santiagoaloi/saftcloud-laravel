<template>
  <div>
    <!-- Navigation -->
    <v-navigation-drawer color="rgba(60, 70, 90, 1)" dark width="250" v-model="secureDefaultDrawer" app class="elevation-1">
      <!-- Navigation menu -->
      <main-menu class="pa-2" :menu="navigation.menu" />
    </v-navigation-drawer>
  </div>
</template>

<script>
// navigation menu configurations
import nav from "@/configs/navigation";
import axios from "axios";
import Vue from "vue";
import { sync } from "vuex-pathify";

Vue.component("MainMenu", () => import(/* webpackChunkName: 'Drawer-Menu' */ "@/components/navigation/MainMenu"));

export default {
  name: "SecureDrawer",

  data() {
    return {
      navigation: nav
    };
  },
  computed: {
    ...sync("drawers", ["secureDefaultDrawer"])
  }
};
</script>
