<template>
 <div>
  <v-divider />
  <form-fields-toolbar />
  <v-divider />
  <v-row class="mt-0">
   <v-col cols="5">
    <form-fields-list />
   </v-col>

   <v-col cols="6">
    <div class="d-flex">
     <v-divider vertical />
     <form-fields-right-panel class="px-3" />
    </div>
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
  FormFieldsList: () => import("./FormFieldsList"),
  FormFieldsToolbar: () => import("./FormFieldsToolbar"),
  FormFieldsRightPanel: () => import("./FormFieldsRightPanel")
 }
};
</script>
