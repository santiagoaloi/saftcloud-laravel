<template>
  <v-app-bar>
    <v-icon dark class="mr-4"> {{ icon }} </v-icon>

    <h4 v-if="title" class="ml-2 white--text">Editing {{ title }}</h4>
    <base-typing-indicator v-else />

    <v-spacer />

    <v-fade-transition>
      <div v-if="hasUnsavedChanges(selectedModule)">
        <v-btn large rounded :color="isDark ? 'grey darken-2' : 'white'" class="mx-2" @click="rollbackChanges(selectedModule)">
          <span> Rollback changes</span>
        </v-btn>
      </div>
    </v-fade-transition>

    <v-tooltip transition="false" color="black" bottom>
      <template #activator="{ on }">
        <v-btn color="green lighten-2" class="mr-2" x-small text fab v-on="on" @click="validateBeforeSave(selectedModule)">
          <v-icon> mdi-check </v-icon>
        </v-btn>
      </template>
      <span>Save changes</span>
    </v-tooltip>

    <v-divider inset vertical class="mx-3 grey" />

    <v-tooltip transition="false" color="black" bottom>
      <template #activator="{ on }">
        <v-btn :to="`/${selectedModule.name}`" fab class="mx-2" color="white" text x-small v-on="on">
          <v-icon> mdi-link </v-icon>
        </v-btn>
      </template>
      <span>Open</span>
    </v-tooltip>

    <v-tooltip transition="false" color="black" bottom>
      <template #activator="{ on }">
        <v-btn dark class="mx-2" fab text x-small v-on="on" @click="validateBeforeHide()">
          <v-icon>mdi-chevron-down</v-icon>
        </v-btn>
      </template>
      <span>Hide</span>
    </v-tooltip>
  </v-app-bar>
</template>

<script>
  import { sync, get, call } from 'vuex-pathify';
  import { store } from '@/store';

  export default {
    name: 'ModulesEditAppbar',

    props: {
      title: {
        type: [String],
        default: '',
      },
      icon: {
        type: [String],
        default: '',
      },
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('modulesManagement', ['ModulesEditSheet', 'componentEditDrawerActiveMenu']),
      ...get('modulesManagement', ['selectedModule', 'hasUnsavedChanges', 'hasValidationErrors']),
    },

    methods: {
      ...call('modulesManagement/*'),
      ...call('snackbar/*'),

      validateBeforeSave(selectedModule) {
        if (!this.hasValidationErrors) {
          this.saveComponent(selectedModule);
        } else {
          this.snackbarError('There are input validation errors');
        }
      },

      validateBeforeHide() {
        if (!this.hasValidationErrors) {
          this.ModulesEditSheet = false;
          this.$router.push('/Modules');
        } else {
          store.set('snackbar/value', true);
          this.snackbarError('There are input validation errors');
        }
      },
    },
  };
</script>
<style scoped>
  .darkBorder {
    border-bottom: solid 1px #404859;
  }
</style>
