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
    import(/* webpackChunkName: 'entities-navigation-drilldown' */ '@/components/navigation/entitiesDrilldown/EntitiesDrilldown'),
  );
  Vue.component('EntitiesDrilldownBar', () =>
    import(
      /* webpackChunkName: 'entities-navigation-drilldown-bar' */ '@/components/navigation/entitiesDrilldown/EntitiesDrilldownBar'
    ),
  );

  Vue.component('EntitiesDrilldownFooter', () =>
    import(
      /* webpackChunkName: 'entities-navigation-drilldown-footer' */ '@/components/navigation/entitiesDrilldown/EntitiesDrilldownFooter'
    ),
  );

  export default {
    name: 'EntitiesDrawer',
    computed: {
      ...sync('theme', ['isDark']),
      ...get('entitiesManagement', ['selectedEntity']),
    },
  };
</script>
