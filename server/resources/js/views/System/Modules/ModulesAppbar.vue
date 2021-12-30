<template>
  <fragment>
    <div class="d-flex justify-end align-center transparent">
      <modules-groups />

      <div class="flex-grow-1" />
      <v-btn plain class="mx-2" @click="dialogEditor = true">
        <v-icon :left="$vuetify.breakpoint.lgAndUp" small> mdi-code-json </v-icon>{{ configStructureTitle }}
      </v-btn>
      <v-btn class="ml-2" :color="isDark ? 'accent' : 'primary'" @click.stop="dialogModules = true">
        <v-icon :left="$vuetify.breakpoint.lgAndUp" small> mdi-view-grid-plus </v-icon>{{ createmodulesTitle }}
      </v-btn>

      <v-btn class="ml-2" :color="isDark ? 'accent' : 'primary'" @click="addGroupDialog()">
        <v-icon :left="$vuetify.breakpoint.lgAndUp" small> mdi-view-grid-plus </v-icon>{{ createGroupTitle }}
      </v-btn>
    </div>

    <v-divider class="mt-2"></v-divider>

    <v-sheet class="transparent" height="40">
      <modules-groups-chips />
    </v-sheet>

    <v-divider class="mt-3"></v-divider>
    <dialog-config-editor v-if="dialogEditor" />
  </fragment>
</template>

<script>
  import { sync, call } from 'vuex-pathify';
  import modulesGroups from '@/mixins/modulesGroups';

  export default {
    name: 'ModulesAppbar',

    components: {
      DialogConfigEditor: () => import(/* webpackChunkName: 'Modules-dialog-config-editor' */ './DialogConfigEditor'),
    },
    mixins: [modulesGroups],

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('modulesManagement', ['dialogModules', 'dialogEditor']),

      configStructureTitle() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Config Structure' : '';
      },

      createmodulesTitle() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Create Modules' : '';
      },

      createGroupTitle() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Create group' : '';
      },
    },

    methods: {
      ...call('modulesManagement/*'),
    },
  };
</script>
