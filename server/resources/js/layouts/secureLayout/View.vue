<template>
  <v-main style="min-height: 100vh">
    <v-fade-transition appear :duration="520">
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
      ...sync('modulesManagement', ['selectedModuleGroupsMenuTrigger']),
      ...sync('drawers', ['secureModulesDrawerBranch']),
    },
  };
</script>
