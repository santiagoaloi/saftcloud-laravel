<template>
 <div>
  <v-data-table
   fixed-header
   checkbox-color="primary"
   item-key="id"
   :height="calculateHeight()"
   :headers="headers"
   :items="allComponentsFiltered"
   v-model="selectedComponentTableRow"
   @click:row="rowClicked"
   style="cursor:pointer"
   calculate-widths
  >
   <template v-slot:[`item.avatar`]="{ item }">
    <v-hover v-slot="{ hover }">
     <v-avatar
      @click="setComponentTableIcon(item), (dialogIcons = true)"
      class="cursor-pointer "
      size="35"
      rounded
      :color="item.config_settings.icon.color"
     >
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
   </template>

   <template v-slot:[`item.name`]="{ item }">
    <router-link :class="{ 'grey--text': isDark }" :to="`/${item.name}`">{{ item.name }}</router-link>
   </template>

   <template v-slot:[`item.group`]="{ item }">
    <v-icon style="margin-top:-2px;" class="mr-1" small> mdi-folder-outline</v-icon>
    <template v-if="mapComponentGroup(item).component_group_id"> {{ mapGroupParent(item) }} <v-icon small>mdi-menu-right</v-icon> </template>
    {{ mapComponentGroup(item).name }}
   </template>

   <template v-slot:[`item.config.general_config.title`]="{ item }">
    {{ item.config.general_config.title || ". . ." }}
   </template>

   <template v-slot:[`item.status`]="{ item }">
    <v-tooltip v-if="hasUnsavedChanges(item)" transition="false" color="black" bottom>
     <template v-slot:activator="{ on }">
      <v-btn v-on="on" color="white" small icon :ripple="false">
       <v-icon :color="isDark ? 'white' : '#28292b'">mdi-alert-outline </v-icon>
      </v-btn>
     </template>
     <span>Unsaved</span>
    </v-tooltip>

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
   </template>
  </v-data-table>
  <base-dialog-icons :icon="componentIcon" v-if="dialogIcons" v-model="dialogIcons" />
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
     value: "config.general_config.title"
    },

    {
     text: "Route",
     align: "end",
     value: "name",
     divider: true
    },

    {
     text: "Group",
     align: "end",
     value: "group",
     divider: true
    },

    {
     text: "Status",
     align: "end",
     sortable: false,
     value: "status",
     width: 160
    }
   ],
   dialogIcons: false,
   componentIcon: ""
  };
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["selectedComponentTableRow", "componentCardGroup"]),
  ...get("componentManagement", [
   "allComponentsFiltered",
   "isStarredColor",
   "isStarredIcon",
   "isModularColor",
   "isModularIcon",
   "isActiveColor",
   "isActiveIcon",
   "mapComponentGroup",
   "mapGroupParent",
   "hasUnsavedChanges"
  ])
 },

 watch: {
  componentCardGroup: {
   immediate: true,
   handler(newValue, oldValue) {
    if (newValue != oldValue) {
     this.selectedComponentTableRow = [this.allComponentsFiltered[this.componentCardGroup]];
    }
   }
  }
 },

 methods: {
  ...call("componentManagement/*"),

  setComponentTableIcon(item) {
   this.componentIcon = item.config_settings.icon;
  },

  rowClicked(row) {
   this.toggleSelection(row.id, row);
   let index = this.allComponentsFiltered.findIndex(component => component.id === row.id);
   this.componentCardGroup = index;
   this.setSelectedComponent(index);
   console.log(index);
  },

  toggleSelection(id, row) {
   this.selectedComponentTableRow = [row];
  },

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
