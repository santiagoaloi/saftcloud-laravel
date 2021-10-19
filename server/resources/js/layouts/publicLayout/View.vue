<template>
  <v-main style="min-height: 110vh">
    <v-fade-transition mode="out-in">
      <router-view />
    </v-fade-transition>
  </v-main>
</template>

<script>
  export default {
    name: 'PublicView',
  };
</script>
