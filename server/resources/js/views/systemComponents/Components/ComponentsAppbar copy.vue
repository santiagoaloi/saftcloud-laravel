<template>
 <div>
  <div class="d-flex justify-space-between align-center">
   <h3 class="hidden-sm-and-down ">Manage components</h3>
   <div class="d-flex">
    <v-text-field
     v-model.lazy="search"
     spellcheck="false"
     :color="$vuetify.theme.dark ? 'secondary' : ''"
     solo
     dense
     hide-details
     placeholder="Search components..."
     prepend-inner-icon="mdi-magnify"
     :class="expand ? 'expanded' : 'shrinked'"
     class="mx-2"
     @focus="expand = true"
     @blur="expand = false"
    />

    <v-btn @click="formaterSql(basicInfoForm.sqlMain)" class="mx-2 "> <v-icon class="mr-2" small> mdi-code-json </v-icon>Config Structure </v-btn>
    <v-btn class="mx-2 "> <v-icon class="mr-2" small> mdi-arrow-top-right </v-icon>Export </v-btn>
    <v-btn class="ml-2" color="primary" @click.stop="dialogComponent = true"> <v-icon class="mr-2" small> mdi-plus </v-icon>Create component </v-btn>
   </div>
  </div>
  <p class="my-3">Edit components settings, groups folders or drill down for more information</p>
  <v-divider class="mt-3"></v-divider>

  <baseDialog title="Base config structure" no-gutters width="70vw" v-model="DialogEditor">
   <v-card class="pa-0" flat width="100%" height="70vh">
    <base-editor-sql ref="sqleditor" :value="basicInfoForm.sqlMain" @changeTextarea="changeTextarea($event)" />
   </v-card>
  </baseDialog>
 </div>
</template>

<script>
import sqlFormatter from "sql-formatter";

import { sync } from "vuex-pathify";

export default {
 name: "ComponentsAppbar",

 data() {
  return {
   basicInfoForm: {
    sqlMain: ""
   },
   expand: false,
   DialogEditor: false
  };
 },

 computed: {
  ...sync("componentManagement", ["dialogComponent", "search"])
 },

 methods: {
  changeModalTextarea(val) {
   this.$set(this.basicInfoForm, "sqlMain", val);
  },
  formaterSql(val) {
   this.DialogEditor = true;
   let dom = this.$refs.sqleditor;
   dom.editor.setValue(sqlFormatter.format(dom.editor.getValue()));
  }
 }
};
</script>
