<template>
 <div>
  <v-hover v-slot="{ hover }">
   <v-avatar class="mt-4 cursor-pointer" size="110" @click="dialogIcons = true" rounded :color="selectedComponent.config_settings.icon.color">
    <v-expand-transition>
     <div v-if="hover" class="d-flex black v-card--reveal white--text" style="height: 100%;">
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

  <v-row>
   <v-col sm="4">
    <div class="mt-2">
     <baseFieldLabel label="component name" />
     <v-text-field
      :outlined="isDark"
      :solo="!isDark"
      :color="isDark ? '#208ad6' : 'grey'"
      :background-color="isDark ? '#28292b' : 'white'"
      spellcheck="false"
      hide-details
      v-model="selectedComponent.config.general_config.title"
     />
    </div>

    <div class="mt-2">
     <baseFieldLabel label="component description" />
     <v-textarea
      :outlined="isDark"
      :solo="!isDark"
      :color="isDark ? '#208ad6' : 'grey'"
      :background-color="isDark ? '#28292b' : 'white'"
      spellcheck="false"
      :rows="2"
      autogrow
      hide-details
      v-model="selectedComponent.config.general_config.note"
     >
     </v-textarea>
    </div>

    <v-divider class="my-5"></v-divider>
    <div class="mt-2">
     <baseFieldLabel class="mb-n3" label="Navigation drawer settings" />
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
  ...sync("componentManagement", ["componentEditSheet"]),
  ...get("componentManagement", ["selectedComponent"]),
  componentIcon() {
   if (!this.selectedComponent) return;
   return this.selectedComponent.config_settings.icon;
  }
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
