<template>
  <div>
    <base-flex-container>
      <template #top>
        <modules-widgets />
        <modules-toolbar />
        <v-divider />
        <modules-tabs />
      </template>

      <v-scroll-y-transition hide-on-leave>
        <component :is="isTableLayout ? 'ModulesTable' : 'ModulesGrid'" v-if="!isAllFilteredModulesEmpty" />
        <modules-no-data v-else />
      </v-scroll-y-transition>

      <template #footer>
        <status-bar />
      </template>
    </base-flex-container>

    <edit-bottom-sheet
      v-if="modulesEditSheet"
      v-model="modulesEditSheet"
      :menu-items="menuItems"
      :toolbar-title="modulesTitle"
      toolbar-icon="mdi-pencil"
    />

    <dialog-Modules />
    <dialog-config-editor />
    <dialog-groups />
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';

  export default {
    name: 'ModulesManagement',
    components: {
      EditBottomSheet: () =>
        import(/* webpackChunkName: 'secure-bundle-Modules' */ '@/components/layoutStructures/EditBottomSheet/Index.vue'),
      ModulesToolbar: () => import(/* webpackChunkName: 'secure-bundle-Modules' */ './ModulesToolbar'),
      ModulesWidgets: () => import(/* webpackChunkName: 'secure-bundle-Modules' */ './ModulesWidgets'),
      StatusBar: () => import(/* webpackChunkName: 'secure-bundle-Modules' */ './ModulesStatusBar'),
      ModulesTabs: () => import(/* webpackChunkName: 'secure-bundle-Modules' */ './ModulesTabs'),
      ModulesGrid: () => import(/* webpackChunkName: 'secure-bundle-Modules' */ './ModulesGrid'),
      ModulesTable: () => import(/* webpackChunkName: 'Modules-table' */ './ModulesTable'),
      ModulesNoData: () => import(/* webpackChunkName: 'Modules-no-data' */ './ModulesNoData'),
      DialogModules: () => import(/* webpackChunkName: 'Modules-dialog-new-Modules' */ './DialogModules'),
      DialogConfigEditor: () => import(/* webpackChunkName: 'Modules-dialog-config-editor' */ './DialogConfigEditor'),
      DialogGroups: () => import(/* webpackChunkName: 'Modules-dialog-groups' */ './DialogGroups'),
    },

    data() {
      return {
        wrap: true,
        menuItems: [
          { header: 'Modules Settings' },
          {
            icon: 'mdi-view-dashboard-outline',
            text: 'Basic',
            route: 'views/System/Modules/ModulesEdit/ConfigViews/Basic/Basic.vue',
          },
          {
            icon: 'mdi-view-dashboard-outline',
            text: 'Capabilities',
            route: 'views/System/Modules/ModulesEdit/ConfigViews/Capabilities/Capabilities.vue',
            disabled: false,
          },
          {
            icon: 'mdi-view-dashboard-outline',
            text: 'Query',
            route: 'views/System/Modules/ModulesEdit/ConfigViews/Query/Query.vue',
            disabled: false,
          },
          {
            icon: 'mdi-view-dashboard-outline',
            text: 'Fields',
            route: 'views/System/Modules/ModulesEdit/ConfigViews/FormFields/FormFields.vue',
            disabled: false,
          },
        ],
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('modulesManagement', ['isTableLayout', 'dialogModules', 'modulesEditSheet', 'dialogGroups']),
      ...get('modulesManagement', ['isAllFilteredModulesEmpty', 'selectedModule']),

      modulesTitle() {
        return this.selectedModule ? this.selectedModule.config.general_config.title : '';
      },
    },

    created() {
      this.getModules();
      this.getDbGroupNames();
      this.getDbTablesAndColumns();
    },

    methods: {
      ...call('modulesManagement', ['getModules', 'getDbGroupNames', 'getDbTablesAndColumns']),
    },
  };
</script>
