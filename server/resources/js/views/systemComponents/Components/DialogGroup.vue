<template>
 <baseDialog v-model="dialogGroup" title="Group settings " persistent max-width="500" @save="saveGroup()" @close="() => (dialogGroup = false)">
  <v-card-text>
   <v-container>
    <v-row>
     <v-col>
      <span>Group name</span>
      <v-text-field ref="groupTitle" v-model="groupName" counter maxlength="35" autofocus solo prepend-inner-icon="mdi-comment" color="primary" />
     </v-col>
    </v-row>
   </v-container>
  </v-card-text>
 </baseDialog>
</template>
<script>
import { store } from "@/store";
import { sync, call, set } from "vuex-pathify";

export default {
 name: "DialogGroup",

 methods: {
  ...call("componentManagement/*")
 },

 computed: {
  ...sync("componentManagement", ["groupName", "dialogGroup"])
 }
};
</script>
