<template>
 <v-main>
  <v-container fluid>
   <v-fade-transition hide-on-leave>
    <router-view />
   </v-fade-transition>
  </v-container>
 </v-main>
</template>

<script>
import { store } from "@/store";

export default {
 name: "Secureview",

 computed: {}
};
</script>
