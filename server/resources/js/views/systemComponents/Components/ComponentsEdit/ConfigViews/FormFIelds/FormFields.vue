<template>
 <div>
  <v-divider></v-divider>
  <form-fields-toolbar />
  <v-row class="mt-1">
   <v-col cols="auto"> <form-fields-list /> </v-col>
   <v-col> <v-sheet class="rightPanelHeight transparent"> </v-sheet> </v-col>
  </v-row>
 </div>
</template>

<script>
import axios from "axios";
import draggable from "vuedraggable";

import { sync, get } from "vuex-pathify";
export default {
 name: "ComponentsEditViewsBasic",
 components: {
  draggable,
  FormFieldsToolbar: () => import("./FormFieldsToolbar"),
  FormFieldsList: () => import("./FormFieldsList")
 },

 data: () => ({
  showSelectedOnly: false,
  search: "",
  selectedFieldItem: 0
 })
};
</script>
