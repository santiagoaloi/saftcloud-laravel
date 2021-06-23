<template>
 <div>
  <v-row>
   <v-col sm="4">
    <div class="mt-2">
     <small>Query</small>
     <v-textarea
      :background-color="isDark ? 'grey darken-4' : 'grey lighten-5'"
      :color="$vuetify.theme.dark ? 'secondary' : 'grey'"
      spellcheck="false"
      :rows="7"
      autogrow
      solo
      hide-details
      v-model="selectedComponent.config.sql_query"
     />
    </div>
   </v-col>
  </v-row>
 </div>
</template>

<script>
import axios from "axios";
import { sync, get } from "vuex-pathify";
export default {
 name: "ComponentsEditQuery",
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
