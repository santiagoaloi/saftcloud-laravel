<template>
 <div>
  <v-sheet class=" rightPanelHeight transparent">
   <v-tabs v-model="activeFormFieldTab" color="accent" showArrows class="col-12 mt-n3 px-0" background-color="transparent" sliderSize="1">
    <v-tab :activeClass="isDark ? 'white--text' : ''" :key="i" v-for="(tab, i) in formFieldTabs" :ripple="false">
     <v-icon :color="tab.color" small left>
      {{ tab.icon }}
     </v-icon>
     {{ tab.name }}
    </v-tab>
   </v-tabs>

   <!-- Active tab component -->
   <v-fade-transition>
    <component :is="activeTabComponentName" />
   </v-fade-transition>
  </v-sheet>
  <base-dialog-icons v-if="dialogIcon" :icon="fieldIcon" v-model="dialogIcon" />
 </div>
</template>

<script>
import { sync, get } from "vuex-pathify";
export default {
 name: "ComponentsEditViewsFormFieldsRightPanel",
 components: {
  Basic: () => import(/* webpackChunkName: 'form-fields-tabs-basic' */ "./Tabs/Basic")
 },
 data: () => ({
  dialogIcon: false,
  formFieldTabs: [
   { name: "Basic", value: "all", icon: "mdi-note-outline", color: "" },
   { name: "Slots", value: "starred", icon: "mdi-code-brackets", color: "" },
   { name: "Validation", value: "modular", icon: "mdi-check-bold", color: "" },
   { name: "Options", value: "active", icon: "mdi-apple-keyboard-option", color: "" },
   { name: "Evevnts", value: "active", icon: "mdi-cursor-default-click-outline", color: "" }
  ]
 }),

 computed: {
  ...sync("theme", ["isDark"]),
  ...get("componentManagement", ["selectedComponentFormField"]),
  ...sync("componentManagement", ["activeFormFieldTab"]),

  activeTabComponentName() {
   return this.formFieldTabs[this.activeFormFieldTab].name;
  },

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
