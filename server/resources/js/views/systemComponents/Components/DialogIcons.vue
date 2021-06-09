<template>
 <baseDialog v-model="dialogIcons" title="Icons" persistent max-width="900" @close="() => (dialogIcons = false)">
  <template>
   <v-card color="red lighten-2" dark>
    <v-card-title class="text-h5 red lighten-3">
     Search for Public APIs
    </v-card-title>
    <v-card-text>
     Explore hundreds of free API's ready for consumption! For more information visit
     <a class="grey--text text--lighten-3" href="https://github.com/toddmotto/public-apis" target="_blank">the GitHub repository</a>.
    </v-card-text>
    <v-card-text>
     <v-autocomplete
      v-model="selectedComponent.config_settings.icon.name"
      :items="items"
      :loading="isLoading"
      :search-input.sync="search"
      color="white"
      hide-no-data
      hide-selected
      item-text="name"
      item-value="name"
      label="Mdi Icons"
      placeholder="Start typing to Search"
      prepend-icon="mdi-database-search"
     >
      <template #item="{ item, on }">
       <v-list-item :ripple="false" v-on="on">
        <v-list-item-avatar>
         <v-icon>{{ item.name }}</v-icon>
        </v-list-item-avatar>
        <v-list-item-content>
         <v-list-item-title> {{ item.name }} </v-list-item-title>
        </v-list-item-content>
       </v-list-item>
      </template>
     </v-autocomplete>
    </v-card-text>
   </v-card>
  </template>
 </baseDialog>
</template>
<script>
import axios from "axios";
import { sync, get } from "vuex-pathify";
export default {
 name: "DialogIcons",

 data: () => ({
  descriptionLimit: 60,
  icons: [],
  isLoading: false,
  model: null,
  search: null
 }),

 computed: {
  ...sync("componentManagement", ["dialogIcons"]),
  ...get("componentManagement", ["selectedComponent"]),

  items() {
   return this.icons.map(icon => {
    const name = `mdi-${icon.name}`;
    return Object.assign({}, icon, { name });
   });
  }
 },

 watch: {
  search(val) {
   // Items have already been loaded
   if (this.items.length > 0) return;

   // Items have already been requested
   if (this.isLoading) return;

   this.isLoading = true;

   // Lazily load input items
   axios
    .get("api/listIcons")
    .then(response => {
     this.icons = response.data.icons;
    })
    .catch(err => {
     console.log(err);
    })
    .finally(() => (this.isLoading = false));
  }
 }
};
</script>
