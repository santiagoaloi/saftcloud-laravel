<template>
 <div>
  <v-list class="pa-2 text-start" dark nav dense>
   <template v-for="(item, i) in menuItems">
    <div :key="i" v-if="item.header" class="pa-1 mt-2 overline">
     {{ item.header }}
    </div>
    <v-list-item
     active-class="primary--text text--lighten-5"
     v-else
     :key="i"
     @click="componentEditDrawerActiveMenu = item.link"
     :to="item.link"
     :disabled="item.disabled || hasValidationErrors"
    >
     <v-list-item-icon>
      <v-icon small :class="{ 'grey--text': item.disabled }">
       {{ item.icon || "mdi-circle-medium" }}
      </v-icon>
     </v-list-item-icon>
     <v-list-item-content>
      <v-list-item-title v-html="item.text"></v-list-item-title>
      <v-list-item-subtitle v-html="item.group"></v-list-item-subtitle>
     </v-list-item-content>
    </v-list-item>
   </template>
  </v-list>
 </div>
</template>

<script>
import { sync, get } from "vuex-pathify";
export default {
 name: "BaseViewDrawerMenu",
 data: () => ({
  menuItems: [{ header: "Visual Settings" }, { icon: "mdi-view-dashboard-outline", text: "Table Columns", link: "/components/basic" }]
 }),

 computed: {
  ...sync("componentManagement", ["componentEditSheet", "componentEditDrawerActiveMenu"])
 }
};
</script>
