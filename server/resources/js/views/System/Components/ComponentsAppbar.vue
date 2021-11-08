<template>
  <div>
    <div class="d-flex justify-end align-center transparent">
      <components-groups />

      <div class="flex-grow-1" />
      <v-btn plain class="mx-2" @click="dialogEditor = true">
        <v-icon :left="$vuetify.breakpoint.lgAndUp" small> mdi-code-json </v-icon
        >{{ configStructureTitle }}
      </v-btn>
      <v-btn
        class="ml-2"
        :color="isDark ? 'accent' : 'primary'"
        @click.stop="dialogComponent = true"
      >
        <v-icon :left="$vuetify.breakpoint.lgAndUp" small> mdi-view-grid-plus </v-icon
        >{{ createComponentTitle }}
      </v-btn>

      <v-btn class="ml-2" :color="isDark ? 'accent' : 'primary'" @click="addGroupDialog()">
        <v-icon :left="$vuetify.breakpoint.lgAndUp" small> mdi-view-grid-plus </v-icon
        >{{ createGroupTitle }}
      </v-btn>
    </div>

    <v-divider class="mt-2"></v-divider>

    <v-sheet class="transparent" height="40">
      <components-groups-chips />
    </v-sheet>

    <v-divider class="mt-3"></v-divider>
    <dialog-config-editor v-if="dialogEditor" />
  </div>
</template>

<script>
  import { sync, call } from 'vuex-pathify';
  import componentGroups from '@/mixins/componentGroups';

  export default {
    name: 'ComponentsAppbar',

    components: {
      DialogConfigEditor: () =>
        import(/* webpackChunkName: 'components-dialog-config-editor' */ './DialogConfigEditor'),
      ComponentsGroups: () =>
        import(/* webpackChunkName: 'secure-bundle-comp' */ './ComponentsGroups'),
      ComponentsGroupsChips: () =>
        import(/* webpackChunkName: 'secure-bundle-comp' */ './ComponentsGroupsChips'),
    },
    mixins: [componentGroups],

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['dialogComponent', 'dialogEditor']),

      configStructureTitle() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Config Structure' : '';
      },

      createComponentTitle() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Create component' : '';
      },

      createGroupTitle() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Create group' : '';
      },
    },

    methods: {
      ...call('componentManagement/*'),
    },
  };
</script>
