<template>
 <baseDialog
  v-model="dialogEditor"
  transition="fade-transition"
  @save="saveComponentsConfigStructure()"
  @close="dialogEditor = false"
  width="70vw"
  no-gutters
  absoluteToolbar
  title="Components config structure"
  filled
  fluid
  icon="mdi-code-json"
  noContainer
 >
  <v-card flat width="100%" class="dialogHeight">
   <base-editor v-model="componentsConfigStructure" mode="json" />
  </v-card>
 </baseDialog>
</template>
<script>
import { sync, call } from "vuex-pathify";
export default {
 name: "DialogComponent",

 mounted() {
  this.getComponentsConfigStructure();
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["dialogEditor", "componentsConfigStructure"])
 },

 methods: {
  ...call("componentManagement/*")
 }
};
</script>
<style>
.dialogHeight {
 height: calc(100vh - 300px);
 overflow-y: auto;
}
</style>
