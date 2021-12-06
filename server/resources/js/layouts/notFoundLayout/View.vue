<template>
  <v-main :style="!isDark ? loginBackgroundLight : loginBackgroundDark">
    <v-fade-transition leave-active-class="leaveTransition" mode="out-in" :duration="520">
      <keep-alive>
        <v-container fluid class="fill-height pt-0">
          <router-view />
        </v-container>
      </keep-alive>
    </v-fade-transition>
  </v-main>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'PublicView',
    computed: {
      ...sync('theme', ['isDark']),
      loginBackgroundLight() {
        return {
          'background-image': `linear-gradient(rgba(200, 200, 200, 0.2),rgba(0, 0, 0, 0.9)), url(storage/backgrounds/back3.png)`,
          'background-repeat': 'no-repeat',
          'background-size': 'cover',
          'background-attachment': 'fixed',
        };
      },

      loginBackgroundDark() {
        return {
          'background-image': `linear-gradient(rgba(60, 60, 60, 0.6),rgba(0, 0, 0, 0.9)), url(storage/backgrounds/back2.png)`,
          'background-repeat': 'no-repeat',
          'background-size': 'cover',
          'background-attachment': 'fixed',
        };
      },
    },
  };
</script>
