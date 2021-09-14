<template>
 <div>
  <!-- Navigation -->
  <v-navigation-drawer src="storage/sidebar/bg1.jpg" dark width="250" v-model="secureDefaultDrawer" app class="elevation-1">
   <!-- Navigation menu fixed  -->
   <template v-slot:prepend>
    <vue-diagonal
     class="mt-n5"
     :deg="-7"
     background="linear-gradient(331deg, rgba(44, 91, 122, 1) 0%, rgba(109, 115, 135, 1) 0%)"
     space-after
     space-before
    >
     <v-card flat min-height="100" class="transparent px-4 my-2">
      <v-container>
       <div class="title font-weight-bold">SaftCloud ™</div>
       <div class="overline white--text">v5.0.2</div>
       <div class="mt-4" style="margin-left:-4px;">
        <baseFieldLabel color="white" lowerCase label="Company - Branch" />
        <v-select
         :menu-props="{ 'offset-y': true }"
         item-color="primary lighten-4"
         hide-details
         :items="session.user.branches"
         item-text="name"
         item-value="entity_id"
         v-model="session.activeBranch"
         dense
         solo
        ></v-select>
       </div>
      </v-container>
     </v-card>
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
  ...sync("componentManagement", ["navigationStructure"]),
  ...sync("authentication", ["session"])
 },

 methods: {
  ...call("componentManagement/*")
 }
};
</script>
