<template>
 <baseDialog
  v-model="dialogGroup"
  title="Group settings "
  persistent
  max-width="500
 "
  @save="saveGroup()"
  @close="closeDialogGroup()"
 >
  <v-row>
   <v-col>
    <span>Group name</span>
    <v-text-field
     ref="groupTitle"
     v-model="groupName"
     counter
     maxlength="35"
     autofocus
     solo
     prepend-inner-icon="mdi-comment"
     :color="isDark ? 'white' : ''"
     :background-color="isDark ? 'grey darken-4' : 'grey lighten-5'"
     :error="errors.length > 0"
    />
   </v-col>
  </v-row>
 </baseDialog>
</template>
<script>
import { store } from "@/store";
import { sync, call, set } from "vuex-pathify";

export default {
 name: "DialogGroup",

 methods: {
  ...call("componentManagement/*"),

  closeDialogGroup() {
   this.dialogGroup = false;
   store.set("componentManagement/groupName", "");
  }
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["groupName", "dialogGroup"])
 }
};
</script>
