<template>
  <v-navigation-drawer
    value="true"
    mobile-breakpoint="0"
    clipped
    width="350"
    hide-overlay
    right
    app
  >
    <!-- Drawer fixed top -->
    <template #prepend>
      <component-drilldown-bar />
    </template>

    <!-- Drawer content -->
    <component-drilldown v-show="hasSelectedComponent" />

    <!-- Drawer content when empty -->
    <component-drilldown-empty v-show="!hasSelectedComponent" />

    <!-- Drawer fixed bottom -->
    <template #append>
      <component-drilldown-footer v-show="hasSelectedComponent" />
    </template>
  </v-navigation-drawer>
</template>

<script>
  import Vue from 'vue';
  import { sync, get } from 'vuex-pathify';

  Vue.component('ComponentDrilldown', () =>
    import(/* webpackChunkName: 'drawer-bundle' */ '@/components/Navigation/ComponentDrilldown'),
  );

  Vue.component('ComponentDrilldownEmpty', () =>
    import(
      /* webpackChunkName: 'drawer-bundle' */ '@/components/Navigation/ComponentDrilldownEmpty'
    ),
  );

  Vue.component('ComponentDrilldownBar', () =>
    import(/* webpackChunkName: 'drawer-bundle' */ '@/components/Navigation/ComponentDrilldownBar'),
  );
  Vue.component('ComponentDrilldownFooter', () =>
    import(
      /* webpackChunkName: 'drawer-bundle' */ '@/components/Navigation/ComponentDrilldownFooter'
    ),
  );

  export default {
    name: 'SecureComponentDrawer',
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('drawers', ['secureComponentDrawer']),
      ...get('componentManagement', ['hasSelectedComponent']),
    },
  };
</script>
