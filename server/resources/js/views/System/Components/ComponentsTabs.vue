<template>
 <div class="d-flex justify-space-between align-center">
  <v-tabs color="accent" v-model="activeStatusTab" showArrows class="col-6 mt-n3" background-color="transparent" sliderSize="1">
   <v-tab :activeClass="isDark ? 'white--text' : ''" :disabled="isComponentsEmpty" :key="i" v-for="(tab, i) in componentStatusTabs" :ripple="false">
    <v-icon :color="tab.color" small left>
     {{ tab.icon }}
    </v-icon>
    {{ tab.name }}
   </v-tab>
  </v-tabs>

  <div class="d-flex">
   <!-- <v-switch v-model="multipleSelect" label="Multiple selection" class="mt-1 mx-4"> </v-switch> -->
   <v-btn plain :disabled="isAllFilteredComponentsEmpty" @click="isTableLayout = !isTableLayout"
    ><v-icon left> {{ isTableLayout ? " mdi-view-grid-outline" : " mdi-format-list-bulleted-square" }} </v-icon>
    {{ isTableLayout ? "Switch to grid view" : "Switch to list view" }}</v-btn
   >
  </div>
 </div>
</template>

<script>
import { store } from "@/store";
import globalMixin from "@/mixins/globalMixin";
import { sync, call, get } from "vuex-pathify";

export default {
 name: "ComponentsTabs",

 data() {
  return {};
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["activeStatusTab", "componentStatusTabs", "isTableLayout"]),
  ...get("componentManagement", ["isComponentsEmpty", "isAllFilteredComponentsEmpty"])
 }
};
</script>
