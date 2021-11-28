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
    <edit-bottom-sheet
      v-if="componentEditSheet"
      v-model="componentEditSheet"
      :menu-items="menuItems"
      :toolbar-title="componentTitle"
      toolbar-icon="mdi-pencil"
    />
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';

  export default {
    name: 'ComponentsManagement',
    components: {
      EditBottomSheet: () =>
        import(/* webpackChunkName: 'secure-bundle-components' */ '@/components/LayoutStructures/EditBottomSheet/Index.vue'),
      ComponentsToolbar: () => import(/* webpackChunkName: 'secure-bundle-components' */ './ComponentToolbar'),
      StatusBar: () => import(/* webpackChunkName: 'secure-bundle-components' */ './StatusBar'),
      // ComponentsAppbar: () => import(/* webpackChunkName: 'secure-bundle-components' */ './ComponentsAppbar'),
      ComponentsTabs: () => import(/* webpackChunkName: 'secure-bundle-components' */ './ComponentsTabs'),
      ComponentsGrid: () => import(/* webpackChunkName: 'secure-bundle-components' */ './ComponentsGrid'),
      ComponentsTable: () => import(/* webpackChunkName: 'components-table' */ './ComponentsTable'),
      ComponentsNoData: () => import(/* webpackChunkName: 'components-no-data' */ './ComponentsNoData'),
      DialogComponent: () => import(/* webpackChunkName: 'components-dialog-new-component' */ './DialogComponent'),
    },

    data() {
      return {
        menuItems: [
          { header: 'Component Settings' },
          {
            icon: 'mdi-view-dashboard-outline',
            text: 'Basic',
            componentPath: 'views/System/Components/ComponentsEdit/ConfigViews/Basic/Basic.vue',
          },
          {
            icon: 'mdi-view-dashboard-outline',
            text: 'Capabilities',
            componentPath: 'views/System/Components/ComponentsEdit/ConfigViews/Capabilities/Capabilities.vue',
            disabled: false,
          },
          {
            icon: 'mdi-view-dashboard-outline',
            text: 'Query',
            componentPath: 'views/System/Components/ComponentsEdit/ConfigViews/Query/Query.vue',
            disabled: false,
          },
          {
            icon: 'mdi-view-dashboard-outline',
            text: 'Fields',
            componentPath: 'views/System/Components/ComponentsEdit/ConfigViews/FormFields/FormFields.vue',
            disabled: false,
          },
        ],
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['isTableLayout', 'dialogComponent', 'componentEditSheet']),
      ...get('componentManagement', ['isAllFilteredComponentsEmpty', 'selectedComponent']),

      componentTitle() {
        return this.selectedComponent.config.general_config.title;
      },
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
