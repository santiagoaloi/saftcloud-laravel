<template>
 <div>
  <v-list class="pa-2 text-start" dark nav dense>
   <template v-for="(item, i) in menuItems">
    <div :key="i" v-if="item.header" class="pa-1 mt-2 overline">
     {{ item.header }}
    </div>
    <v-list-item v-else :key="i" @click="componentEditDrawerActiveMenu = item.link" :to="item.link" :disabled="item.disabled" link>
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
 name: "ComponentsEditSheetMenu",
 data: () => ({
  menuItems: [
   { header: "Component Settings" },
   { icon: "mdi-view-dashboard-outline", text: "Basic", link: "/components/basic" },
   { icon: "mdi-view-dashboard-outline", text: "Toolbar", link: "", disabled: true },
   { icon: "mdi-view-dashboard-outline", text: "Permissions", link: "", disabled: true },
   { header: "Database" },
   { icon: "mdi-view-dashboard-outline", text: "Query", link: "/components/query", disabled: false },
   { icon: "mdi-view-dashboard-outline", text: "Columns", link: "", disabled: true },
   { icon: "mdi-view-dashboard-outline", text: "Fields", link: "/components/formFields", disabled: false }
  ]
 }),

 computed: {
  ...sync("componentManagement", ["componentEditSheet", "componentEditDrawerActiveMenu"])
 },

 mounted() {
  if (!this.componentEditDrawerActiveMenu) {
   this.$router.push("/components/basic");
  } else {
   this.$router.push(this.componentEditDrawerActiveMenu);
  }
 },

 methods: {}
};
</script>
