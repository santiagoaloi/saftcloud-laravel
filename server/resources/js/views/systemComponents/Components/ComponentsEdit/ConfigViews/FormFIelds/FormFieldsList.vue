<template>
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
  selectedFieldItem: 0,
  search: ""
 }),

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["componentEditSheet"]),
  ...get("componentManagement", ["selectedComponent"]),

  filteredFields: function() {
   const search = this.search.toString().toLowerCase();
   return this.selectedComponent.config.form_fields.filter(item => {
    return item.label.toLowerCase().match(search);
   });
  },

  filteredSelectedFields: function() {
   const search = this.search.toString().toLowerCase();
   return this.selectedComponent.config.form_fields.filter(item => {
    return item.label.toLowerCase().match(search) && item.displayField;
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
