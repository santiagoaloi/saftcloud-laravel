<template>
 <v-data-table
  fixed-header
  height="40vh"
  checkbox-color="primary"
  item-key="id"
  show-select
  :headers="tableHeaders"
  :items="allComponentsFiltered"
  :items-per-page="5"
  class="elevation-0"
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
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["tableHeaders"]),
  ...get("componentManagement", ["allComponentsFiltered"])
 },

 methods: {
  ...call("componentManagement/*")
 }
};
</script>

<style scoped lang="scss">
.theme--dark.v-tabs .v-tab--active:hover::before,
.theme--dark.v-tabs .v-tab--active::before {
 opacity: 0;
}

.v-tab:before {
 background-color: unset;
}
</style>
