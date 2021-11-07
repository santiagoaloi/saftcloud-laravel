<template>
  <v-navigation-drawer
    :value="drawer"
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
    <component-drilldown />

    <!-- Drawer fixed bottom -->
    <template #append>
      <component-drilldown-footer />
    </template>
  </v-navigation-drawer>
</template>

<script>
  import Vue from 'vue';
  import { sync, get } from 'vuex-pathify';

  Vue.component('ComponentDrilldown', () =>
    import(/* webpackChunkName: 'drawer-bundle' */ '@/components/Navigation/ComponentDrilldown'),
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
      ...get('componentManagement', ['selectedComponent']),

      drawer() {
        if (!this.selectedComponent || !this.secureComponentDrawer) {
          return false;
        }
        return true;
      },
    },
  };
</script>
