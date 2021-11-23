<template>
  <div>
    <base-flex-container class="dottedBackground">
      <template #top>
        <components-toolbar />
        <v-divider />
        <components-tabs />
      </template>

      <keep-alive>
        <v-scroll-y-transition hide-on-leave>
          <component :is="isTableLayout ? 'componentsTable' : 'componentsGrid'" />
        </v-scroll-y-transition>
      </keep-alive>

      <v-scroll-y-transition hide-on-leave>
        <components-no-data v-if="isAllFilteredComponentsEmpty" />
      </v-scroll-y-transition>

      <template #footer>
        <status-bar />
      </template>
    </base-flex-container>

    <dialog-component v-if="dialogComponent" />
    <component-edit-sheet v-if="componentEditSheet" />
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';

  export default {
    name: 'ComponentsManagement',
    components: {
      ComponentsToolbar: () => import(/* webpackChunkName: 'secure-bundle-components' */ './ComponentToolbar'),
      StatusBar: () => import(/* webpackChunkName: 'secure-bundle-components' */ './StatusBar'),

      // ComponentsAppbar: () => import(/* webpackChunkName: 'secure-bundle-components' */ './ComponentsAppbar'),
      ComponentsTabs: () => import(/* webpackChunkName: 'secure-bundle-components' */ './ComponentsTabs'),
      ComponentsGrid: () => import(/* webpackChunkName: 'secure-bundle-components' */ './ComponentsGrid'),
      ComponentsTable: () => import(/* webpackChunkName: 'components-table' */ './ComponentsTable'),
      ComponentsNoData: () => import(/* webpackChunkName: 'components-no-data' */ './ComponentsNoData'),
      DialogComponent: () => import(/* webpackChunkName: 'components-dialog-new-component' */ './DialogComponent'),
      ComponentEditSheet: () => import(/* webpackChunkName: 'components-edit-sheet' */ './ComponentsEdit/ComponentsEditSheet'),
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['isTableLayout', 'dialogComponent', 'componentEditSheet']),
      ...get('componentManagement', ['isAllFilteredComponentsEmpty']),
    },

    created() {
      this.getComponents();
      this.getDbGroupNames();
      this.getDbTablesAndColumns();
    },

    methods: {
      ...call('componentManagement/*'),
    },
  };
</script>
