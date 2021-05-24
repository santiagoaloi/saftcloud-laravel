<template>
  <div>
    <!-- Navigation -->
    <v-navigation-drawer src="storage/systemImages/nav.png" color="rgba(60, 70, 90, 1)" dark width="300" v-model="drawer" app floating class="elevation-1">
      <!-- Navigation menu info -->

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

Vue.component("MainMenu", () => import(/* webpackChunkName: 'Drawer-Menu' */ "@/components/navigation/MainMenu"));

export default {
  name: "SecureDrawer",

  data() {
    return {
      drawer: null,
      navigation: nav
    };
  }
};
</script>
