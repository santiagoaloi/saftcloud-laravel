<template>
 <div>
  <!-- Navigation -->
  <v-navigation-drawer src="storage/sidebar/bg1.jpg" dark width="250" v-model="secureDefaultDrawer" app class="elevation-1">
   <!-- Navigation menu fixed  -->
   <template v-slot:prepend>
    <vue-diagonal
     class="mt-n5"
     :deg="7"
     background="linear-gradient(331deg, rgba(209, 31, 171, 0.6) 0%, rgba(136, 160, 247, 0.6) 50%)"
     space-after
     space-before
    >
     <div class="px-4 my-2">
      <div class="title font-weight-bold">SaftCloud ™</div>
      <div class="overline grey--text">v5.0.2</div>
     </div>
    </vue-diagonal>
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

Vue.component("MainMenu", () => import(/* webpackChunkName: 'components-drawer-menu' */ "@/components/Navigation/MainMenu"));

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
