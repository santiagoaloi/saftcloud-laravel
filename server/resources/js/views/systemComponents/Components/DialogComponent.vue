<template>
 <baseDialog
  v-model="dialogComponent"
  title="Add new component"
  C
  persistent
  max-width="900"
  @save="validateComponentForm()"
  @close="() => (dialogComponent = false)"
 >
  <ValidationObserver ref="createComponentForm" slim>
   <v-row>
    <v-col cols="12" lg="6">
     <small>Group</small>
     <validation-provider v-slot="{ errors }" name="component group" rules="required">
      <v-autocomplete
       hide-details
       @update:search-input="syncGroupInputValue($event)"
       autofocus
       v-model="componentSettings.component_group_id"
       solo
       :items="allGroups"
       item-value="id"
       item-text="name"
       :color="$vuetify.theme.dark ? 'secondary' : ''"
       item-color="primary"
       prepend-inner-icon="mdi-comment"
       :menu-props="{
        transition: 'slide-y-transition'
       }"
      >
       <template v-slot:no-data>
        <v-list-item>
         <v-list-item-avatar>
          <v-icon>
           mdi-plus
          </v-icon>
         </v-list-item-avatar>

         <v-list-item-content>
          <v-list-item-title>
           <a @click="dialogGroup = !dialogGroup">Create group </a>
           {{ groupName }}
          </v-list-item-title>
         </v-list-item-content>
        </v-list-item>
       </template>

       <template #item="{ item, on }">
        <v-list-item :ripple="false" v-on="on">
         <v-list-item-avatar>
          <v-icon>mdi-folder-outline</v-icon>
         </v-list-item-avatar>
         <v-list-item-content>
          <v-list-item-title> {{ item.name }} </v-list-item-title>
         </v-list-item-content>
         <v-list-item-avatar>
          <v-btn :ripple="false" @click.stop="removeGroupWarning(item.id, item.name)" depressed fab x-small>
           <v-icon>mdi-delete-outline</v-icon>
          </v-btn>
         </v-list-item-avatar>
        </v-list-item>
       </template>
      </v-autocomplete>
     </validation-provider>
    </v-col>

    <v-col cols="12" lg="6">
     <small>Component title</small>
     <validation-provider v-slot="{ errors }" name="component title" rules="required">
      <v-text-field
       hide-details
       v-model="componentSettings.title"
       solo
       prepend-inner-icon="mdi-comment"
       counter
       maxlength="35"
       :error-messages="errors[0]"
       :color="$vuetify.theme.dark ? 'secondary' : ''"
      />
     </validation-provider>
    </v-col>

    <v-col cols="12" lg="6">
     <small>Component name</small>
     <validation-provider v-slot="{ errors }" name="component name" rules="required">
      <v-text-field
       hide-details
       v-model="componentSettings.name"
       solo
       prepend-inner-icon="mdi-comment"
       counter
       maxlength="35"
       :error-messages="errors[0]"
       :color="$vuetify.theme.dark ? 'secondary' : errors.length > 0 ? '#faebeb' : ''"
      />
     </validation-provider>
    </v-col>

    <v-col cols="12" lg="6">
     <small>Component description</small>
     <validation-provider v-slot="{ errors }" name="component desc" rules="required">
      <v-text-field
       hide-details
       v-model="componentSettings.note"
       solo
       prepend-inner-icon="mdi-file"
       counter
       maxlength="35"
       color="primary"
       label
       placeholder="Description"
       :error-messages="errors[0]"
       :color="$vuetify.theme.dark ? 'secondary' : ''"
      />
     </validation-provider>
    </v-col>
    <v-col cols="12" lg="6">
     <small>Database table</small>
     <validation-provider v-slot="{ errors }" name="component table" rules="required">
      <v-autocomplete
       hide-details
       v-model="componentSettings.table"
       :error-messages="errors[0]"
       :menu-props="{
        transition: 'slide-y-transition'
       }"
       clearable
       solo
       prepend-inner-icon="mdi-table"
       :items="dbTables"
       :color="$vuetify.theme.dark ? 'secondary' : ''"
       item-color="primary"
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

export default {
 name: "DialogComponent",

 mounted() {
  this.getDbTables();
 },

 computed: {
  ...sync("componentManagement", ["allGroups", "dialogComponent", "componentSettings", "dbTables", "dialogGroup", "groupName"])
 },

 methods: {
  ...call("componentManagement/*"),

  validateComponentForm() {
   this.$refs.createComponentForm.validate().then(success => {
    if (success) {
     this.createComponent();
    }
   });
  },

  removeGroupWarning(id, name) {
   this.$swal({
    title: `Delete ${name} group?`,
    text: "This action cannot be undone.",
    showCancelButton: true,
    confirmButtonText: "Delete",
    cancelButtonText: "Cancel",
    confirmButtonColor: "#EC407A",
    backdrop: "rgba(108, 122, 137, 0.8)"
   }).then(result => {
    if (result.value) {
     this.removeGroup(id);
    }
   });
  },

  syncGroupInputValue(e) {
   store.set("componentManagement/groupName", e);
  }
 }
};
</script>
