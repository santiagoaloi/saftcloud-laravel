<template>
  <v-navigation-drawer value="true" mobile-breakpoint="0" clipped width="350" hide-overlay right app>
    <!-- Drawer fixed top -->
    <template #prepend>
      <entities-drilldown-bar />
    </template>

    <!-- Drawer content -->
    <entities-drilldown />

    <!-- Drawer fixed bottom -->
    <template #append>
      <entities-drilldown-footer />
    </template>
  </v-navigation-drawer>
</template>

<script>
  import Vue from 'vue';
  import { sync, get } from 'vuex-pathify';

  Vue.component('EntitiesDrilldown', () =>
    import(/* webpackChunkName: 'entities-navigation-drilldown' */ '@/components/Navigation/EntitiesDrilldown'),
  );
  Vue.component('EntitiesDrilldownBar', () =>
    import(/* webpackChunkName: 'entities-navigation-drilldown-bar' */ '@/components/Navigation/EntitiesDrilldownBar'),
  );

  Vue.component('EntitiesDrilldownFooter', () =>
    import(/* webpackChunkName: 'entities-navigation-drilldown-footer' */ '@/components/Navigation/EntitiesDrilldownFooter'),
  );

  export default {
    name: 'EntitiesComponentDrawer',
    computed: {
      ...sync('theme', ['isDark']),
      ...get('entitiesManagement', ['selectedEntity']),
    },
  };
</script>
