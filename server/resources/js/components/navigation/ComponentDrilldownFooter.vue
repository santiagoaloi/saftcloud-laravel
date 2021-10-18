<template>
  <div v-if="selectedComponent" class="mt-3">
    <div class="text-end pr-3 pb-2">
      <v-tooltip transition="false" color="black" top>
        <template #activator="{ on }">
          <v-btn
            depressed
            dark
            large
            small
            :color="isDark ? '' : 'white'"
            @click="edit()"
            v-on="on"
          >
            <v-icon color="#208ad6" dark> mdi-pencil-outline </v-icon>
          </v-btn>
        </template>
        <span>Edit</span>
      </v-tooltip>

      <v-tooltip transition="false" color="black" top>
        <template #activator="{ on }">
          <v-btn
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
            depressed
            dark
            large
            small
            :color="isDark ? '' : 'white'"
            v-on="on"
            @click.stop="
              removeComponentWarning(
                selectedComponent.id,
                'delete',
                'component',
                selectedComponent.config.general_config.title,
              )
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
    </div>
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';
  import { store } from '@/store';
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
      ...get('componentManagement', [
        'selectedComponent',
        'hasUnsavedChanges',
        'hasValidationErrors',
      ]),
    },

    methods: {
      ...call('componentManagement/*'),

      async save() {
        this.loading = true;

        if (!this.hasValidationErrors) {
          try {
            const saved = await this.saveComponent(this.selectedComponent);

            if (saved) {
              this.loading = false;
            } else {
              this.loading = false;
              store.set('snackbar/value', true);
              store.set('snackbar/text', 'The component name is invalid.');
              store.set('snackbar/color', 'pink darken-1');
            }
          } catch (error) {
            console.log(error);
          }
        } else {
          this.loading = false;
        }
      },

      edit() {
        if (!this.hasValidationErrors) {
          this.componentEditSheet = !this.componentEditSheet;
        } else {
          store.set('snackbar/value', true);
          store.set('snackbar/text', 'The component name is invalid.');
          store.set('snackbar/color', 'pink darken-1');
        }
      },
    },
  };
</script>
