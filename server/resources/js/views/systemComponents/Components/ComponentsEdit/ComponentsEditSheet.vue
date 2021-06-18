<template>
 <div class="text-center">
  <v-bottom-sheet fullscreen v-model="componentEditSheet">
   <v-sheet class="text-center" height="100%" color="#f6f8fa">
    <components-edit-sheet-appbar />
    <components-edit-sheet-drawer />
   </v-sheet>
  </v-bottom-sheet>
 </div>
</template>

<script>
import axios from "axios";
import { sync, get } from "vuex-pathify";

export default {
 name: "ComponentsEdit",

 components: {
  ComponentsEditSheetAppbar: () => import("./ComponentsEditSheetAppbar"),
  ComponentsEditSheetDrawer: () => import("./ComponentsEditSheetDrawer")
 },

 data: () => ({}),

 computed: {
  ...sync("componentManagement", ["componentEditSheet"])
  // ...get("componentManagement", ["selectedComponent"]),
 },

 mounted() {},

 methods: {}
};
</script>
