<template>
 <div>
  <v-data-table
   fixed-header
   checkbox-color="primary"
   item-key="id"
   show-select
   :height="calculateHeight()"
   :headers="headers"
   :items="allComponentsFiltered"
  >
   <template v-slot:[`item.avatar`]="{ item }">
    <v-hover v-slot="{ hover }">
     <v-avatar @click="dialogIcons = true" class="cursor-pointer " size="35" rounded :color="item.config_settings.icon.color">
      <v-expand-transition>
       <div v-if="hover" class="d-flex black v-card--reveal white--text" style="height: 100%;">
        <v-icon size="20" dark>
         mdi-pencil
        </v-icon>
       </div>
      </v-expand-transition>
      <v-fade-transition hide-on-leave>
       <v-icon v-if="!hover" size="20" dark>
        {{ item.config_settings.icon.name }}
       </v-icon>
      </v-fade-transition>
     </v-avatar>
    </v-hover>
    <base-dialog-icons :icon="item.config_settings.icon" v-if="dialogIcons" v-model="dialogIcons" />
   </template>

   <template v-slot:[`item.group`]="{ item }">
    <v-icon style="margin-top:-2px;" class="mr-1" small> mdi-folder-outline</v-icon>
    <template v-if="mapComponentGroup(item).component_group_id"> {{ mapGroupParent(item) }} <v-icon small>mdi-menu-right</v-icon> </template>
    {{ mapComponentGroup(item).name }}
   </template>

   <template v-slot:[`item.actions`]="{ item }">
    <v-tooltip transition="false" color="black" bottom>
     <template v-slot:activator="{ on }">
      <v-btn v-on="on" @click.stop="setStarred(item)" color="white" small icon :ripple="false">
       <v-icon :color="isStarredColor(item)"> {{ isStarredIcon(item) }} </v-icon>
      </v-btn>
     </template>
     <span>Favourite</span>
    </v-tooltip>

    <v-tooltip transition="false" color="black" bottom>
     <template v-slot:activator="{ on }">
      <v-btn v-on="on" @click.stop="setModular(item)" color="white" small icon :ripple="false">
       <v-icon :color="isModularColor(item)"> {{ isModularIcon(item) }} </v-icon>
      </v-btn>
     </template>
     <span>Modular</span>
    </v-tooltip>

    <v-tooltip transition="false" color="black" bottom>
     <template v-slot:activator="{ on }">
      <v-btn v-on="on" @click.stop="setActive(item)" color="white" small icon :ripple="false">
       <v-icon :color="isActiveColor(item)"> {{ isActiveIcon(item) }} </v-icon>
      </v-btn>
     </template>
     <span>Active</span>
    </v-tooltip>

    <v-menu origin="center center" transition="scale-transition" :nudge-bottom="10" offset-y>
     <template v-slot:activator="{ on }">
      <v-btn icon v-on="on">
       <v-icon>mdi-dots-vertical</v-icon>
      </v-btn>
     </template>

     <v-list class="pa-2" outlined>
      <v-list-item @click.stop>
       <v-list-item-action>
        <v-icon color="grey darken-2" small class="mx-2">
         mdi-pencil-outline
        </v-icon>
       </v-list-item-action>
       <v-list-item-title>Edit</v-list-item-title>
      </v-list-item>

      <v-list-item @click.stop>
       <v-list-item-action>
        <v-icon color="red lighten-2" small class="mx-2">
         mdi-delete-outline
        </v-icon>
       </v-list-item-action>

       <v-list-item-title>Remove</v-list-item-title>
      </v-list-item>
     </v-list>
    </v-menu>
   </template>
  </v-data-table>
 </div>
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
     text: "Group",
     align: "end",
     sortable: false,
     value: "group"
    },

    {
     text: "Actions",
     align: "end",
     sortable: false,
     value: "actions",
     width: 210
    }
   ],
   dialogIcons: false
  };
  allComponentsFiltered;
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["tableHeaders"]),
  ...get("componentManagement", [
   "allComponentsFiltered",
   "isStarredColor",
   "isStarredIcon",
   "isModularColor",
   "isModularIcon",
   "isActiveColor",
   "isActiveIcon",
   "mapComponentGroup",
   "mapGroupParent"
  ])
 },

 methods: {
  ...call("componentManagement/*"),
  calculateHeight() {
   return Number(this.$vuetify.breakpoint.height - 378);
  }
 }
};
</script>

<style scoped>
.v-card--reveal {
 align-items: center;
 bottom: 0;
 justify-content: center;
 opacity: 0.5;
 position: absolute;
 width: 100%;
}
</style>
