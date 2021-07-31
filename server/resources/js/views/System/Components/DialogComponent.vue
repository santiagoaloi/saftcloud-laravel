<template>
 <baseDialog
  v-model="dialogComponent"
  title="Add new component"
  persistent
  max-width="900"
  @save="validateComponentForm()"
  @close="dialogComponent = !dialogComponent"
  icon="mdi-plus"
 >
  <ValidationObserver ref="createComponentForm" slim>
   <v-row>
    <v-col cols="12" lg="6">
     <BaseFieldLabel required label="Group" />
     <validation-provider v-slot="{ errors, reset }" name="component group" rules="required">
      <v-autocomplete
       spellcheck="false"
       prepend-inner-icon="mdi-folder-outline"
       @update:search-input="syncGroupInputValue($event)"
       v-model="componentSettings.component_group_id"
       :items="allGroups"
       :maxlength="25"
       item-value="id"
       item-text="name"
       hide-selected
       hide-no-data
       solo
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? '#28292b' : 'white'"
       :error-messages="errors[0]"
       :error="errors.length > 0"
       :menu-props="{
        transition: 'slide-y-transition',
        closeOnContentClick: true
       }"
       :outlined="isDark"
       @focus="reset"
       @input="reset"
       @blur="reset"
       @keydown.enter.prevent="validateComponentForm()"
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
     <BaseFieldLabel required label="Component title" />
     <validation-provider v-slot="{ errors, reset }" name="component title" rules="required">
      <v-text-field
       spellcheck="false"
       v-model="componentSettings.title"
       solo
       :outlined="isDark"
       prepend-inner-icon="mdi-comment"
       counter
       maxlength="35"
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? '#28292b' : 'white'"
       @keydown.enter.prevent="validateComponentForm()"
       :error="errors.length > 0"
       :error-messages="errors[0]"
       @focus="reset"
       @input="reset"
       @blur="reset"
      />
     </validation-provider>
    </v-col>

    <v-col cols="12" lg="6">
     <BaseFieldLabel required label="Component name" />
     <validation-provider v-slot="{ errors, reset }" name="component name" rules="alpha|required">
      <v-text-field
       spellcheck="false"
       v-model="componentSettings.name"
       solo
       prepend-inner-icon="mdi-comment"
       counter
       maxlength="35"
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? '#28292b' : 'white'"
       :error="errors.length > 0"
       :outlined="isDark"
       @keydown.enter.prevent="validateComponentForm()"
       :error-messages="errors[0]"
       @focus="reset"
       @input="reset"
       @blur="reset"
      />
     </validation-provider>
    </v-col>

    <v-col cols="12" lg="6">
     <BaseFieldLabel required label="Database table" />
     <validation-provider v-slot="{ errors, reset }" name="component table" rules="required">
      <v-autocomplete
       :outlined="isDark"
       spellcheck="false"
       v-model="componentSettings.table"
       :menu-props="{
        transition: 'slide-y-transition'
       }"
       solo
       prepend-inner-icon="mdi-table"
       :items="dbTables"
       :item-color="isDark ? 'indigo lighten-3' : 'primary'"
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? '#28292b' : 'white'"
       @keydown.enter.prevent="validateComponentForm()"
       :error-messages="errors[0]"
       :error="errors.length > 0"
       @focus="reset"
       @input="reset"
       @blur="reset"
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
    <v-col cols="12" lg="12">
     <BaseFieldLabel label="Component description" />
     <v-textarea
      spellcheck="false"
      v-model="componentSettings.note"
      prepend-inner-icon="mdi-file"
      label
      solo
      :rows="4"
      :color="isDark ? '#208ad6' : 'grey'"
      :background-color="isDark ? '#28292b' : 'white'"
      :outlined="isDark"
     />
    </v-col>
   </v-row>
  </ValidationObserver>
 </baseDialog>
</template>
<script>
import { sync, call } from "vuex-pathify";
import componentGroups from "@/mixins/componentGroups";
export default {
 name: "DialogComponent",
 mixins: [componentGroups],

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
   this.$refs.createComponentForm.validate().then(validated => {
    if (validated) {
     this.createComponent().then(created => {
      if (created) {
       window.eventBus.$emit("BUS_BUILD_ROUTES");
       this.resetDialogComponentForm();
      }
     });
    }
   });
  }
 }
};
</script>
