<template>
 <div>
  <v-divider></v-divider>
  <form-fields-toolbar />
  <v-divider></v-divider>
  <v-row class="mt-1">
   <v-col cols="auto">
    <form-fields-list />
   </v-col>
   <v-col>
    <form-fields-right-panel />
   </v-col>
  </v-row>
 </div>
</template>

<script>
import axios from "axios";
import { sync, get } from "vuex-pathify";
export default {
 name: "ComponentsEditViewsBasic",
 components: {
  FormFieldsToolbar: () => import("./FormFieldsToolbar"),
  FormFieldsList: () => import("./FormFieldsList"),
  FormFieldsRightPanel: () => import("./FormFieldsRightPanel")
 },

 data: () => ({})
};
</script>
