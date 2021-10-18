<template>
  <div v-if="selectedEntity" class="mt-3">
    <div class="text-end pr-3 pb-2">
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
                selectedEntity.id,
                'delete',
                'component',
                selectedEntity.config.general_config.title,
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
            :disabled="!hasUnsavedChanges(selectedEntity)"
            depressed
            large
            small
            :color="isDark ? '' : 'white'"
            :loading="loading"
            @click="save()"
            v-on="on"
          >
            <v-icon color="green" dark>
              {{ hasUnsavedChanges(selectedEntity) ? 'mdi-check' : 'mdi-check-all' }}
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
      ...get('entitiesManagement', [
        'selectedEntity',
        'hasUnsavedChanges',
        'hasValidationErrors',
        'selectedEntityType',
      ]),

      identityMethod() {
        return this.selectedEntityType === 'Users' ? 'saveEntityUser' : 'saveEntityRole';
      },
    },

    methods: {
      ...call('entitiesManagement/*'),

      async save() {
        this.loading = true;

        if (!this.hasValidationErrors) {
          try {
            const saved = await this[this.identityMethod];

            if (saved) {
              store.set('snackbar/value', true);
              store.set('snackbar/text', 'Saved.');
              store.set('snackbar/color', 'primary');
              this.loading = false;
            } else {
              this.loading = false;
              store.set('snackbar/value', true);
              store.set('snackbar/text', 'There was an error saving');
              store.set('snackbar/color', 'pink darken-1');
            }
          } catch (error) {
            this.loading = false;
            store.set('snackbar/value', true);
            store.set('snackbar/text', 'There was an error saving');
            store.set('snackbar/color', 'pink darken-1');
          }
        } else {
          this.loading = false;
        }
      },
    },
  };
</script>
