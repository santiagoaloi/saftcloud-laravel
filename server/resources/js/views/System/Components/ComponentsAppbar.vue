<template>
 <div>
  <div class="d-flex justify-space-between align-center">
   <h3 class="hidden-sm-and-down ">Manage components</h3>
   <div class="d-flex">
    <v-text-field
     v-model.lazy="search"
     spellcheck="false"
     :outlined="isDark"
     :solo="!isDark"
     :color="isDark ? '#208ad6' : 'grey'"
     :background-color="isDark ? 'grey darken-4' : 'grey lighten-5'"
     dense
     hide-details
     placeholder="Search components..."
     prepend-inner-icon="mdi-magnify"
     :class="expand ? 'expanded' : 'shrinked'"
     class="mx-2"
     @focus="expand = true"
     @blur="expand = false"
    />

    <v-btn :color="isDark ? 'grey darken-4' : ''" @click="dialogEditor = true" class="mx-2 ">
     <v-icon class="mr-2" small> mdi-code-json </v-icon>Config Structure
    </v-btn>
    <v-btn class="mx-2 " :color="isDark ? 'grey darken-4' : ''"> <v-icon class="mr-2" small> mdi-arrow-top-right </v-icon>Export </v-btn>
    <v-btn class="ml-2" :color="isDark ? 'accent' : 'primary'" @click.stop="dialogComponent = true">
     <v-icon class="mr-2" small> mdi-plus </v-icon>Create component
    </v-btn>
   </div>
  </div>
  <p class="my-3">Edit components settings, groups folders or drill down for more information</p>
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
