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
 </div>
</template>

<script>
import { sync, call, get } from "vuex-pathify";
export default {
 name: "AccountsManagement",
 components: {
  AccountsTabs: () => import(/* webpackChunkName: 'accounts-tabs' */ "./AccountsTabs"),
  AccountsGrid: () => import(/* webpackChunkName: 'accounts-grid' */ "./AccountsGrid"),
  AccountsTable: () => import(/* webpackChunkName: 'accounts-table' */ "./AccountsTable"),
  AccountsGroups: () => import(/* webpackChunkName: 'accounts-groups' */ "./AccountsGroups"),
  AccountsAppbar: () => import(/* webpackChunkName: 'accounts-appbar' */ "./AccountsAppbar"),
  AccountsNoData: () => import(/* webpackChunkName: 'accounts-no-data' */ "./AccountsNoData"),
  DialogAccount: () => import(/* webpackChunkName: 'accounts-dialog-account' */ "./DialogAccount")
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("accountsManagement", ["isTableLayout"]),
  ...get("accountsManagement", ["isAllFilteredComponentsEmpty"])
 },

 mounted() {
  //   this.getComponents();
  //   this.getDbGroupNames();
  //   this.getDbTablesAndColumns();
 },

 methods: {
  ...call("accountsManagement/*"),
  calculateHeight() {
   return Number(this.$vuetify.breakpoint.height - 366);
  }
 }
};
</script>

<style></style>
