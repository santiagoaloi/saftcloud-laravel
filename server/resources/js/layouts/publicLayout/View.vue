<template>
  <v-main :style="$route.name === 'Login' ? loginBackground : ''" style="min-height: 100vh">
    <v-fade-transition leave-active-class="leaveTransition" mode="out-in" :duration="520">
      <keep-alive>
        <router-view />
      </keep-alive>
    </v-fade-transition>
  </v-main>
</template>

<script>
  export default {
    name: 'PublicView',
    computed: {
      loginBackground() {
        return {
          'background-image': `linear-gradient(rgba(60, 60, 60, 0.6),rgba(0, 0, 0, 0.9)), url(storage/backgrounds/back1.png)`,
          'background-repeat': 'no-repeat',
          'background-size': 'cover',
          'background-attachment': 'fixed',
        };
      },
    },
  };
</script>
