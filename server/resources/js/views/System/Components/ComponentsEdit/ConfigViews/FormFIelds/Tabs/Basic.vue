<template>
 <div>
  <v-row>
   <v-col cols="6">
    <BaseFieldLabel required label="label" />
    <v-text-field
     :outlined="isDark"
     :solo="!isDark"
     :color="isDark ? '#208ad6' : 'grey'"
     :background-color="isDark ? '#28292b' : 'white'"
     v-model="selectedComponentFormField.label"
     :prepend-inner-icon="selectedComponentFormField.icon.name"
     @click:prepend-inner="dialogIcons = true"
    >
    </v-text-field>
   </v-col>
   <v-col cols="6">
    <BaseFieldLabel required label="Input type" />
    <v-select
     :outlined="isDark"
     :solo="!isDark"
     v-model="selectedComponentFormField.inputType"
     :item-color="isDark ? 'indigo lighten-3' : 'primary'"
     :color="isDark ? '#208ad6' : 'grey'"
     :background-color="isDark ? '#28292b' : 'white'"
     :menu-props="{ transition: 'slide-y-transition' }"
     :items="inputTypes"
     hide-details
    />
   </v-col>
  </v-row>
  <base-dialog-icons v-if="dialogIcons" :icon="componentIcon" v-model="dialogIcons" />
 </div>
</template>

<script>
import axios from "axios";
import { sync, get } from "vuex-pathify";
export default {
 name: "ComponentsEditViewsFormFieldsTabsBasic",
 data() {
  return {
   dialogIcons: false,
   inputTypes: [
    { value: "text", text: "Text" },
    { value: "number", text: "Number" },
    { value: "password", text: "Password" },
    { value: "range", text: "Range" },
    { value: "color", text: "Color" },
    { value: "email", text: "Email" },
    { value: "phone", text: "Phone" }
   ]
  };
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...get("componentManagement", ["selectedComponentFormField"]),

  componentIcon() {
   if (!this.selectedComponentFormField) return;
   return this.selectedComponentFormField.icon;
  }
 }
};
</script>
