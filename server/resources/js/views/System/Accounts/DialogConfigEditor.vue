<template>
 <baseDialog
  v-model="dialogEditor"
  fullscreen
  transition="dialog-bottom-transition"
  @save="saveComponentsConfigStructure()"
  @close="dialogEditor = false"
  width="60vw"
  no-gutters
  absoluteToolbar
  title="Components config structure"
  filled
  fluid
  icon="mdi-code-json"
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
