<template>
  <v-main>
    <router-view />
  </v-main>
</template>

<script>
export default {
  name: "Publicview"
};
</script>

<style scoped>
.v-main {
  transition: 0s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
