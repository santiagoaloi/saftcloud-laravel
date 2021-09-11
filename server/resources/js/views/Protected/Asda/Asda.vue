<template>
 <div>
  <div class="d-flex justify-end align-center">
   <div class="d-flex">
    <v-btn plain class="mx-2 "> <v-icon class="mr-2" small> mdi-arrow-top-right </v-icon>Export </v-btn>
    <v-btn class="ml-2" :color="isDark ? 'accent' : 'primary'"> <v-icon class="mr-2" small> mdi-plus </v-icon>Add records </v-btn>
   </div>
  </div>
  <v-divider class="mt-3"></v-divider>

  <v-data-table fixed-header :headers="columns" :items="records" style="cursor:pointer" calculate-widths> </v-data-table>
 </div>
</template>

<script>
import axios from "axios";
import { sync, call, get } from "vuex-pathify";

export default {
 name: "Asda",
 mounted() {
  this.callApi();
 },

 data() {
  return {
   records: [],
   recordItem: [],
   columns: []
  };
 },

 computed: {
  ...sync("theme", ["isDark"])
 },
 methods: {
  callApi() {
   let id = this.$route.meta.id;
   axios.get(`api/componentConstructor/${id}`).then(response => {
    if (response.status === 200) {
     this.records = response.data.component.records;
     this.recordItem = response.data.component.recordItem;
     this.columns = response.data.component.columns;
    }
   });
  }
 }
};
</script>
