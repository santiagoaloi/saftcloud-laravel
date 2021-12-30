<template>
  <v-sheet tile class="text-center pa-2 transparent select-none">
    <v-tooltip transition="false" color="black" top>
      <template #activator="{ on }">
        <v-btn :ripple="false" depressed dark large small :color="isDark ? '' : 'white'" @click="edit()" v-on="on">
          <v-icon color="#208ad6" dark> mdi-pencil-outline </v-icon>
        </v-btn>
      </template>
      <span>Edit</span>
    </v-tooltip>

    <v-tooltip transition="false" color="black" top>
      <template #activator="{ on }">
        <v-btn
          :ripple="false"
          :to="`/${selectedModule.name}`"
          depressed
          dark
          large
          small
          :color="isDark ? '' : 'white'"
          v-on="on"
        >
          <v-icon :color="isDark ? '' : 'black'" dark> mdi-link </v-icon>
        </v-btn>
      </template>
      <span>Open</span>
    </v-tooltip>

    <v-tooltip transition="false" color="black" top>
      <template #activator="{ on }">
        <v-btn
          :ripple="false"
          depressed
          dark
          large
          small
          :color="isDark ? '' : 'white'"
          v-on="on"
          @click.stop="removeModuleWarning(selectedModule.id, 'delete', 'module', selectedModule.config.general_config.title)"
        >
          <v-icon color="pink lighten-1" dark> mdi-trash-can-outline </v-icon>
        </v-btn>
      </template>
      <span>Delete</span>
    </v-tooltip>

    <v-tooltip transition="false" color="black" top>
      <template #activator="{ on }">
        <v-btn
          :ripple="false"
          :disabled="!hasUnsavedChanges(selectedModule)"
          depressed
          large
          small
          :color="isDark ? '' : 'white'"
          :loading="loading"
          @click="save()"
          v-on="on"
        >
          <v-icon color="green" dark>
            {{ hasUnsavedChanges(selectedModule) ? 'mdi-check' : 'mdi-check-all' }}
          </v-icon>
        </v-btn>
      </template>
      <span>Save</span>
    </v-tooltip>
  </v-sheet>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';
  import modulesActions from '@/mixins/modulesActions';

  export default {
    name: 'ModulesDrilldownFooter',
    mixins: [modulesActions],

    data() {
      return {
        loading: false,
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('modulesManagement', ['modulesEditSheet']),
      ...get('modulesManagement', ['selectedModule', 'hasUnsavedChanges', 'hasValidationErrors']),
    },

    methods: {
      ...call('modulesManagement', ['saveModule']),
      ...call('snackbar/*'),

      async save() {
        this.loading = true;

        if (!this.hasValidationErrors) {
          try {
            const saved = await this.saveModule(this.selectedModule);

            if (saved) {
              this.loading = false;
              this.snackbarSuccess('Module saved');
            } else {
              this.loading = false;
              this.snackbarError('There was an error saving');
            }
          } catch (error) {
            this.snackbarError('There was an error saving');
          }
        } else {
          this.loading = false;
          this.snackbarError('The module label is invalid');
        }
      },

      edit() {
        if (!this.hasValidationErrors) {
          this.modulesEditSheet = true;
        } else {
          this.snackbarError('The module label is invalid');
        }
      },
    },
  };
</script>
