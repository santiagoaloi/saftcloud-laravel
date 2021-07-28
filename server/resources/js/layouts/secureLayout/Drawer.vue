<template>
 <div>
  <!-- Navigation -->
  <v-navigation-drawer src="storage/sidebar/bg1.jpg" dark width="250" v-model="secureDefaultDrawer" app class="elevation-1">
   <!-- Navigation menu fixed  -->
   <template v-slot:prepend>
    <div class="px-4 my-2">
     <div class="title font-weight-bold accent--text ">SaftCloud</div>
     <div class="overline grey--text">v5.0.2</div>
    </div>
   </template>

   <!-- Navigation menu -->
   <main-menu class="pa-2" :menu="navigationStructure.menu" />
  </v-navigation-drawer>
 </div>
</template>

<script>
import nav from "@/configs/navigation";
import Vue from "vue";
import { sync, call } from "vuex-pathify";

Vue.component("MainMenu", () => import(/* webpackChunkName: 'components-drawer-menu' */ "@/components/navigation/MainMenu"));

export default {
 name: "SecureDrawer",
 mounted() {
  this.getNavigationStructure();
 },
 computed: {
  ...sync("drawers", ["secureDefaultDrawer"]),
  ...sync("componentManagement", ["navigationStructure"])
 },

 methods: {
  ...call("componentManagement/*")
 }
};
</script>
