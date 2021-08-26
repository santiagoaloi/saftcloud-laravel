<template>
 <div class="d-flex justify-space-between align-center">
  <v-tabs color="accent" v-model="activeStatusTab" showArrows class="col-10 mt-n3" background-color="transparent" sliderSize="1">
   <v-tab :activeClass="isDark ? 'white--text' : ''" :disabled="isComponentsEmpty" :key="i" v-for="(tab, i) in componentStatusTabs" :ripple="false">
    <v-icon small left>
     {{ tab.icon }}
    </v-icon>
    {{ tab.name }}
   </v-tab>
  </v-tabs>

  <div class="d-flex">
   <!-- <v-switch v-model="multipleSelect" label="Multiple selection" class="mt-1 mx-4"> </v-switch> -->
   <v-btn class="mt-n3" plain :disabled="isAllFilteredComponentsEmpty" @click="isTableLayout = !isTableLayout"
    ><v-icon left> {{ isTableLayout ? " mdi-view-grid-outline" : " mdi-format-list-bulleted-square" }} </v-icon>
    {{ isTableLayout ? "Grid" : "List" }}</v-btn
   >
  </div>
 </div>
</template>

<script>
import globalMixin from "@/mixins/globalMixin";
import { sync, call, get } from "vuex-pathify";

export default {
 name: "AccountsTabs",
 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["activeStatusTab", "componentStatusTabs", "isTableLayout"]),
  ...get("componentManagement", ["isComponentsEmpty", "isAllFilteredComponentsEmpty"])
 }
};
</script>
