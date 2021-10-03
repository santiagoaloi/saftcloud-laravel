<template>
  <div>
    <entities-appbar />
    <entities-tabs />

    <v-divider />

    <v-card
      color="transparent"
      flat
      :height="calculateHeight()"
      :class="{ dottedBackground: !isTableLayout }"
      class="overflow-y-scroll"
    >
      <v-scroll-y-transition hide-on-leave>
        <entities-table v-if="isTableLayout && !isAllFilteredEntitiesEmpty" />
      </v-scroll-y-transition>

      <v-scroll-x-transition hide-on-leave>
        <entities-grid v-if="!isTableLayout && !isAllFilteredEntitiesEmpty" />
      </v-scroll-x-transition>

      <v-scroll-y-transition hide-on-leave>
        <entities-no-data v-if="isAllFilteredEntitiesEmpty" />
      </v-scroll-y-transition>
    </v-card>

    <dialog-entity />
    <dialog-privileges />
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';

  export default {
    name: 'EntitiesManagement',
    components: {
      EntitiesGrid: () => import(/* webpackChunkName: 'entities-grid' */ './EntitiesGrid'),
      EntitiesTable: () => import(/* webpackChunkName: 'entities-table' */ './EntitiesTable'),
      EntitiesTabs: () => import(/* webpackChunkName: 'entities-tabs' */ './EntitiesTabs.vue'),
      EntitiesAppbar: () => import(/* webpackChunkName: 'entities-appbar' */ './EntitiesAppbar'),
      EntitiesNoData: () => import(/* webpackChunkName: 'entities-no-data' */ './EntitiesNoData'),
      DialogEntity: () => import(/* webpackChunkName: 'entities-dialog-entity' */ './DialogEntity'),
      DialogPrivileges: () =>
        import(/* webpackChunkName: 'entities-dialog-privileges' */ './DialogPrivileges'),
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('entitiesManagement', ['isTableLayout']),
      ...get('entitiesManagement', ['isAllFilteredEntitiesEmpty']),
    },

    mounted() {
      this.getUsers();
      this.getRoles();
      this.getCapabilities();
    },

    methods: {
      ...call('entitiesManagement/*'),
      calculateHeight() {
        return Number(this.$vuetify.breakpoint.height - 366);
      },
    },
  };
</script>

<style></style>
