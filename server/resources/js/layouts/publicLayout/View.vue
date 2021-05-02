<template>
 <v-main>
  <!-- <v-app class="cms-container"> -->
  <router-view />
  <!-- </v-app> -->
 </v-main>
</template>

<script>
export default {
 name: "Publicview"
};
</script>

<style>
.v-main {
 transition: 0s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
