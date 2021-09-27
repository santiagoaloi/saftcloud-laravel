<template>
 <div>
  <components-appbar />
  <!-- <components-groups /> -->
  <components-tabs />

  <v-divider />

  <v-card color="transparent" flat :height="calculateHeight()" :class="{ dottedBackground: !isTableLayout }" class="overflow-y-scroll ">
   <v-scroll-y-transition hide-on-leave>
    <components-table v-if="isTableLayout && !isAllFilteredComponentsEmpty" />
   </v-scroll-y-transition>

   <v-scroll-x-transition hide-on-leave>
    <components-grid v-if="!isTableLayout && !isAllFilteredComponentsEmpty" />
   </v-scroll-x-transition>

   <v-scroll-y-transition hide-on-leave>
    <components-no-data v-if="isAllFilteredComponentsEmpty" />
   </v-scroll-y-transition>
  </v-card>

  <dialog-component />
  <component-edit-sheet />
 </div>
</template>

<script>
import { sync, call, get } from "vuex-pathify";
export default {
 name: "ComponentsManagement",
 components: {
  ComponentsTabs: () => import(/* webpackChunkName: 'components-tabs' */ "./ComponentsTabs"),
  ComponentsGrid: () => import(/* webpackChunkName: 'components-grid' */ "./ComponentsGrid"),
  ComponentsTable: () => import(/* webpackChunkName: 'components-table' */ "./ComponentsTable"),
  ComponentsGroups: () => import(/* webpackChunkName: 'components-groups' */ "./ComponentsGroups"),
  ComponentsAppbar: () => import(/* webpackChunkName: 'components-appbar' */ "./ComponentsAppbar"),
  ComponentsNoData: () => import(/* webpackChunkName: 'components-no-data' */ "./ComponentsNoData"),
  DialogComponent: () => import(/* webpackChunkName: 'components-dialog-new-component' */ "./DialogComponent"),
  ComponentEditSheet: () => import(/* webpackChunkName: 'components-edit-sheet' */ "./ComponentsEdit/ComponentsEditSheet")
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["isTableLayout"]),
  ...get("componentManagement", ["isAllFilteredComponentsEmpty", "selectedComponent"])
 },

 mounted() {
  this.getComponents();
  this.getDbGroupNames();
  this.getDbTablesAndColumns();
 },

 methods: {
  ...call("componentManagement/*"),
  calculateHeight() {
   return Number(this.$vuetify.breakpoint.height - 367);
  }
 }
};
</script>

<style></style>
