<template>
 <div>
  <v-hover v-slot="{ hover }">
   <v-avatar class="mt-4 cursor-pointer" size="110" @click="dialogIcons = true" rounded :color="selectedComponent.config_settings.icon.color">
    <v-expand-transition>
     <div v-if="hover" class="d-flex black v-card--reveal white--text height-full">
      <v-icon size="50" dark>
       mdi-pencil
      </v-icon>
     </div>
    </v-expand-transition>
    <v-fade-transition hide-on-leave>
     <v-icon v-if="!hover" size="50" dark>
      {{ selectedComponent.config_settings.icon.name }}
     </v-icon>
    </v-fade-transition>
   </v-avatar>
  </v-hover>

  <ValidationObserver ref="componentsEditBasic" slim>
   <v-row>
    <v-col sm="4">
     <div class="mt-2">
      <BaseFieldLabel required label="component name" />
      <validation-provider v-slot="{ errors, reset }" name="component name" rules="required">
       <v-text-field
        :outlined="isDark"
        :solo="!isDark"
        :color="isDark ? '#208ad6' : 'grey'"
        :background-color="isDark ? '#28292b' : 'white'"
        spellcheck="false"
        v-model="selectedComponent.config.general_config.title"
        :error-messages="errors[0]"
        :error="errors.length > 0"
        @focus="reset"
        @input="reset"
        @blur="reset"
       />
      </validation-provider>
     </div>

     <div class="mt-2">
      <BaseFieldLabel label="component description" />
      <v-textarea
       :outlined="isDark"
       :solo="!isDark"
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? '#28292b' : 'white'"
       spellcheck="false"
       :rows="2"
       auto-grow
       hide-details
       v-model="selectedComponent.config.general_config.note"
      >
      </v-textarea>
     </div>

     <div class="mt-2">
      <BaseFieldLabel required label="Component group " />
      <v-autocomplete
       solo
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? '#28292b' : 'white'"
       v-model="selectedComponent.component_group_id"
       hide-selected
       :items="allGroups"
       :maxlength="25"
       item-value="id"
       item-text="name"
       hide-no-data
      >
      </v-autocomplete>
     </div>

     <v-divider class="my-5"></v-divider>
     <div class="mt-2">
      <BaseFieldLabel class="mb-n3" label="Navigation drawer settings" />
      <v-list-item two-line>
       <v-list-item-icon>
        <v-switch hide-details class="mt-2" v-model="selectedComponent.config.general_config.isVisibleInSidebar" />
       </v-list-item-icon>
       <v-list-item-content>
        <v-list-item-title>Visible in sidebar</v-list-item-title>
        <v-list-item-subtitle>
         Display this component in the left navigation drawer.
        </v-list-item-subtitle>
       </v-list-item-content>
      </v-list-item>
     </div>
    </v-col>
   </v-row>
  </ValidationObserver>

  <!-- trigger component icons dialog -->
  <base-dialog-icons v-if="dialogIcons" :icon="componentIcon" v-model="dialogIcons" />
 </div>
</template>

<script>
import axios from "axios";
import { sync, get } from "vuex-pathify";
export default {
 name: "ComponentsEditViewsBasic",
 components: {},
 data() {
  return {
   dialogIcons: false
  };
 },
 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["componentEditSheet", "allGroups"]),
  ...get("componentManagement", ["selectedComponent"]),
  ...sync("refs", ["componentsEditBasic"]),

  componentIcon() {
   if (!this.selectedComponent) return;
   return this.selectedComponent.config_settings.icon;
  }
 },

 mounted() {
  // Sync refs with Vuex for cross-validation
  this.componentsEditBasic = this.$refs.componentsEditBasic;
 }
};
</script>

<style scoped>
.v-card--reveal {
 align-items: center;
 bottom: 0;
 justify-content: center;
 opacity: 0.5;
 position: absolute;
 width: 100%;
}
</style>
