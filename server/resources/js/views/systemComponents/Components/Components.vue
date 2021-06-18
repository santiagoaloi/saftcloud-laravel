<template>
 <div>
  <components-appbar />
  <components-groups />
  <components-tabs />

  <v-card color="transparent" flat :height="calculateHeight()" style="overflow-y:auto">
   <template v-if="!isAllFilteredComponentsEmpty">
    <v-fade-transition hide-on-leave>
     <components-table v-if="isTableLayout" />
    </v-fade-transition>
   </template>

   <template v-if="!isAllFilteredComponentsEmpty">
    <v-fade-transition hide-on-leave>
     <components-grid v-if="!isTableLayout" />
    </v-fade-transition>
   </template>

   <template v-if="isAllFilteredComponentsEmpty">
    <v-fade-transition hide-on-leave>
     <components-no-data />
    </v-fade-transition>
   </template>
  </v-card>

  <dialog-icons />
  <dialog-group v-if="dialogGroup" />
  <dialog-component v-if="dialogComponent" />
  <component-edit-sheet />
 </div>
</template>

<script>
import { store } from "@/store";
import { sync, call, get } from "vuex-pathify";

export default {
 name: "ComponentsManagement",
 components: {
  DialogGroup: () => import("./DialogGroup"),
  DialogIcons: () => import("./DialogIcons"),
  ComponentsTabs: () => import("./ComponentsTabs"),
  ComponentsGrid: () => import("./ComponentsGrid"),
  ComponentsTable: () => import("./ComponentsTable"),
  DialogComponent: () => import("./DialogComponent"),
  ComponentsNoData: () => import("./ComponentsNoData"),
  ComponentsAppbar: () => import("./ComponentsAppbar"),
  ComponentsGroups: () => import("./ComponentsGroups"),
  ComponentEditSheet: () => import("./ComponentsEdit/ComponentsEditSheet")
 },

 data() {
  return {};
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...get("componentManagement", ["isAllFilteredComponentsEmpty"]),
  ...sync("componentManagement", ["dialogComponent", "dialogIcons", "dialogGroup", "isTableLayout"])
 },

 mounted() {
  this.getComponents();
 },

 methods: {
  ...call("componentManagement/*"),
  calculateHeight() {
   return Number(this.$vuetify.breakpoint.height - 375);
  }
 }
};
</script>
