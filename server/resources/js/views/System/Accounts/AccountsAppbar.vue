<template>
 <div>
  <div class="d-flex justify-end align-center">
   <div class="d-flex">
    <v-btn plain class="mx-2 "> <v-icon class="mr-2" small> mdi-arrow-top-right </v-icon>Export </v-btn>
    <v-btn class="ml-2" :color="isDark ? 'accent' : 'primary'" @click.stop="dialogAccount = true">
     <v-icon class="mr-2" small> mdi-plus </v-icon>Create role
    </v-btn>
    <v-btn class="ml-2" :color="isDark ? 'accent' : 'primary'" @click.stop="dialogAccount = true">
     <v-icon class="mr-2" small> mdi-plus </v-icon>Create user
    </v-btn>
   </div>
  </div>
  <v-divider class="mt-3"></v-divider>
 </div>
</template>

<script>
import { sync, call } from "vuex-pathify";
export default {
 name: "AccountsAppbar",

 methods: {
  ...call("accountManagement/*")
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("accountsManagement", ["dialogAccount", "dialogEditor"])
 }
};
</script>
