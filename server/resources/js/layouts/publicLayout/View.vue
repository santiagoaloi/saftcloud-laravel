<template>
  <v-main style="min-height: 110vh">
    <v-fade-transition hide-on-leave>
      <router-view />
    </v-fade-transition>
  </v-main>
</template>

<script>
  export default {
    name: 'PublicView',
  };
</script>
