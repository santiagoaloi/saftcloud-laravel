<template>
 <div>
  <div class="d-flex justify-end align-center">
   <div class="d-flex">
    <v-btn plain @click="dialogEditor = true" class="mx-2 "> <v-icon class="mr-2" small> mdi-code-json </v-icon>Config Structure </v-btn>
    <v-btn plain class="mx-2 "> <v-icon class="mr-2" small> mdi-arrow-top-right </v-icon>Export </v-btn>
    <v-btn class="ml-2" :color="isDark ? 'accent' : 'primary'" @click.stop="dialogComponent = true">
     <v-icon class="mr-2" small> mdi-plus </v-icon>Create component
    </v-btn>
   </div>
  </div>
  <v-divider class="mt-3"></v-divider>

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
  >
   <v-card flat width="100%" class="dialogHeight pt-14">
    <base-editor v-model="ComponentsConfigStructure" mode="json" />
   </v-card>
  </baseDialog>
 </div>
</template>

<script>
import { sync, call } from "vuex-pathify";

export default {
 name: "ComponentsAppbar",

 data() {
  return {
   expand: false,
   dialogEditor: false
  };
 },

 methods: {
  ...call("componentManagement/*")
 },

 mounted() {
  this.getComponentsConfigStructure();
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["dialogComponent", "search", "ComponentsConfigStructure"])
 }
};
</script>
<style>
.dialogHeight {
 height: calc(100vh - 18px);
 overflow-y: auto;
}
</style>
