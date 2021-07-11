<template>
 <baseDialog
  v-model="dialogComponent"
  title="Add new component"
  persistent
  max-width="900"
  @save="validateComponentForm()"
  @close="dialogComponent = !dialogComponent"
 >
  <ValidationObserver ref="createComponentForm" slim>
   <v-row>
    <v-col cols="12" lg="6">
     <baseFieldLabel label="Group" />
     <validation-provider v-slot="{ errors }" name="component group" rules="required">
      <v-autocomplete
       spellcheck="false"
       prepend-inner-icon="mdi-folder-outline"
       @update:search-input="syncGroupInputValue($event)"
       v-model="componentSettings.component_group_id"
       :items="allGroups"
       :maxlength="25"
       item-value="id"
       item-text="name"
       placeholder="Select or create groups"
       hide-selected
       hide-no-data
       solo
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? '#28292b' : 'grey lighten-5'"
       :error="errors.length > 0"
       :item-color="isDark ? 'indigo lighten-3' : 'primary'"
       :menu-props="{
        transition: 'slide-y-transition',
        closeOnContentClick: true
       }"
       hide-details
       :outlined="isDark"
      >
       <template #item="{ item, on }">
        <v-list-item :ripple="false" v-on="on">
         <v-list-item-avatar>
          <v-icon>mdi-folder-outline</v-icon>
         </v-list-item-avatar>
         <v-list-item-content>
          <v-list-item-title> {{ item.name }} </v-list-item-title>
         </v-list-item-content>
        </v-list-item>
       </template>
      </v-autocomplete>
     </validation-provider>
    </v-col>

    <v-col cols="12" lg="6">
     <baseFieldLabel label="Component title" />
     <validation-provider v-slot="{ errors }" name="component title" rules="required">
      <v-text-field
       spellcheck="false"
       hide-details
       v-model="componentSettings.title"
       solo
       :outlined="isDark"
       prepend-inner-icon="mdi-comment"
       counter
       maxlength="35"
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? '#28292b' : 'grey lighten-5'"
       :error="errors.length > 0"
      />
     </validation-provider>
    </v-col>

    <v-col cols="12" lg="6">
     <baseFieldLabel label="Component name" />
     <validation-provider v-slot="{ errors }" name="component name" rules="required">
      <v-text-field
       spellcheck="false"
       hide-details
       v-model="componentSettings.name"
       solo
       prepend-inner-icon="mdi-comment"
       counter
       maxlength="35"
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? '#28292b' : 'grey lighten-5'"
       :error="errors.length > 0"
       :outlined="isDark"
      />
     </validation-provider>
    </v-col>

    <v-col cols="12" lg="6">
     <baseFieldLabel label="Component description" />
     <validation-provider v-slot="{ errors }" name="component desc" rules="required">
      <v-text-field
       spellcheck="false"
       hide-details
       v-model="componentSettings.note"
       prepend-inner-icon="mdi-file"
       counter
       maxlength="35"
       label
       placeholder="Description"
       solo
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? '#28292b' : 'grey lighten-5'"
       :error="errors.length > 0"
       :outlined="isDark"
      />
     </validation-provider>
    </v-col>
    <v-col cols="12" lg="6">
     <baseFieldLabel label="Database table" />
     <validation-provider v-slot="{ errors }" name="component table" rules="required">
      <v-autocomplete
       :outlined="isDark"
       spellcheck="false"
       hide-details
       v-model="componentSettings.table"
       :menu-props="{
        transition: 'slide-y-transition'
       }"
       solo
       prepend-inner-icon="mdi-table"
       :items="dbTables"
       :item-color="isDark ? 'indigo lighten-3' : 'primary'"
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? '#28292b' : 'grey lighten-5'"
       :error="errors.length > 0"
      >
       <template v-slot:item="data">
        <template>
         <v-list-item-avatar>
          <v-icon small> mdi-table </v-icon>
         </v-list-item-avatar>
         <v-list-item-content>
          <v-list-item-title v-html="data.item" />
         </v-list-item-content>
        </template>
       </template>
      </v-autocomplete>
     </validation-provider>
    </v-col>
   </v-row>
  </ValidationObserver>
 </baseDialog>
</template>
<script>
import { sync, call } from "vuex-pathify";
import { store } from "@/store";
import componentGroups from "@/mixins/componentGroups";

export default {
 name: "DialogComponent",
 mixins: [componentGroups],
 inheritAttrs: false,

 mounted() {
  this.getDbTables();
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["allGroups", "dialogComponent", "componentSettings", "dbTables", "groupName"])
 },

 methods: {
  ...call("componentManagement/*"),

  validateComponentForm() {
   this.$refs.createComponentForm.validate().then(success => {
    if (success) {
     this.createComponent();
    }
   });
  }
 }
};
</script>
