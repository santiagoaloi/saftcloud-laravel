<template>
 <div>
  <div class="d-flex justify-space-between align-center">
   <h3 class="hidden-sm-and-down black--text">Manage components</h3>
   <div class="d-flex">
    <v-text-field
     v-model.lazy="search"
     spellcheck="false"
     color="primary lighten-1"
     background-color="white"
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

    <v-btn class="mx-2 " color="white" @click.stop="parentData.dialogSystemOperations = true">
     <v-icon class="mr-2" small> mdi-filter </v-icon>Filter
    </v-btn>

    <v-btn class="mx-2 " color="white" @click.stop="parentData.dialogSystemOperations = true">
     <v-icon class="mr-2" small> mdi-arrow-top-right </v-icon>Export
    </v-btn>

    <v-btn class="ml-2" color="primary" @click.stop="dialogComponent = true"> <v-icon class="mr-2" small> mdi-plus </v-icon>Create component </v-btn>
   </div>
  </div>
  <p class="my-3">Edit components settings, groups folders or drill down for more information</p>
  <v-divider class="mt-3"></v-divider>
 </div>
</template>

<script>
import { sync, call } from "vuex-pathify";

export default {
 name: "ComponentsAppbar",
 inheritAttrs: true,
 props: {
  value: Boolean,
  parentData: Object
 },

 data() {
  return {
   expand: false
  };
 },

 computed: {
  ...sync("componentManagement", ["dialogComponent", "search"])
 }
};
</script>
<style scoped>
.expanded {
 width: 24em;
 -webkit-transition: all 0.7s ease 0s;
 -moz-transition: all 0.7s ease 0s;
 -o-transition: all 0.7s ease 0s;
 transition: all 0.7s ease 0s;
}

.shrinked {
 width: 16em;
 -webkit-transition: all 0.7s ease 0s;
 -moz-transition: all 0.7s ease 0s;
 -o-transition: all 0.7s ease 0s;
 transition: all 0.7s ease 0s;
}
</style>
