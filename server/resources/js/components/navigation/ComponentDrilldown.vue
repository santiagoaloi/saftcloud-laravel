<template>
 <div>
  <v-app-bar absolute dense class="px-2">
   <v-btn :disabled="previousComponentDisabled()" @click="previousComponent()" class="mr-2" fab text x-small>
    <v-icon>mdi-chevron-left</v-icon>
   </v-btn>
   <v-btn :disabled="nextComponentDisabled()" @click="nextComponent()" fab text x-small>
    <v-icon>mdi-chevron-right</v-icon>
   </v-btn>
   <v-spacer></v-spacer>

   <v-select solo hide-details flat dense :items="items" :menu-props="{ top: true, offsetY: true }" label="Choose component"></v-select>

   <v-btn @click="secureComponentDrawer = false" fab text x-small>
    <v-icon>mdi-close</v-icon>
   </v-btn>
  </v-app-bar>

  <v-list class="mt-13">
   <v-list-item>
    <v-list-item-avatar>
     <v-icon :color="selectedComponent.config_settings.icon.color">
      {{ selectedComponent.config_settings.icon.name }}
     </v-icon>
    </v-list-item-avatar>

    <v-list-item-content>
     <v-list-item-title>
      <v-text-field spellcheck="false" flat solo hide-details dense v-model="selectedComponent.config.title"> </v-text-field
     ></v-list-item-title>
    </v-list-item-content>

    <v-list-item-icon>
     <v-btn @click="setStarred(selectedComponent)" color="white" small @click.stop icon :ripple="false">
      <v-icon :color="isStarredColor(selectedComponent)"> {{ isStarredIcon(selectedComponent) }} </v-icon></v-btn
     >
    </v-list-item-icon>
   </v-list-item>
  </v-list>

  <v-card flat class="mx-auto pa-1 mt-n3" max-width="344">
   <v-card-text>
    <div class="text--primary">
     <v-textarea spellcheck="false" noResize :rows="2" flat solo autogrow hide-details dense v-model="selectedComponent.config.note"> </v-textarea>
    </div>
   </v-card-text>
  </v-card>

  <template>
   <div class="text-center mb-3">
    <v-tooltip transition="false" color="black" bottom>
     <template v-slot:activator="{ on, attrs }">
      <v-btn v-on="on" depressed dark large small color="white">
       <v-icon color="orange" dark>
        mdi-pencil-outline
       </v-icon>
      </v-btn>
     </template>
     <span>Edit</span>
    </v-tooltip>

    <v-tooltip transition="false" color="black" bottom>
     <template v-slot:activator="{ on, attrs }">
      <v-btn v-on="on" depressed dark large small color="white">
       <v-icon color="black" dark>
        mdi-link
       </v-icon>
      </v-btn>
     </template>
     <span>Open</span>
    </v-tooltip>

    <v-tooltip transition="false" color="black" bottom>
     <template v-slot:activator="{ on, attrs }">
      <v-btn v-on="on" @click="removeComponentWarning(selectedComponent.id, selectedComponent.config.title)" depressed dark large small color="white">
       <v-icon color="pink lighten-1" dark>
        mdi-trash-can-outline
       </v-icon>
      </v-btn>
     </template>
     <span>Delete</span>
    </v-tooltip>

    <v-tooltip transition="false" color="black" bottom>
     <template v-slot:activator="{ on, attrs }">
      <v-btn :disabled="!isModified()" v-on="on" depressed large small color="white">
       <v-icon color="green" dark>
        mdi-check-all
       </v-icon>
      </v-btn>
     </template>
     <span>Save</span>
    </v-tooltip>
   </div>
  </template>

  <template>
   <v-card flat class="mx-auto">
    <v-list subheader two-line>
     <v-subheader>Database</v-subheader>

     <v-list-item>
      <v-list-item-icon>
       <v-icon color="indigo">
        mdi-table
       </v-icon>
      </v-list-item-icon>

      <v-list-item-content>
       <v-list-item-title> {{ selectedComponent.config.sql_table }}</v-list-item-title>
       <v-list-item-subtitle>Table</v-list-item-subtitle>
      </v-list-item-content>
     </v-list-item>

     <v-list-item>
      <v-list-item-icon>
       <v-icon color="indigo">
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
       <v-icon color="indigo">
        mdi-calendar-plus
       </v-icon>
      </v-list-item-icon>

      <v-list-item-content>
       <v-list-item-title>Created</v-list-item-title>
       <v-list-item-subtitle> {{ selectedComponent.created_at }} </v-list-item-subtitle>
       <v-list-item-subtitle>12 days ago</v-list-item-subtitle>
      </v-list-item-content>
     </v-list-item>

     <v-list-item>
      <v-list-item-icon>
       <v-icon color="indigo">
        mdi-calendar-edit
       </v-icon>
      </v-list-item-icon>

      <v-list-item-content>
       <v-list-item-title>Edited</v-list-item-title>
       <v-list-item-subtitle> {{ selectedComponent.updated_at }} </v-list-item-subtitle>
       <v-list-item-subtitle>8 days ago</v-list-item-subtitle>
      </v-list-item-content>
     </v-list-item>

     <v-divider></v-divider>

     <v-container>
      <small>Component group </small>
      <v-autocomplete
       v-model="selectedComponent.component_group_id"
       solo
       :items="allGroups"
       :maxlength="25"
       item-value="id"
       item-text="name"
       hide-no-data
      >
      </v-autocomplete>
     </v-container>
    </v-list>
   </v-card>
  </template>
 </div>
</template>

<script>
import { sync, call } from "vuex-pathify";
import { store } from "@/store";
import isEqual from "lodash/isEqual";

export default {
 data: () => ({
  items: ["Foo", "Bar", "Fizz", "Buzz"]
 }),
 computed: {
  ...sync("drawers", ["secureComponentDrawer"]),
  ...sync("componentManagement", ["componentCardGroup", "allComponents", "allGroups", "selectedComponent", "unsavedChanges"])
 },

 methods: {
  isModified() {
   if (this.selectedComponent != []) {
    const { origin, ...props } = this.selectedComponent;
    const { component_group_id, group, config, config_settings } = props;
    const { component_group_id: originGroup, config: originConfig, config_settings: originConfigSettings } = origin;

    this.unsavedChanges = !isEqual(origin, props);
    return this.unsavedChanges;
   }
  },

  setStarred(component) {
   component.config_settings.status.starred = !component.config_settings.status.starred;
  },

  isStarredColor(component) {
   if (component.config_settings.status.starred) {
    return "orange darken-2";
   } else {
    return "black";
   }
  },

  isStarredIcon(component) {
   if (component.config_settings.status.starred) {
    return "mdi-star";
   } else {
    return "mdi-star-outline";
   }
  },

  removeComponentWarning(id, title) {
   this.$swal({
    title: `Delete ${title}?`,
    text: "This action cannot be undone.",
    showCancelButton: true,
    confirmButtonText: "Delete",
    cancelButtonText: "Cancel",
    confirmButtonColor: "#EC407A",
    backdrop: "rgba(108, 122, 137, 0.8)"
   }).then(result => {
    if (result.value) {
     this.removeComponent(id);
    }
   });
  },

  removeComponent(id) {
   axios.delete(`api/Component/${id}`).then(response => {
    if (response.data.status) {
     this.allComponents = response.data.components;
     store.set("snackbar/value", true);
     store.set("snackbar/text", "Component removed");
     store.set("snackbar/color", "pink darken-1");
    }
   });
  },

  previousComponent() {
   if (this.componentCardGroup > 0) {
    this.componentCardGroup--;
   }
  },

  previousComponentDisabled() {
   if (this.componentCardGroup === 0) {
    return true;
   }
  },

  nextComponent() {
   if (this.componentCardGroup < this.allComponents.length - 1) {
    this.componentCardGroup++;
   }
  },

  nextComponentDisabled() {
   if (this.componentCardGroup === this.allComponents.length - 1) {
    return true;
   }
  }
 }
};
</script>
