<template>
  <div>
    <div class="d-flex justify-end align-center transparent">
      <entities-groups />

      <div class="flex-grow-1" />
      <div class="d-flex">
        <v-btn
          v-if="selectedEntityType === 'Roles'"
          class="ml-2"
          :color="isDark ? 'accent' : 'primary'"
          @click.stop="(dialogEntity = true), (identityTypeButton = 'Role')"
        >
          <v-icon :left="$vuetify.breakpoint.lgAndUp" small> mdi-lock-plus </v-icon>
          {{ createRole }}
        </v-btn>
        <v-btn
          v-if="selectedEntityType === 'Users'"
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
    name: 'EntitiesAppbar',
    components: {
      EntitiesGroups: () => import(/* webpackChunkName: 'entities-groups' */ './EntitiesGroups'),
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('entitiesManagement', [
        'dialogEntity',
        'dialogEditor',
        'identityTypeButton',
        'selectedEntityType',
      ]),

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
