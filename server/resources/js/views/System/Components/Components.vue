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

  <dialog-component />
  <component-edit-sheet />
 </div>
</template>

<script>
import { store } from "@/store";
import { sync, call, get } from "vuex-pathify";

export default {
 name: "ComponentsManagement",
 components: {
  ComponentsTabs: () => import(/* webpackChunkName: 'components-tabs' */ "./ComponentsTabs"),
  ComponentsGrid: () => import(/* webpackChunkName: 'components-grid' */ "./ComponentsGrid"),
  ComponentsTable: () => import(/* webpackChunkName: 'components-table' */ "./ComponentsTable"),
  ComponentsGroups: () => import(/* webpackChunkName: 'components-groups' */ "./ComponentsGroups"),
  DialogComponent: () => import(/* webpackChunkName: 'components-dialog-new-component' */ "./DialogComponent"),
  ComponentsNoData: () => import(/* webpackChunkName: 'components-no-data' */ "./ComponentsNoData"),
  ComponentsAppbar: () => import(/* webpackChunkName: 'components-appbar' */ "./ComponentsAppbar"),
  ComponentEditSheet: () => import(/* webpackChunkName: 'components-edit-sheet' */ "./ComponentsEdit/ComponentsEditSheet")
 },

 data() {
  return {};
 },

 computed: {
  ...get("componentManagement", ["isAllFilteredComponentsEmpty", "selectedComponent"]),
  ...sync("componentManagement", ["dialogComponent", "isTableLayout"]),
  ...sync("theme", ["isDark"])
 },

 mounted() {
  this.getComponents();
  this.getDbTablesAndColumns();
  this.getDbGroupNames();
 },

 methods: {
  ...call("componentManagement/*"),
  calculateHeight() {
   return Number(this.$vuetify.breakpoint.height - 310);
  }
 }
};
</script>
