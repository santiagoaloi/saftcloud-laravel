<template>
 <v-responsive width="500">
  <v-text-field
   :color="isDark ? 'white' : ''"
   v-model="searchFields"
   hide-details
   label="Buscar"
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
       v-for="(item, i) in displayEnabledFormFieldsOnly ? filteredSelectedFields : filteredFormFields"
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

       <v-icon v-if="!displayEnabledFormFieldsOnly" class="drag my-handle">
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

import { sync, get, call } from "vuex-pathify";
export default {
 name: "ComponentsEditViewsFormFieldsRightPanel",
 components: {
  draggable
 },
 data: () => ({
  showSelectedOnly: false,
  selectedFieldItem: 0
 }),

 methods: {
  ...call("componentManagement/*")
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["searchFields", "displayEnabledFormFieldsOnly"]),
  ...get("componentManagement", ["selectedComponent", "filteredFormFields", "filteredSelectedFields"])
 }
};
</script>
<style scoped>
.fieldListHeight {
 height: calc(100vh - 230px);
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
