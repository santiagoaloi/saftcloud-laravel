<template>
 <div v-if="isBooted">
  <div class="d-flex justify-end align-center">
   <div class="d-flex">
    <v-btn plain class="mr-2"> <v-icon class="mr-2" small> mdi-arrow-top-right </v-icon>Export </v-btn>
    <v-btn @click="dialogCustomize = true" plain class="mr-2"> <v-icon class="mr-2" small> mdi-arrow-top-right </v-icon>Customize </v-btn>
    <!-- <v-select :menu-props="{ 'offset-y': true }" v-model="visibleColumns" item-color="primary lighten-4" solo multiple :items="columns"></v-select> -->
    <v-btn @click="dialogCrud = true" :color="isDark ? 'accent' : 'primary'"> <v-icon small> mdi-plus </v-icon>Add records </v-btn>
   </div>
  </div>
  <v-divider class="mt-3"></v-divider>

  <v-data-table :search="search" fixed-header :headers="tableColumns" :items="records" style="cursor:pointer" calculate-widths> </v-data-table>

  <base-dialog width="50vw" @save="addRecord()" @close="dialogCrud = false" title="add record" v-model="dialogCrud">
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

  <base-dialog width="50vw" @save="dialogCustomize = false" @close="dialogCustomize = false" title="Customize view" v-model="dialogCustomize">
  </base-dialog>
 </div>
</template>

<script>
import activeView from "@/mixins/activeView";
export default {
 name: "Xxc",
 mixins: [activeView],

 computed: {
  tableColumns() {
   return this.columns.filter(column => {
    return this.visibleColumns.includes(column.value);
   });
  }
 }
};
</script>
