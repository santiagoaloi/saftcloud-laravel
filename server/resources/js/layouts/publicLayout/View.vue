<template>
  <v-main style="min-height: 100vh">
    <v-fade-transition mode="out-in" :duration="520" hide-on-leave>
      <router-view />
    </v-fade-transition>
  </v-main>
</template>

<script>
  export default {
    name: 'PublicView',
  };
</script>
