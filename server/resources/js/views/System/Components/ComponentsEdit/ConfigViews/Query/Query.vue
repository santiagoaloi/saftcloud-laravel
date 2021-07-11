<template>
 <div>
  <v-card flat width="100%" class="queryHeight">
   <base-editor :key="editorKey" v-model="selectedComponent.config.general_config.sql_query" mode="sql" />
  </v-card>
 </div>
</template>

<script>
import axios from "axios";
import { sync, call, get } from "vuex-pathify";
export default {
 name: "ComponentsEditQuery",
 components: {},
 data: () => ({
  editorKey: 800
 }),

 watch: {
  isDark(oldValue, newValue) {
   if (oldValue !== newValue) {
    this.editorKey++;
   }
  }
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...get("componentManagement", ["selectedComponent"])
 },

 methods: {
  ...call("componentManagement/*")
 }
};
</script>

<style scoped>
.queryHeight {
 height: calc(100vh - 103px);
 overflow-y: auto;
}
</style>
