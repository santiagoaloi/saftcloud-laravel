<template>
 <baseDialog
  v-model="dialogs.dialogComponent"
  title="Add new component"
  C
  persistent
  max-width="900"
  @save="validateComponentForm()"
  @close="() => (dialogs.dialogComponent = false)"
 >
  <ValidationObserver ref="createComponentForm" slim>
   <v-row>
    <v-col cols="12" lg="6">
     <small>Group</small>
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
       outlined
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? 'grey darken-4' : 'grey lighten-5'"
       :error="errors.length > 0"
       :item-color="isDark ? 'indigo lighten-3' : 'primary'"
       :menu-props="{
        transition: 'slide-y-transition',
        closeOnContentClick: true
       }"
       hide-details
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
     <small>Component title</small>
     <validation-provider v-slot="{ errors }" name="component title" rules="required">
      <v-text-field
       spellcheck="false"
       hide-details
       v-model="componentSettings.title"
       outlined
       prepend-inner-icon="mdi-comment"
       counter
       maxlength="35"
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? 'grey darken-4' : 'grey lighten-5'"
       :error="errors.length > 0"
      />
     </validation-provider>
    </v-col>

    <v-col cols="12" lg="6">
     <small>Component name</small>
     <validation-provider v-slot="{ errors }" name="component name" rules="required">
      <v-text-field
       spellcheck="false"
       hide-details
       v-model="componentSettings.name"
       outlined
       prepend-inner-icon="mdi-comment"
       counter
       maxlength="35"
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? 'grey darken-4' : 'grey lighten-5'"
       :error="errors.length > 0"
      />
     </validation-provider>
    </v-col>

    <v-col cols="12" lg="6">
     <small>Component description</small>
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
       outlined
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? 'grey darken-4' : 'grey lighten-5'"
       :error="errors.length > 0"
      />
     </validation-provider>
    </v-col>
    <v-col cols="12" lg="6">
     <small>Database table</small>
     <validation-provider v-slot="{ errors }" name="component table" rules="required">
      <v-autocomplete
       spellcheck="false"
       hide-details
       v-model="componentSettings.table"
       :menu-props="{
        transition: 'slide-y-transition'
       }"
       outlined
       prepend-inner-icon="mdi-table"
       :items="dbTables"
       :item-color="isDark ? 'indigo lighten-3' : 'primary'"
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? 'grey darken-4' : 'grey lighten-5'"
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

 mounted() {
  this.getDbTables();
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["allGroups", "dialogs", "componentSettings", "dbTables", "groupName"])
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
