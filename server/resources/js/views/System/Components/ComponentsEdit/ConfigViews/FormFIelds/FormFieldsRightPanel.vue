<template>
 <div>
  <v-sheet class=" rightPanelHeight transparent">
   <v-tabs color="accent" showArrows class="col-12 mt-n3 px-0" background-color="transparent" sliderSize="1">
    <v-tab :activeClass="isDark ? 'white--text' : ''" :key="i" v-for="(tab, i) in fieldsOptionsTabs" :ripple="false">
     <v-icon :color="tab.color" small left>
      {{ tab.icon }}
     </v-icon>
     {{ tab.name }}
    </v-tab>
   </v-tabs>

   <v-row>
    <v-col cols="6">
     <baseFieldLabel label="label" />
     <!-- <v-icon style="margin-top:-2px" :color="selectedComponentFormField.icon.color" class="ml-2" small>mdi-palette-outline</v-icon> -->
     <v-text-field
      :outlined="isDark"
      :solo="!isDark"
      :color="isDark ? '#208ad6' : 'grey'"
      :background-color="isDark ? '#28292b' : 'grey lighten-4'"
      v-model="selectedComponentFormField.label"
      :prepend-inner-icon="selectedComponentFormField.icon.name"
      @click:prepend-inner="dialogIcon = true"
     >
     </v-text-field>
    </v-col>
    <v-col cols="6">
     <baseFieldLabel label="Input type" />
     <v-select
      :outlined="isDark"
      :solo="!isDark"
      v-model="selectedComponentFormField.inputType"
      :item-color="isDark ? 'indigo lighten-3' : 'primary'"
      :color="isDark ? '#208ad6' : 'grey'"
      :background-color="isDark ? '#28292b' : 'grey lighten-4'"
      :menu-props="{ transition: 'slide-y-transition' }"
      :items="inputTypes"
      hide-details
     />
    </v-col>
   </v-row>
  </v-sheet>
  <base-dialog-icons v-if="dialogIcon" :icon="fieldIcon" v-model="dialogIcon" />
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
   { name: "Basic", value: "all", icon: "mdi-note-outline", color: "" },
   { name: "Slots", value: "starred", icon: "mdi-code-brackets", color: "" },
   { name: "Validation", value: "modular", icon: "mdi-check-bold", color: "" },
   { name: "Options", value: "active", icon: "mdi-apple-keyboard-option", color: "" },
   { name: "Evevnts", value: "active", icon: "mdi-cursor-default-click-outline", color: "" }
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
::v-deep .border {
 border-left: 1px solid grey !important;
}
.rightPanelHeight {
 height: calc(100vh - 165px);
 overflow-y: auto;
 overflow-x: hidden;
}
</style>
