<template>
 <v-navigation-drawer color="#2f3136" v-model="componentEditSheet" mobileBreakpoint="0" hideOverlay width="250">
  <drawer-menu />
 </v-navigation-drawer>
</template>

<script>
import { sync, get } from "vuex-pathify";
export default {
 name: "BaseViewDrawer",
 components: {
  DrawerMenu: () => import("./BaseViewDrawerMenu")
 },
 computed: {
  ...sync("componentManagement", ["componentEditSheet"]),
  ...get("componentManagement", ["hasValidationErrors"])
 }
};
</script>
