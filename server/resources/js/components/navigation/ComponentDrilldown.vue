<template>
 <div v-if="selectedComponent">
  <v-expand-transition>
   <v-sheet :color="isDark ? '#2C2F33' : 'white'" v-if="hasUnsavedChanges(selectedComponent)" class="px-2">
    <v-alert class="mt-3" elevation="2" coloredBorder color="pink" border="right" dense>
     <div class="d-flex justify-space-between align-center">
      Unsaved
      <v-btn small @click="rollbackChanges(selectedComponent)">rollback</v-btn>
     </div>
    </v-alert>
   </v-sheet>
  </v-expand-transition>

  <v-list>
   <v-list-item class="pa-1">
    <v-list-item-avatar>
     <v-icon :color="isDark ? '#ccc' : 'black'">
      {{ selectedComponent.config_settings.icon.name }}
     </v-icon>
    </v-list-item-avatar>

    <v-list-item-content>
     <v-list-item-title>
      <v-text-field
       backgroundColor="transparent"
       spellcheck="false"
       flat
       solo
       hide-details
       dense
       v-model="selectedComponent.config.general_config.title"
      >
      </v-text-field
     ></v-list-item-title>
    </v-list-item-content>

    <v-list-item-icon class="mr-1">
     <v-tooltip transition="false" color="black" bottom>
      <template v-slot:activator="{ on }">
       <v-btn v-on="on" @click="setStarred(selectedComponent)" color="white" small icon :ripple="false">
        <v-icon :color="isStarredColor(selectedComponent)"> {{ isStarredIcon(selectedComponent) }} </v-icon></v-btn
       >
      </template>
      <span>Favourite</span>
     </v-tooltip>
    </v-list-item-icon>
   </v-list-item>
  </v-list>

  <v-card-text class="pa-2">
   <div class="text--primary">
    <baseFieldLabel label="Description" />
    <v-textarea
     outlined
     :color="isDark ? '#208ad6' : 'grey'"
     :background-color="isDark ? '#28292b' : 'white'"
     spellcheck="false"
     :rows="2"
     autogrow
     dense
     v-model="selectedComponent.config.general_config.note"
     hide-details
    >
    </v-textarea>

    <div class="mt-2">
     <baseFieldLabel label="Change component group " />
     <small></small>
     <v-autocomplete
      outlined
      :color="isDark ? '#208ad6' : 'grey'"
      :background-color="isDark ? '#28292b' : 'white'"
      v-model="selectedComponent.component_group_id"
      hide-selected
      dense
      :items="allGroups"
      :maxlength="25"
      item-value="id"
      item-text="name"
      hide-no-data
     >
     </v-autocomplete>
    </div>
   </div>
  </v-card-text>

  <div class="text-center mb-3">
   <v-tooltip transition="false" color="black" bottom>
    <template v-slot:activator="{ on }">
     <v-btn @click="componentEditSheet = !componentEditSheet" v-on="on" depressed dark large small :color="isDark ? '' : 'white'">
      <v-icon color="#208ad6" dark>
       mdi-pencil-outline
      </v-icon>
     </v-btn>
    </template>
    <span>Edit</span>
   </v-tooltip>

   <v-tooltip transition="false" color="black" bottom>
    <template v-slot:activator="{ on }">
     <v-btn :to="`/${selectedComponent.name}`" v-on="on" depressed dark large small :color="isDark ? '' : 'white'">
      <v-icon :color="isDark ? '' : 'black'" dark>
       mdi-link
      </v-icon>
     </v-btn>
    </template>
    <span>Open</span>
   </v-tooltip>

   <v-tooltip transition="false" color="black" bottom>
    <template v-slot:activator="{ on }">
     <v-btn
      v-on="on"
      @click.stop="removeComponentWarning(selectedComponent.id, 'delete', 'component', selectedComponent.config.general_config.title)"
      depressed
      dark
      large
      small
      :color="isDark ? '' : 'white'"
     >
      <v-icon color="pink lighten-1" dark>
       mdi-trash-can-outline
      </v-icon>
     </v-btn>
    </template>
    <span>Delete</span>
   </v-tooltip>

   <v-tooltip transition="false" color="black" bottom>
    <template v-slot:activator="{ on }">
     <v-btn
      :disabled="!hasUnsavedChanges(selectedComponent)"
      @click="saveComponent(selectedComponent)"
      v-on="on"
      depressed
      large
      small
      :color="isDark ? '' : 'white'"
     >
      <v-icon color="green" dark>
       {{ hasUnsavedChanges(selectedComponent) ? "mdi-check" : "mdi-check-all" }}
      </v-icon>
     </v-btn>
    </template>
    <span>Save</span>
   </v-tooltip>
  </div>

  <div class="mt-2">
   <v-list-item two-line>
    <v-list-item-icon>
     <v-switch :ripple="false" hide-details class="mt-2" v-model="selectedComponent.config.general_config.isVisibleInSidebar" />
    </v-list-item-icon>
    <v-list-item-content>
     <v-list-item-title>Sidebar</v-list-item-title>
     <v-list-item-subtitle>
      Display in navigation
     </v-list-item-subtitle>
    </v-list-item-content>
   </v-list-item>
  </div>

  <v-list subheader two-line>
   <v-subheader>Database</v-subheader>
   <v-list-item>
    <v-list-item-icon>
     <v-icon>
      mdi-table
     </v-icon>
    </v-list-item-icon>

    <v-list-item-content>
     <v-list-item-title> {{ selectedComponent.config.general_config.sql_table }}</v-list-item-title>
     <v-list-item-subtitle>Table</v-list-item-subtitle>
    </v-list-item-content>
   </v-list-item>

   <v-list-item>
    <v-list-item-icon>
     <v-icon>
      mdi-table-row
     </v-icon>
    </v-list-item-icon>
    <v-list-item-content>
     <v-list-item-title>{{ selectedComponent.config.columns.length }}</v-list-item-title>
     <v-list-item-subtitle> Table columns</v-list-item-subtitle>
    </v-list-item-content>
   </v-list-item>

   <v-divider></v-divider>

   <v-list-item>
    <v-list-item-icon>
     <v-icon>
      mdi-calendar-plus
     </v-icon>
    </v-list-item-icon>

    <v-list-item-content>
     <v-list-item-title>Created</v-list-item-title>
     <v-list-item-subtitle> {{ selectedComponent.created_at | momentDate }} </v-list-item-subtitle>
     <v-list-item-subtitle> {{ selectedComponent.created_at | momentDateAgo }}</v-list-item-subtitle>
    </v-list-item-content>
   </v-list-item>

   <v-list-item>
    <v-list-item-icon>
     <v-icon>
      mdi-calendar-edit
     </v-icon>
    </v-list-item-icon>

    <v-list-item-content>
     <v-list-item-title>Edited</v-list-item-title>
     <v-list-item-subtitle> {{ selectedComponent.updated_at | momentDate }} </v-list-item-subtitle>
     <v-list-item-subtitle>{{ selectedComponent.updated_at | momentDateAgo }} </v-list-item-subtitle>
    </v-list-item-content>
   </v-list-item>

   <v-divider></v-divider>
  </v-list>
 </div>
</template>

<script>
import { sync, call, get } from "vuex-pathify";
import { store } from "@/store";
import isEqual from "lodash/isEqual";
import componentActions from "@/mixins/componentActions";

export default {
 name: "ComponentDrilldown",
 mixins: [componentActions],
 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("drawers", ["secureComponentDrawer"]),
  ...sync("componentManagement", ["componentCardGroup", "allComponents", "allGroups", "selectedComponentIndex", "componentEditSheet"]),
  ...get("componentManagement", [
   "hasUnsavedChanges",
   "hasSelectedComponent",
   "previousComponentDisabled",
   "nextComponentDisabled",
   "selectedComponent",
   "isAllFilteredComponentsEmpty",
   "isStarredColor",
   "isStarredIcon"
  ])
 },

 watch: {
  isAllFilteredComponentsEmpty(val) {
   if (val) {
    this.secureComponentDrawer = false;
    this.componentCardGroup = undefined;
   }
  },

  componentCardGroup(val) {
   if (val === undefined) {
    setTimeout(() => {
     this.secureComponentDrawer = false;
     this.componentCardGroup = undefined;
    }, 0);
   }
  }
 },

 methods: {
  ...call("componentManagement/*"),

  setStarred(component) {
   component.status.starred = !component.status.starred;
   component.origin.status.starred = !component.origin.status.starred;
   this.setComponentStatus(component);
  }
 }
};
</script>
