<template>
 <div>
  <v-toolbar color="transparent" flat dense>
   <v-toolbar-title class="mr-5">{{ availableFields }} fields</v-toolbar-title>

   <!-- <v-spacer></v-spacer> -->

   <v-menu transition="fade-transition" offset-y nudge-top="-11">
    <template v-slot:activator="{ on, attrs }">
     <v-btn small depressed color="primary" dark v-bind="attrs" v-on="on"> <v-icon left class="mr-2" small> mdi-tune</v-icon> Options </v-btn>
    </template>

    <v-list>
     <v-list-item dense @click="selectAll()">
      <v-list-item-action>
       <v-icon>mdi-expand-all-outline</v-icon>
      </v-list-item-action>
      <v-list-item-content>
       <v-list-item-title> Select All</v-list-item-title>
      </v-list-item-content>
     </v-list-item>

     <v-list-item dense @click="unselectAll()">
      <v-list-item-action>
       <v-icon>mdi-collapse-all-outline</v-icon>
      </v-list-item-action>
      <v-list-item-content>
       <v-list-item-title> Unselect All</v-list-item-title>
      </v-list-item-content>
     </v-list-item>

     <v-divider />

     <v-list-item dense>
      <v-list-item-action>
       <v-icon>mdi-selection-search</v-icon>
      </v-list-item-action>
      <v-list-item-content>
       <v-list-item-title>Show enabled ones only </v-list-item-title>
      </v-list-item-content>
      <v-list-item-action>
       <v-switch v-model="showSelectedOnly" color="primary accent-3" :ripple="false" @click.stop />
      </v-list-item-action>
     </v-list-item>
    </v-list>
   </v-menu>
  </v-toolbar>

  <div>
   <v-divider></v-divider>

   <v-row class="mt-1">
    <v-col cols="auto">
     <v-responsive width="500">
      <v-text-field
       :color="isDark ? 'white' : ''"
       v-model="search"
       hide-details
       label="Search fields..."
       prepend-inner-icon="mdi-magnify"
       autocomplete="off"
       autocorrect="off"
       autocapitalize="off"
       spellcheck="false"
       solo
       class="mb-2"
      />
      <v-list-item-group v-model="selectedFieldItem" mandatory active-class="blue-grey lighten-4">
       <v-list class="fieldListHeight" color="transparent">
        <draggable
         v-model="selectedComponent.config.form_fields"
         :delay="100"
         :delay-on-touch-only="true"
         :options="{ animation: 500 }"
         ghost-class="ghost"
         handle=".my-handle"
        >
         <transition-group appear name="slide-y-transition">
          <v-list-item
           dense
           :active-class="isDark ? 'indigo' : ''"
           v-for="(item, i) in showSelectedOnly ? filteredSelectedFields : filteredFields"
           :key="i"
           two-line
           :ripple="false"
          >
           <v-list-item-action @click.stop>
            <v-switch :ripple="false" v-model="item.displayField" :color="isDark ? 'indigo lighten-4' : 'primary accent-4'" />
           </v-list-item-action>

           <v-list-item-content>
            <v-list-item-title>{{ item.label }}</v-list-item-title>

            <v-list-item-subtitle class="mt-2">
             Label
            </v-list-item-subtitle>
            <v-list-item-subtitle class="mt-2">
             {{ item.field }}
            </v-list-item-subtitle>
           </v-list-item-content>

           <v-list-item-action>
            <v-chip dark label x-small color="blue-grey lighten-2">{{ item.fieldType }}</v-chip>
           </v-list-item-action>

           <v-icon v-if="!showSelectedOnly" class="drag my-handle">
            mdi-drag-vertical
           </v-icon>
          </v-list-item>
         </transition-group>
        </draggable>
       </v-list>
      </v-list-item-group>
     </v-responsive>
    </v-col>
    <v-col> <v-sheet class="rightPanelHeight transparent"> </v-sheet> </v-col>
   </v-row>
  </div>
 </div>
</template>

<script>
import axios from "axios";
import draggable from "vuedraggable";

import { sync, get } from "vuex-pathify";
export default {
 name: "ComponentsEditViewsBasic",
 components: {
  draggable
 },
 data: () => ({
  showSelectedOnly: false,
  search: "",
  selectedFieldItem: 0
 }),

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["componentEditSheet"]),
  ...get("componentManagement", ["selectedComponent"]),

  availableFields() {
   return this.selectedComponent.config.form_fields.length;
  },

  filteredFields: function() {
   const search = this.search.toString().toLowerCase();
   return this.selectedComponent.config.form_fields.filter(item => {
    return item.field.toLowerCase().match(search);
   });
  },

  filteredSelectedFields: function() {
   const search = this.search.toString().toLowerCase();
   return this.selectedComponent.config.form_fields.filter(item => {
    return item.field.toLowerCase().match(search) && item.displayField;
   });
  }
 },

 mounted() {},

 methods: {
  unselectAll() {
   this.selectedComponent.config.form_fields.forEach(field => {
    field.displayField = false;
   });
  },

  selectAll() {
   this.selectedComponent.config.form_fields.forEach(field => {
    field.displayField = true;
   });
  }
 }
};
</script>
<style scoped>
.fieldListHeight {
 height: calc(100vh - 230px);
 overflow-y: auto;
}
.rightPanelHeight {
 height: calc(100vh - 165px);
 overflow-y: auto;
}
.drag {
 cursor: grab;
}

.drag:active {
 cursor: grabbing;
 transform: scale(0.99); /* Equal to scaleX(0.7) scaleY(0.7) */
}
</style>
