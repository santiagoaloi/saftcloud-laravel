<template>
  <div>
    <base-flex-container>
      <template #top>
        <div class="removeGutters">
          <components-toolbar />
          <components-appbar />
        </div>
        <components-tabs />
      </template>

      <template #main>
        <v-scroll-y-transition hide-on-leave>
          <components-table v-if="isTableLayout && !isAllFilteredComponentsEmpty" />
        </v-scroll-y-transition>

        <v-scroll-x-transition hide-on-leave>
          <components-grid v-if="!isTableLayout && !isAllFilteredComponentsEmpty" />
        </v-scroll-x-transition>
        <v-scroll-y-transition hide-on-leave>
          <components-no-data v-if="isAllFilteredComponentsEmpty" />
        </v-scroll-y-transition>
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

      ComponentsAppbar: () => import(/* webpackChunkName: 'secure-bundle-components' */ './ComponentsAppbar'),
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
      ...get('componentManagement', ['isAllFilteredComponentsEmpty', 'selectedComponent']),
    },

    mounted() {
      this.getComponents();
      this.getDbGroupNames();
      this.getDbTablesAndColumns();
    },

    methods: {
      ...call('componentManagement/*'),
    },
  };
</script>

<style scoped>
  .removeGutters {
    margin-top: -11px;
    margin-left: -11px;
  }
</style>
