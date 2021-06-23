<template>
 <v-expand-transition appear>
  <v-sheet color="transparent" v-if="alert">
   <v-alert v-model="alert" dismissible border="left" colored-border color="grey darken-2" elevation="2" class="text-left ">
    All new accounts are free of charge for the first 14 days since the day of registration, no payment information is required until the trial ends.
    The information uploaded to SaftCloud is confidential and only available to you. We don't comercialice any data uploaded to our databases. Once
    the trial ends, we will retain the data one week, to provide you with backups or exporting capabilities.
   </v-alert>
  </v-sheet>
 </v-expand-transition>
</template>

<script>
export default {
 name: "SignupAlert",

 data() {
  return {
   alert: true
  };
 },

 mounted() {},

 methods: {}
};
</script>
