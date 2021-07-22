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
export default {
 name: "Secureview"
};
</script>
