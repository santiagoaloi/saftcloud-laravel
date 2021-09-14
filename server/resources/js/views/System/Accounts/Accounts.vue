<template>
 <div>
  <accounts-appbar />
  <accounts-groups />
  <accounts-tabs />

  <v-divider />

  <v-card color="transparent" flat :height="calculateHeight()" :class="{ dottedBackground: !isTableLayout }" class="overflow-y-scroll ">
   <v-scroll-y-transition hide-on-leave>
    <accounts-table v-if="isTableLayout && !isAllFilteredComponentsEmpty" />
   </v-scroll-y-transition>

   <v-scroll-x-transition hide-on-leave>
    <accounts-grid v-if="!isTableLayout && !isAllFilteredComponentsEmpty" />
   </v-scroll-x-transition>

   <v-scroll-y-transition hide-on-leave>
    <accounts-no-data v-if="isAllFilteredComponentsEmpty" />
   </v-scroll-y-transition>
  </v-card>

  <dialog-account />
  <component-edit-sheet />
 </div>
</template>

<script>
import { sync, call, get } from "vuex-pathify";
export default {
 name: "AccountsManagement",
 components: {
  AccountsTabs: () => import(/* webpackChunkName: 'components-tabs' */ "./AccountsTabs"),
  AccountsGrid: () => import(/* webpackChunkName: 'components-grid' */ "./AccountsGrid"),
  AccountsTable: () => import(/* webpackChunkName: 'components-table' */ "./AccountsTable"),
  AccountsGroups: () => import(/* webpackChunkName: 'components-groups' */ "./AccountsGroups"),
  AccountsAppbar: () => import(/* webpackChunkName: 'components-appbar' */ "./AccountsAppbar"),
  AccountsNoData: () => import(/* webpackChunkName: 'components-no-data' */ "./AccountsNoData"),
  DialogAccount: () => import(/* webpackChunkName: 'components-dialog-account' */ "./DialogAccount"),
  ComponentEditSheet: () => import(/* webpackChunkName: 'components-edit-sheet' */ "./ComponentsEdit/ComponentsEditSheet")
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("accountsManagement", ["isTableLayout"]),
  ...get("accountsManagement", ["isAllFilteredComponentsEmpty", "selectedComponent"])
 },

 mounted() {
  this.getComponents();
  this.getDbGroupNames();
  this.getDbTablesAndColumns();
 },

 methods: {
  ...call("componentManagement/*"),
  calculateHeight() {
   return Number(this.$vuetify.breakpoint.height - 366);
  }
 }
};
</script>

<style></style>
