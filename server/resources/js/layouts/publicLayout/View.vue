<template>
 <v-main style="min-height:90vh">
  <v-fade-transition>
   <router-view />
  </v-fade-transition>
 </v-main>
</template>

<script>
export default {
 name: "Publicview",
 data() {
  return {
   booted: false
  };
 }
};
</script>
