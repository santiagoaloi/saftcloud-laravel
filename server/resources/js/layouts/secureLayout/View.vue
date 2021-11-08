<template>
  <v-main style="min-height: 100vh">
    <!-- <secure-comp-toolbar v-if="$route.name.startsWith('Components')" /> -->
    <v-overlay
      v-if="overlayValue"
      :z-index="6"
      :opacity="0.9"
      :color="$vuetify.theme.dark ? '#20202b' : 'rgba(108, 122, 137)'"
      :value="overlayValue"
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
      ...sync('theme', ['isDark', 'overlay']),
      ...sync('componentManagement', ['selectedComponentGroupsMenuTrigger']),
      ...sync('drawers', ['secureComponentDrawerBranch']),

      overlayValue() {
        if (this.selectedComponentGroupsMenuTrigger || this.secureComponentDrawerBranch) {
          return true;
        }
        return false;
      },

      zindex() {
        if (this.secureComponentDrawerBranch) {
          return 4;
        }
        return 4;
      },
    },
  };
</script>
