<template>
  <div>
    <accounts-appbar />
    <accounts-tabs />

    <v-divider />

    <v-card
      color="transparent"
      flat
      :height="calculateHeight()"
      :class="{ dottedBackground: !isTableLayout }"
      class="overflow-y-scroll"
    >
      <v-scroll-y-transition hide-on-leave>
        <accounts-table v-if="isTableLayout && !isAllFilteredEntitiesEmpty" />
      </v-scroll-y-transition>

      <v-scroll-x-transition hide-on-leave>
        <accounts-grid v-if="!isTableLayout && !isAllFilteredEntitiesEmpty" />
      </v-scroll-x-transition>

      <v-scroll-y-transition hide-on-leave>
        <accounts-no-data v-if="isAllFilteredEntitiesEmpty" />
      </v-scroll-y-transition>
    </v-card>

    <dialog-entity />
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';

  export default {
    name: 'AccountsManagement',
    components: {
      AccountsTabs: () => import(/* webpackChunkName: 'accounts-tabs' */ './AccountsTabs.vue'),
      AccountsGrid: () => import(/* webpackChunkName: 'accounts-grid' */ './AccountsGrid'),
      AccountsTable: () => import(/* webpackChunkName: 'accounts-table' */ './AccountsTable'),
      AccountsAppbar: () => import(/* webpackChunkName: 'accounts-appbar' */ './AccountsAppbar'),
      AccountsNoData: () => import(/* webpackChunkName: 'accounts-no-data' */ './AccountsNoData'),
      DialogEntity: () => import(/* webpackChunkName: 'accounts-dialog-entity' */ './DialogEntity'),
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('accountsManagement', ['isTableLayout']),
      ...get('accountsManagement', ['isAllFilteredEntitiesEmpty']),
    },

    mounted() {
      this.getUsers();
      this.getRoles();
      this.getCapabilities();
    },

    methods: {
      ...call('accountsManagement/*'),
      calculateHeight() {
        return Number(this.$vuetify.breakpoint.height - 366);
      },
    },
  };
</script>

<style></style>
