<template>
  <div>
    <base-flex-container class="dottedBackground">
      <template #top>
        <div>
          <entities-appbar />
          <entities-tabs />
        </div>
      </template>

      <v-scroll-y-transition hide-on-leave>
        <entities-table v-if="isTableLayout && !isAllFilteredEntitiesEmpty" />
      </v-scroll-y-transition>

      <v-scroll-x-transition hide-on-leave>
        <entities-grid v-if="!isTableLayout && !isAllFilteredEntitiesEmpty" />
      </v-scroll-x-transition>

      <v-scroll-y-transition hide-on-leave>
        <entities-no-data v-if="isAllFilteredEntitiesEmpty" />
      </v-scroll-y-transition>
    </base-flex-container>

    <dialog-entity v-if="dialogEntity" />
    <dialog-privileges v-if="dialogPrivileges" />
    <dialog-assign-roles v-if="dialogAssignRoles" />
    <entities-edit-sheet v-if="entitiesEditSheet" />
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';

  export default {
    name: 'EntitiesManagement',
    components: {
      EntitiesGrid: () => import(/* webpackChunkName: 'entities-grid' */ './EntitiesGrid'),
      EntitiesTable: () => import(/* webpackChunkName: 'entities-table' */ './EntitiesTable'),
      EntitiesTabs: () => import(/* webpackChunkName: 'entities-bundle' */ './EntitiesTabs.vue'),
      EntitiesAppbar: () => import(/* webpackChunkName: 'entities-bundle' */ './EntitiesAppbar'),
      EntitiesNoData: () => import(/* webpackChunkName: 'entities-no-data' */ './EntitiesNoData'),
      DialogEntity: () => import(/* webpackChunkName: 'entities-dialog-entity' */ './DialogEntity'),
      DialogPrivileges: () => import(/* webpackChunkName: 'entities-dialog-privileges' */ './DialogPrivileges'),
      DialogAssignRoles: () => import(/* webpackChunkName: 'entities-dialog-assign-roles' */ './DialogAssignRoles'),
      EntitiesEditSheet: () => import(/* webpackChunkName: 'entities-edit-sheet' */ './EntitiesEdit/EntitiesEditSheet'),
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('entitiesManagement', [
        'isTableLayout',
        'dialogEntity',
        'dialogPrivileges',
        'dialogAssignRoles',
        'entitiesEditSheet',
      ]),
      ...get('entitiesManagement', ['isAllFilteredEntitiesEmpty', 'selectedEntityType', 'selectedEntity']),
    },

    created() {
      this.getUsers();
      this.getRoles();
      this.getCapabilities();
    },

    methods: {
      ...call('entitiesManagement/*'),
    },
  };
</script>

<style></style>
