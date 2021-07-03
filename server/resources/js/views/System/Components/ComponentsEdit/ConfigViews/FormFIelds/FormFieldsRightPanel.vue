<template>
 <div>
  <v-sheet class="rightPanelHeight transparent">
   <v-tabs color="accent" v-model="activeStatusTab" showArrows class="col-12 mt-n3 px-0" background-color="transparent" sliderSize="1">
    <v-tab :activeClass="isDark ? 'white--text' : ''" :key="i" v-for="(tab, i) in fieldsOptionsTabs" :ripple="false">
     <v-icon :color="tab.color" small left>
      {{ tab.icon }}
     </v-icon>
     {{ tab.name }}
    </v-tab>
   </v-tabs>

   <v-row>
    <v-col cols="6">
     <small class="ml-1">LABEL</small>
     <v-icon style="margin-top:-2px" :color="selectedComponentFormField.icon.color" class="ml-2" small>mdi-palette-outline</v-icon>
     <v-text-field
      :outlined="isDark"
      :solo="!isDark"
      :color="isDark ? '#208ad6' : 'grey'"
      :background-color="isDark ? 'grey darken-4' : 'grey lighten-4'"
      v-model="selectedComponentFormField.label"
      :append-icon="selectedComponentFormField.icon.name"
      @click:append="dialogIcon = true"
     >
     </v-text-field>
    </v-col>
    <v-col cols="6">
     <small class="ml-1">INPUT TYPE</small>
     <v-select
      :outlined="isDark"
      :solo="!isDark"
      v-model="selectedComponentFormField.inputType"
      :item-color="isDark ? 'indigo lighten-3' : 'primary'"
      :color="isDark ? '#208ad6' : 'grey'"
      :background-color="isDark ? 'grey darken-4' : 'grey lighten-4'"
      :menu-props="{ transition: 'slide-y-transition' }"
      :items="inputTypes"
      hide-details
     />
    </v-col>
   </v-row>
  </v-sheet>
  <base-dialog-icons :icon="fieldIcon" v-model="dialogIcon" />
 </div>
</template>

<script>
import axios from "axios";

import { sync, get } from "vuex-pathify";
export default {
 name: "ComponentsEditViewsBasic",

 data: () => ({
  dialogIcon: false,
  fieldsOptionsTabs: [
   { name: "Basic", value: "all", icon: "mdi-all-inclusive", color: "" },
   { name: "Slots", value: "starred", icon: "mdi-star", color: "" },
   { name: "Validation", value: "modular", icon: "mdi-view-module", color: "" },
   { name: "Options", value: "active", icon: "mdi-lightbulb-on", color: "" },
   { name: "Evevnts", value: "active", icon: "mdi-lightbulb-on", color: "" }
  ],

  inputTypes: [
   { value: "text", text: "Text" },
   { value: "number", text: "Number" },
   { value: "password", text: "Password" },
   { value: "range", text: "Range" },
   { value: "color", text: "Color" },
   { value: "email", text: "Email" },
   { value: "phone", text: "Phone" }
  ]
 }),

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["dialogs"]),
  ...get("componentManagement", ["selectedComponentFormField"]),

  fieldIcon() {
   if (!this.selectedComponentFormField) return;
   return this.selectedComponentFormField.icon;
  }
 }
};
</script>
<style scoped>
.rightPanelHeight {
 height: calc(100vh - 165px);
 overflow-y: auto;
}
</style>
