<template>
 <div>
  <v-bottom-sheet no-click-animation persistent fullscreen v-model="componentEditSheet">
   <v-card tile height="100%">
    <template v-if="componentEditSheet">
     <components-edit-sheet-appbar />
     <v-row no-gutters class="text-start">
      <v-col :style="height" cols="auto">
       <components-edit-sheet-drawer />
      </v-col>
      <v-col>
       <v-card-text style="overflow:auto">
        <v-icon small>mdi-folder</v-icon> Products > {{ selectedComponent.config.general_config.name }}
        <v-divider class="mt-2"></v-divider>
        <v-scroll-y-transition hide-on-leave>
         <router-view />
        </v-scroll-y-transition>
       </v-card-text>
      </v-col>
     </v-row>
    </template>
   </v-card>
  </v-bottom-sheet>
 </div>
</template>

<script>
import axios from "axios";
import { sync, get } from "vuex-pathify";

export default {
 name: "ComponentsEdit",

 components: {
  ComponentsEditSheetAppbar: () => import(/* webpackChunkName: 'components-edit-sheet-appbar' */ "./ComponentsEditSheetAppbar"),
  ComponentsEditSheetDrawer: () => import(/* webpackChunkName: 'components-edit-sheet-drawer' */ "./ComponentsEditSheetDrawer")
 },

 data: () => ({}),

 computed: {
  ...sync("componentManagement", ["componentEditSheet"]),
  ...get("componentManagement", ["selectedComponent"]),

  height() {
   return `height:${this.$vuetify.breakpoint.height - this.$vuetify.application.top}px;overflow:auto`;
  }
 },

 mounted() {},

 methods: {}
};
</script>
