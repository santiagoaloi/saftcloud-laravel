<template>
 <baseDialog dense v-model="internalValue" title="Icons" saveOnly max-width="600" @save="() => (internalValue = false)">
  <template>
   <v-card-text>
    <v-row>
     <v-col cols="8">
      <v-autocomplete
       v-model="icon.name"
       :items="items"
       hide-no-data
       hide-selected
       hide-details
       solo
       item-text="name"
       item-value="name"
       label="Search mdi icons..."
       :color="isDark ? 'white' : ''"
       :background-color="isDark ? 'grey darken-4' : 'grey lighten-5'"
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
       append-icon="mdi-palette-outline"
       solo
       @click:append="colorPicker = !colorPicker"
       v-model="icon.color"
       hide-details
       :color="isDark ? 'white' : ''"
       :background-color="isDark ? 'grey darken-4' : 'grey lighten-5'"
      ></v-text-field>
     </v-col>
    </v-row>

    <base-dialog v-if="colorPicker" @save="() => (colorPicker = false)" noGutters noMaximize dense width="300" saveOnly v-model="colorPicker">
     <v-card class="mx-auto" width="300">
      <v-color-picker v-model="icon.color" flat></v-color-picker>
     </v-card>
    </base-dialog>
   </v-card-text>
  </template>
 </baseDialog>
</template>
<script>
import { store } from "@/store";
import axios from "axios";
import { sync, get } from "vuex-pathify";
export default {
 name: "DialogIcons",
 props: {
  value: {
   type: Boolean,
   default: false
  },
  icon: {
   type: Object,
   default: {}
  }
 },

 data() {
  return {
   internalValue: this.value,
   isLoading: false,
   colorPicker: false,
   iconColor: ""
  };
 },

 computed: {
  ...sync("theme", ["isDark", "icons"]),

  items() {
   return this.icons.map(icon => {
    const name = `mdi-${icon.name}`;
    return Object.assign({}, icon, { name });
   });
  }
 },

 watch: {
  internalValue(val, oldVal) {
   if (val === oldVal) return; // Don't do anything.
   this.$emit("input", val); // emit input change to v-model
  },

  value(val, oldVal) {
   if (val === oldVal) return;
   this.internalValue = val;
  }
 },

 mounted() {
  this.getIcons();
 },

 methods: {
  getIcons() {
   if (this.items.length > 0) return;
   axios
    .get("api/listIcons")
    .then(response => {
     store.set("theme/icons", response.data.icons);
    })
    .catch(err => {
     console.log(err);
    });
  }
 }
};
</script>