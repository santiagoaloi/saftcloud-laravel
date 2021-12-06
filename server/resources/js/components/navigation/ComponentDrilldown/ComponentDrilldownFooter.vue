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
          :to="`/${selectedComponent.name}`"
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
          @click.stop="
            removeComponentWarning(selectedComponent.id, 'delete', 'component', selectedComponent.config.general_config.title)
          "
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
          :disabled="!hasUnsavedChanges(selectedComponent)"
          depressed
          large
          small
          :color="isDark ? '' : 'white'"
          :loading="loading"
          @click="save()"
          v-on="on"
        >
          <v-icon color="green" dark>
            {{ hasUnsavedChanges(selectedComponent) ? 'mdi-check' : 'mdi-check-all' }}
          </v-icon>
        </v-btn>
      </template>
      <span>Save</span>
    </v-tooltip>
  </v-sheet>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';
  import componentActions from '@/mixins/componentActions';

  export default {
    name: 'ComponentDrilldownFooter',
    mixins: [componentActions],

    data() {
      return {
        loading: false,
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['componentEditSheet']),
      ...get('componentManagement', ['selectedComponent', 'hasUnsavedChanges', 'hasValidationErrors']),
    },

    methods: {
      ...call('componentManagement', ['saveComponent']),
      ...call('snackbar/*'),

      async save() {
        this.loading = true;

        if (!this.hasValidationErrors) {
          try {
            const saved = await this.saveComponent(this.selectedComponent);

            if (saved) {
              this.loading = false;
              this.snackbarSuccess('Component saved');
            } else {
              this.loading = false;
              this.snackbarError('There was an error saving');
            }
          } catch (error) {
            this.snackbarError('There was an error saving');
          }
        } else {
          this.loading = false;
          this.snackbarError('The component label is invalid');
        }
      },

      edit() {
        if (!this.hasValidationErrors) {
          this.componentEditSheet = true;
        } else {
          this.snackbarError('The component label is invalid');
        }
      },
    },
  };
</script>
