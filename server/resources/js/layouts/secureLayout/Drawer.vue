<template>
 <div>
  <!-- Navigation -->
  <v-navigation-drawer color="#2f3136" dark width="250" v-model="secureDefaultDrawer" app class="elevation-1">
   <!-- Navigation menu fixed  -->
   <template v-slot:prepend>
    <div class="px-4 my-2">
     <div class="title font-weight-bold accent--text ">SaftCloud</div>
     <div class="overline grey--text">v5.0.2</div>
    </div>
   </template>

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
