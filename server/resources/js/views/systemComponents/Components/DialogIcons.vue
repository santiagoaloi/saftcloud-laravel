<template>
 <baseDialog v-model="dialogIcons" title="Icons" saveOnly persistent max-width="600" @save="() => (dialogIcons = false)">
  <template v-if="selectedComponent">
   <v-card-text>
    <v-row>
     <v-col cols="8">
      <v-autocomplete
       v-model="selectedComponent.config_settings.icon.name"
       :items="items"
       :loading="isLoading"
       hide-no-data
       hide-selected
       solo
       item-text="name"
       item-value="name"
       label="Search mdi icons..."
       :color="$vuetify.theme.dark ? 'secondary' : ''"
      >
       <template slot="selection" slot-scope="data">
        <v-icon class="mr-3"> {{ data.item.name }} </v-icon>
        <span class="mr-2">{{ data.item.name }} </span>
       </template>

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
     </v-col>
     <v-col>
      <v-text-field
       readonly
       :color="$vuetify.theme.dark ? 'secondary' : ''"
       append-icon="mdi-home"
       solo
       @click="colorPicker = !colorPicker"
       v-model="selectedComponent.config_settings.icon.color"
      ></v-text-field>
     </v-col>
    </v-row>

    <base-dialog v-if="colorPicker" @save="() => (colorPicker = false)" noGutters noMaximize dense width="300" saveOnly v-model="colorPicker">
     <v-card class="mx-auto" width="300">
      <v-color-picker v-model="selectedComponent.config_settings.icon.color" flat></v-color-picker>
     </v-card>
    </base-dialog>
   </v-card-text>
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
  search: null,
  colorPicker: false,
  iconColor: ""
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

 mounted() {
  this.getIcons();
 },

 methods: {
  getIcons() {
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
