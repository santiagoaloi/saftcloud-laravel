<template>
 <v-data-table
  fixed-header
  checkbox-color="primary"
  item-key="id"
  show-select
  :height="calculateHeight()"
  :headers="tableHeaders"
  :items="allComponentsFiltered"
  :items-per-page="-1"
  class="elevation-0 mt-2"
 ></v-data-table>
</template>

<script>
import { store } from "@/store";
import globalMixin from "@/mixins/globalMixin";
import { sync, call, get } from "vuex-pathify";

export default {
 name: "ComponentsTableView",

 data() {
  return {};
  allComponentsFiltered;
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["tableHeaders"]),
  ...get("componentManagement", ["allComponentsFiltered"])
 },

 methods: {
  ...call("componentManagement/*"),
  calculateHeight() {
   return Number(this.$vuetify.breakpoint.height - 420);
  }
 }
};
</script>
