<template>
  <div>
    <div class="d-flex justify-end align-center transparent">
      <accounts-groups />

      <div class="flex-grow-1" />
      <div class="d-flex">
        <v-btn
          class="ml-2"
          :color="isDark ? 'accent' : 'primary'"
          @click.stop="(dialogEntity = true), (identityTypeButton = 'Role')"
        >
          <v-icon :left="$vuetify.breakpoint.lgAndUp" small> mdi-lock-plus </v-icon>
          {{ createRole }}
        </v-btn>
        <v-btn
          class="ml-2"
          :color="isDark ? 'accent' : 'primary'"
          @click.stop="(dialogEntity = true), (identityTypeButton = 'User')"
        >
          <v-icon :left="$vuetify.breakpoint.lgAndUp" small> mdi-account-plus </v-icon
          >{{ createUser }}
        </v-btn>
      </div>
    </div>
    <v-divider class="mt-3" />
  </div>
</template>

<script>
  import { sync, call } from 'vuex-pathify';

  export default {
    name: 'AccountsAppbar',
    components: {
      AccountsGroups: () => import(/* webpackChunkName: 'accounts-groups' */ './AccountsGroups'),
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('accountsManagement', ['dialogEntity', 'dialogEditor', 'identityTypeButton']),

      createUser() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Create User' : '';
      },

      createRole() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Create Role' : '';
      },
    },

    methods: {
      ...call('accountManagement/*'),
    },
  };
</script>
