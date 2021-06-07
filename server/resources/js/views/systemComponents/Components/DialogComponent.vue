<template>
 <baseDialog
  v-if="dialogComponent"
  v-model="dialogComponent"
  title="Add new component"
  persistent
  max-width="900"
  @save="createComponent()"
  @close="() => (dialogComponent = false)"
 >
  <ValidationObserver ref="createComponentForm" slim>
   <v-container class="mt-2" fluid>
    <v-row dense>
     <v-col cols="12" lg="6">
      <small>Group</small>
      <validation-provider v-slot="{ errors }" name="component group" rules="required">
       <v-autocomplete
        autofocus
        v-model="componentSettings.component_group_id"
        :background-color="errors.length > 0 ? '#faebeb' : 'white'"
        :error-messages="errors[0]"
        color="primary"
        label="Select group"
        solo
        :items="allGroups"
        item-value="id"
        item-text="name"
        item-color="primary"
        :menu-props="{
         transition: 'slide-y-transition',
         closeOnClick: false,
         closeOnContentClick: true
        }"
       >
       </v-autocomplete>
      </validation-provider>
     </v-col>

     <v-col cols="12" lg="6">
      <small>Component title</small>
      <validation-provider v-slot="{ errors }" name="component title" rules="required">
       <v-text-field
        ref="componentTitle"
        v-model="componentSettings.title"
        solo
        prepend-inner-icon="mdi-comment"
        counter
        maxlength="35"
        :background-color="errors.length > 0 ? '#faebeb' : 'white'"
        :error-messages="errors[0]"
        validateOnBlur
       />
      </validation-provider>
     </v-col>

     <v-col cols="12" lg="6">
      <small>Component name</small>
      <validation-provider v-slot="{ errors }" name="component title" rules="required">
       <v-text-field
        ref="componentTitle"
        v-model="componentSettings.name"
        solo
        prepend-inner-icon="mdi-comment"
        counter
        maxlength="35"
        :background-color="errors.length > 0 ? '#faebeb' : 'white'"
        :error-messages="errors[0]"
       />
      </validation-provider>
     </v-col>

     <v-col cols="12" lg="6">
      <small>Component description</small>
      <validation-provider v-slot="{ errors }" name="component desc" rules="required">
       <v-text-field
        v-model="componentSettings.note"
        solo
        prepend-inner-icon="mdi-file"
        counter
        maxlength="35"
        color="primary"
        label
        placeholder="Description"
        :background-color="errors.length > 0 ? '#faebeb' : 'white'"
        :error-messages="errors[0]"
       />
      </validation-provider>
     </v-col>
    </v-row>
    <v-col cols="12" lg="6">
     <small>Database table</small>
     <validation-provider v-slot="{ errors }" name="component table" rules="required">
      <v-autocomplete
       v-model="componentSettings.table"
       :background-color="errors.length > 0 ? '#faebeb' : 'white'"
       :error-messages="errors[0]"
       :menu-props="{
        transition: 'slide-y-transition',
        closeOnClick: false,
        closeOnContentClick: true
       }"
       clearable
       solo
       label=" "
       prepend-inner-icon="mdi-table"
       hint="Table in your DB."
       item-color="primary"
       color="primary"
       :items="dbTables"
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
   </v-container>
  </ValidationObserver>
 </baseDialog>
</template>
<script>
import { sync, call } from "vuex-pathify";
export default {
 name: "DialogComponent",

 mounted() {
  this.getDbTables();
 },

 computed: {
  ...sync("componentManagement", ["allGroups", "dialogComponent", "componentSettings", "dbTables"])
 },

 methods: {
  ...call("componentManagement/*")
 }
};
</script>
