<template>
  <v-main style="min-height: 100vh">
    <v-overlay
      v-if="overlayValue"
      v-once
      :z-index="5"
      :opacity="0.9"
      :color="$vuetify.theme.dark ? '#20202b' : 'rgba(108, 122, 137)'"
      :value="overlayValue"
    />

    <v-fade-transition mode="out-in" :duration="520" hide-on-leave>
      <router-view />
    </v-fade-transition>
  </v-main>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'SecureView',

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['selectedComponentGroupsMenuTrigger']),
      ...sync('drawers', ['secureComponentDrawerBranch']),

      overlayValue() {
        if (this.selectedComponentGroupsMenuTrigger || this.secureComponentDrawerBranch) {
          return true;
        }
        return false;
      },
    },
  };
</script>
