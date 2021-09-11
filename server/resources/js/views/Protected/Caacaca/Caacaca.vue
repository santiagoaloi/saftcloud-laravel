<template>
 <div v-if="isBooted">
  <div class="d-flex justify-end align-center">
   <div class="d-flex">
    <v-btn plain class="mx-2 "> <v-icon class="mr-2" small> mdi-arrow-top-right </v-icon>Export </v-btn>
    <v-btn @click="dialog = true" class="ml-2" :color="isDark ? 'accent' : 'primary'">
     <v-icon class="mr-2" small> mdi-plus </v-icon>Add records
    </v-btn>
   </div>
  </div>
  <v-divider class="mt-3"></v-divider>

  <v-data-table fixed-header :headers="columns" :items="records" style="cursor:pointer" calculate-widths> </v-data-table>

  <base-dialog width="50vw" @save="addRecord()" @close="dialog = false" title="add record" v-model="dialog">
   <v-form @submit.prevent="addRecord()">
    <v-row>
     <v-col sm="6" v-for="(field, i) in formFields" :key="i">
      <baseFieldLabel required :label="field.label" />
      <v-text-field
       :outlined="isDark"
       :solo="!isDark"
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? '#28292b' : 'white'"
       spellcheck="false"
       v-model="recordItem[field.field]"
      />
     </v-col>
    </v-row>
    <v-btn v-show="false" type="submit" />
   </v-form>
  </base-dialog>
 </div>
</template>

<script>
import axios from "axios";
import { sync, call } from "vuex-pathify";

export default {
 name: "cacacaca",

 mounted() {
  this.loadView(this.$route.meta.id);
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("activeView/*")
 },

 methods: {
  ...call("activeView/*"),

  addRecord() {
   this.records.push(this.recordItem);
   this.recordItem = this.recordItemInitial;
   this.dialog = false;

   axios.post(`api/componentConstructor/`, this.recordItem).then(response => {
    if (response.status === 200) {
     this.records = response.data.component.records;
     this.recordItem = response.data.component.recordItem;
     this.columns = response.data.component.columns;
     this.formFields = response.data.component.formFields;
     this.formFieldsInitial = response.data.component.formFields;
    }
   });
  }
 }
};
</script>
