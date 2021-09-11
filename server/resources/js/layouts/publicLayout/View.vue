<template>
 <v-main style="min-height:90vh">
  <router-view></router-view>
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
