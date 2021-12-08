<template v-if="$route.name.startsWith('Components')">
  <v-navigation-drawer value="true" mobile-breakpoint="0" clipped width="350" hide-overlay right app>
    <!-- Drawer fixed top -->
    <!-- <template #prepend>
      <component-drilldown-bar />
    </template> -->

    <template #default>
      <!-- Drawer content -->
      <component-drilldown v-if="hasSelectedComponent" />

      <!-- Drawer content when empty -->
      <component-drilldown-empty v-if="!hasSelectedComponent" />
    </template>

    <!-- Drawer fixed bottom -->
    <template #append>
      <component-drilldown-footer v-if="hasSelectedComponent" />
    </template>
  </v-navigation-drawer>
</template>

<script>
  import { sync, get } from 'vuex-pathify';

  export default {
    name: 'SecureComponentDrawer',

    components: {
      ComponentDrilldown: () =>
        import(/* webpackChunkName: 'drawer-bundle' */ '@/components/Navigation/ComponentDrilldown/ComponentDrilldown'),
      ComponentDrilldownEmpty: () =>
        import(/* webpackChunkName: 'drawer-bundle' */ '@/components/Navigation/ComponentDrilldown/ComponentDrilldownEmpty'),
      ComponentDrilldownBar: () =>
        import(/* webpackChunkName: 'drawer-bundle' */ '@/components/Navigation/ComponentDrilldown/ComponentDrilldownBar'),
      ComponentDrilldownFooter: () =>
        import(/* webpackChunkName: 'drawer-bundle' */ '@/components/Navigation/ComponentDrilldown/ComponentDrilldownFooter'),
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('drawers', ['secureComponentDrawer']),
      ...get('componentManagement', ['hasSelectedComponent']),
    },
  };
</script>
