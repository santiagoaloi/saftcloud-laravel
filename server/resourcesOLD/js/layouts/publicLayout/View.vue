<template>
  <v-main>
    <v-fade-transition appear :duration="3000">
      <video
        v-if="$route.meta.layout === 'public-layout'"
        src="storage/videos/space3.mp4"
        style="opacity: 0.1"
        autoPlay
        loop
        muted
        type="video/mp4"
      />
    </v-fade-transition>
    <v-fade-transition appear hide-on-leave mode="out-in" :duration="100">
      <router-view />
    </v-fade-transition>
  </v-main>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'PublicView',
    computed: {
      ...sync('theme', ['isDark']),
    },
  };
</script>

<style>
  video {
    object-fit: cover;
    width: 100%;
    height: 100%;
    position: fixed;
  }
</style>
