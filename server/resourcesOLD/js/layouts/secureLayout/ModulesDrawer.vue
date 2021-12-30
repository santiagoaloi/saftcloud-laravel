<template v-if="$route.name.startsWith('Modules')">
  <v-navigation-drawer value="true" mobile-breakpoint="0" clipped width="350" hide-overlay right app>
    <!-- Drawer fixed top -->
    <!-- <template #prepend>
      <modules-drilldown-bar />
    </template> -->

    <template #default>
      <!-- Drawer content -->
      <modules-drilldown v-if="hasSelectedModule" />

      <!-- Drawer content when empty -->
      <modules-drilldown-empty v-if="!hasSelectedModule" />
    </template>

    <!-- Drawer fixed bottom -->
    <template #append>
      <modules-drilldown-footer v-if="hasSelectedModule" />
    </template>
  </v-navigation-drawer>
</template>

<script>
  import { sync, get } from 'vuex-pathify';

  export default {
    name: 'SecureModulesDrawer',

    components: {
      ModulesDrilldown: () =>
        import(/* webpackChunkName: 'drawer-bundle' */ '@/components/navigation/modulesDrilldown/ModulesDrilldown'),
      ModulesDrilldownEmpty: () =>
        import(/* webpackChunkName: 'drawer-bundle' */ '@/components/navigation/modulesDrilldown/ModulesDrilldownEmpty'),
      // ModulesDrilldownBar: () =>
      //   import(/* webpackChunkName: 'drawer-bundle' */ '@/components/navigation/modulesDrilldown/ModulesDrilldownBar'),
      ModulesDrilldownFooter: () =>
        import(/* webpackChunkName: 'drawer-bundle' */ '@/components/navigation/modulesDrilldown/ModulesDrilldownFooter'),
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('drawers', ['secureModulesDrawer']),
      ...get('modulesManagement', ['hasSelectedModule']),
    },
  };
</script>
