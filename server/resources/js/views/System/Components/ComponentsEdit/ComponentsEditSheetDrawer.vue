<template>
 <v-navigation-drawer
  src="storage/sidebar/sidebar.svg"
  color="#2f3136"
  v-model="componentEditSheet"
  mobileBreakpoint="0"
  hideOverlay
  width="250"
  clipped
 >
  <components-edit-sheet-menu />
 </v-navigation-drawer>
</template>

<script>
import axios from "axios";
import { sync } from "vuex-pathify";
export default {
 name: "ComponentsEditSheetDrawer",
 components: {
  ComponentsEditSheetMenu: () => import("./ComponentsEditSheetMenu")
 },
 data: () => ({}),

 computed: {
  ...sync("componentManagement", ["componentEditSheet"])
 }
};
</script>
