<template>
 <v-data-table
  fixed-header
  checkbox-color="primary"
  item-key="id"
  show-select
  :height="calculateHeight()"
  :headers="headers"
  :items="allComponentsFiltered"
 >
  <template v-slot:[`item.avatar`]>
   <v-avatar class="cursor-pointer" size="30" rounded color="indigo">
    <v-icon size="25" dark>
     mdi-apps
    </v-icon>
   </v-avatar>
  </template>

  <template v-slot:[`item.actions`]>
   <v-tooltip transition="false" color="black" bottom>
    <template v-slot:activator="{ on }">
     <v-btn v-on="on" @click.stop="setStarred(component)" color="white" small icon :ripple="false">
      <v-icon :color="isStarredColor(component)"> {{ isStarredIcon(component) }} </v-icon>
     </v-btn>
    </template>
    <span>Favourite</span>
   </v-tooltip>

   <v-menu rounded="xl" origin="center center" transition="scale-transition" :nudge-bottom="10" offset-y>
    <template v-slot:activator="{ on }">
     <v-btn icon v-on="on">
      <v-icon>mdi-dots-vertical</v-icon>
     </v-btn>
    </template>

    <v-list class="pa-2" rounded="xl" outlined>
     <v-list-item @click.stop>
      <v-list-item-action>
       <v-icon color="grey darken-2" small class="mx-2">
        mdi-pencil-outline
       </v-icon>
      </v-list-item-action>
      <v-list-item-title>Editar</v-list-item-title>
     </v-list-item>

     <v-list-item @click.stop>
      <v-list-item-action>
       <v-icon color="red lighten-2" small class="mx-2">
        mdi-delete-outline
       </v-icon>
      </v-list-item-action>

      <v-list-item-title>Eliminar</v-list-item-title>
     </v-list-item>
    </v-list>
   </v-menu>
  </template>
 </v-data-table>
</template>

<script>
import { sync, call, get } from "vuex-pathify";
import componentActions from "@/mixins/componentActions";
export default {
 name: "ComponentsTableView",
 mixins: [componentActions],
 data() {
  return {
   headers: [
    {
     text: "Avatar",
     align: "start",
     sortable: false,
     value: "avatar",
     width: 0
    },
    {
     text: "Component",
     align: "start",
     sortable: true,
     value: "name"
    },

    {
     text: "Actions",
     align: "end",
     sortable: false,
     value: "actions"
    }
   ]
  };
  allComponentsFiltered;
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["tableHeaders"]),
  ...get("componentManagement", ["allComponentsFiltered"])
 },

 methods: {
  ...call("componentManagement/*"),
  calculateHeight() {
   return Number(this.$vuetify.breakpoint.height - 378);
  }
 }
};
</script>
