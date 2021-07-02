<template>
 <div>
  <v-row>
   <v-col sm="4">
    <div class="mt-2">
     <baseFieldLabel label="component name" />
     <v-text-field
      :outlined="isDark"
      :solo="!isDark"
      :color="isDark ? '#208ad6' : 'grey'"
      :background-color="isDark ? 'grey darken-4' : 'grey lighten-4'"
      spellcheck="false"
      hide-details
      v-model="selectedComponent.config.title"
     />
    </div>

    <div class="mt-2">
     <baseFieldLabel label="component description" />
     <v-textarea
      :outlined="isDark"
      :solo="!isDark"
      :color="isDark ? '#208ad6' : 'grey'"
      :background-color="isDark ? 'grey darken-4' : 'grey lighten-4'"
      spellcheck="false"
      :rows="2"
      autogrow
      hide-details
      v-model="selectedComponent.config.note"
     >
     </v-textarea>
    </div>
   </v-col>
  </v-row>
 </div>
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
