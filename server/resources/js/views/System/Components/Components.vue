<template>
 <div>
  <components-appbar />
  <components-groups />
  <components-tabs />
  <v-divider />

  <v-card color="transparent" flat :height="calculateHeight()" style="overflow-y:auto">
   <template v-if="!isAllFilteredComponentsEmpty">
    <v-scroll-y-transition hide-on-leave>
     <components-table v-if="isTableLayout" />
    </v-scroll-y-transition>
   </template>

   <template v-if="!isAllFilteredComponentsEmpty">
    <v-scroll-x-transition hide-on-leave>
     <components-grid v-if="!isTableLayout" />
    </v-scroll-x-transition>
   </template>

   <template v-if="isAllFilteredComponentsEmpty">
    <v-scroll-y-transition hide-on-leave>
     <components-no-data />
    </v-scroll-y-transition>
   </template>
  </v-card>

  <dialog-component v-if="dialogs.dialogComponent" />
  <component-edit-sheet />
 </div>
</template>

<script>
import { store } from "@/store";
import { sync, call, get } from "vuex-pathify";

export default {
 name: "ComponentsManagement",
 components: {
  ComponentsTabs: () => import("./ComponentsTabs"),
  ComponentsGrid: () => import("./ComponentsGrid"),
  ComponentsTable: () => import("./ComponentsTable"),
  ComponentsGroups: () => import("./ComponentsGroups"),
  DialogComponent: () => import("./DialogComponent"),
  ComponentsNoData: () => import("./ComponentsNoData"),
  ComponentsAppbar: () => import("./ComponentsAppbar"),
  ComponentEditSheet: () => import("./ComponentsEdit/ComponentsEditSheet")
 },

 data() {
  return {};
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...get("componentManagement", ["isAllFilteredComponentsEmpty", "selectedComponent"]),
  ...sync("componentManagement", ["dialogs", "isTableLayout"])
 },

 mounted() {
  this.getComponents();
  this.getDbTablesAndColumns();
 },

 methods: {
  ...call("componentManagement/*"),
  calculateHeight() {
   return Number(this.$vuetify.breakpoint.height - 350);
  }
 }
};
</script>
