<template>
  <v-main :style="themeBackground">
    <v-fade-transition hide-on-leave mode="out-in" :duration="100">
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

      themeBackground() {
        if (this.$route.name === 'Login' && this.isDark) {
          return this.loginBackgroundDark;
        }

        if (this.$route.name === 'Login' && !this.isDark) {
          return this.loginBackgroundLight;
        }

        return null;
      },

      loginBackgroundLight() {
        return {
          'background-image': `linear-gradient(rgba(0, 0, 0, 0.3),rgba(0, 0, 0, 0.8)), url(storage/backgrounds/back3.png)`,
          'background-repeat': 'no-repeat',
          'background-size': 'cover',
          'background-attachment': 'fixed',
        };
      },

      loginBackgroundDark() {
        return {
          'background-image': `linear-gradient(rgba(60, 60, 60, 0.6),rgba(0, 0, 0, 0.9)), url(storage/backgrounds/bb1.png)`,
          'background-repeat': 'no-repeat',
          'background-size': 'cover',
          'background-attachment': 'fixed',
        };
      },
    },
  };
</script>

<
