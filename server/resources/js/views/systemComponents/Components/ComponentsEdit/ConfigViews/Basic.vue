<template>
 <v-sheet height="200" color="transparent">
  <v-row>
   <v-col sm="4">
    <div class="mt-2">
     <small>Component name</small>
     <v-text-field
      color="primary"
      :background-color="isDark ? 'grey darken-4' : 'grey lighten-5'"
      spellcheck="false"
      solo
      hide-details
      v-model="selectedComponent.config.title"
     />
    </div>

    <div class="mt-2">
     <small>Description</small>
     <v-textarea
      :background-color="isDark ? 'grey darken-4' : 'grey lighten-5'"
      :color="$vuetify.theme.dark ? 'secondary' : 'grey'"
      spellcheck="false"
      :rows="2"
      autogrow
      solo
      hide-details
      v-model="selectedComponent.config.note"
     >
     </v-textarea>
    </div>
   </v-col>
  </v-row>
 </v-sheet>
</template>

<script>
import axios from "axios";
import { sync, get } from "vuex-pathify";
export default {
 name: "ComponentsEditViewsBasic",
 components: {},
 data: () => ({}),

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["componentEditSheet"]),
  ...get("componentManagement", ["selectedComponent"])
 },

 mounted() {},

 methods: {}
};
</script>
