<template>
 <v-navigation-drawer src="storage/sidebar/bg1.jpg" color="#2f3136" v-model="componentEditSheet" mobileBreakpoint="0" hideOverlay width="250">
  <components-edit-sheet-menu />
 </v-navigation-drawer>
</template>

<script>
import { sync, get } from "vuex-pathify";
export default {
 name: "ComponentsEditSheetDrawer",
 components: {
  ComponentsEditSheetMenu: () => import("./ComponentsEditSheetMenu")
 },
 computed: {
  ...sync("componentManagement", ["componentEditSheet"]),
  ...get("componentManagement", ["hasValidationErrors"])
 }
};
</script>
