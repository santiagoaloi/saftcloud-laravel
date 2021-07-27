<template>
 <div>
  <v-text-field
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
   :color="isDark ? '#208ad6' : 'grey'"
   :background-color="isDark ? '#28292b' : 'white'"
   :outlined="isDark"
  />
  <v-list-item-group v-model="selectedFieldItemGroup" mandatory>
   <v-list class="fieldListHeight ">
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
       v-for="(item, i) in displayEnabledFormFieldsOnly ? filteredSelectedFields : filteredFormFields"
       :key="i"
       two-line
       :ripple="false"
       @click="setActiveField(item.field)"
       :active-class="isDark ? 'accent' : 'accent lighten-4'"
      >
       <v-list-item-action v-if="!displayEnabledFormFieldsOnly">
        <v-switch :ripple="false" v-model="item.displayField" color="accent lighten-1" />
       </v-list-item-action>

       <v-list-item-content>
        <v-list-item-title> {{ item.label }}</v-list-item-title>

        <v-list-item-subtitle class="mt-2">
         {{ item.field }}
        </v-list-item-subtitle>
       </v-list-item-content>

       <v-list-item-action>
        <v-chip dark label small color="accent lighten-1">{{ item.fieldType }}</v-chip>
       </v-list-item-action>

       <v-icon v-if="!displayEnabledFormFieldsOnly" class="drag my-handle">
        mdi-drag-vertical
       </v-icon>
      </v-list-item>
     </transition-group>
    </draggable>
   </v-list>
  </v-list-item-group>
 </div>
</template>

<script>
import axios from "axios";
import draggable from "vuedraggable";
import { sync, get, call } from "vuex-pathify";
export default {
 name: "ComponentsEditViewsFormFieldsList",
 components: {
  draggable
 },
 data: () => ({}),

 methods: {
  ...call("componentManagement/*")
 },

 mounted() {
  this.setActiveField(this.filteredFormFields[0].field);
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", [
   "searchFields",
   "displayEnabledFormFieldsOnly",
   "selectedComponentActiveField",
   "selectedFieldItemGroup",
   "showSelectedFieldsOnly"
  ]),
  ...get("componentManagement", ["selectedComponent", "filteredFormFields", "filteredSelectedFields"])
 }
};
</script>
<style scoped>
.fieldListHeight {
 height: calc(100vh - 230px);
 overflow-y: auto;
}
</style>
