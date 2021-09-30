<template>
  <div>
    <div class="d-flex justify-end align-center transparent">
      <components-groups />

      <div class="flex-grow-1" />
      <v-btn plain class="mx-2" @click="dialogEditor = true">
        <v-icon :left="$vuetify.breakpoint.lgAndUp" small> mdi-code-json </v-icon
        >{{ configStructure }}
      </v-btn>
      <v-btn
        class="ml-2"
        :color="isDark ? 'accent' : 'primary'"
        @click.stop="dialogComponent = true"
      >
        <v-icon :left="$vuetify.breakpoint.lgAndUp" small> mdi-view-grid-plus </v-icon
        >{{ createComponent }}
      </v-btn>
    </div>

    <v-divider class="mt-2"></v-divider>

    <v-sheet class="transparent" height="40">
      <components-groups-chips />
    </v-sheet>

    <v-divider class="mt-3"></v-divider>
    <dialog-config-editor />
  </div>
</template>

<script>
  import { sync, call } from 'vuex-pathify';

  export default {
    name: 'ComponentsAppbar',
    components: {
      DialogConfigEditor: () =>
        import(/* webpackChunkName: 'components-dialog-config-editor' */ './DialogConfigEditor'),
      ComponentsGroups: () =>
        import(/* webpackChunkName: 'components-groups' */ './ComponentsGroups'),
      ComponentsGroupsChips: () =>
        import(/* webpackChunkName: 'components-groups-chips' */ './ComponentsGroupsChips'),
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['dialogComponent', 'dialogEditor']),

      configStructure() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Config Structure' : '';
      },

      createComponent() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Create component' : '';
      },
    },

    methods: {
      ...call('componentManagement/*'),
    },
  };
</script>
