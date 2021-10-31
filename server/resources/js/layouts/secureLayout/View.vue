<template>
  <v-main style="min-height: 100vh">
    <!-- <secure-comp-toolbar v-if="$route.name.startsWith('Components')" /> -->
    <v-overlay
      :z-index="6"
      :value="secureComponentDrawerBranch"
      :color="isDark ? '#1f1f24' : 'rgba(108, 122, 137)'"
    />

    <v-fade-transition mode="out-in" :duration="520" hide-on-leave>
      <router-view />
    </v-fade-transition>
    <!-- <Status-bar v-if="$route.name.startsWith('Components')" /> -->
  </v-main>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'SecureView',

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('drawers', ['secureComponentDrawerBranch']),
    },

    // components: {
    //   StatusBar: () => import(/* webpackChunkName: 'components-status-bar' */ './StatusBar'),
    //   SecureCompToolbar: () => import(/* webpackChunkName: 'secure-bundle' */ './ComponentToolbar'),
    // },
  };
</script>
