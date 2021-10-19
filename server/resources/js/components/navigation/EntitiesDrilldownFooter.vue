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
            :disabled="['Root', 'Admin'].includes(selectedEntity.name)"
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

      <v-tooltip transition="false" color="black" top>
        <template #activator="{ on }">
          <v-btn
            depressed
            large
            small
            :color="isDark ? '' : 'white'"
            @click="testPromiseAll()"
            v-on="on"
          >
            <v-icon color="green" dark> mdi-link </v-icon>
          </v-btn>
        </template>
        <span>Save</span>
      </v-tooltip>
    </div>
  </div>
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
      ...call('snackbar/*'),

      async testPromiseAll() {
        try {
          const res = await Promise.all([this.test1(), this.test2(), this.test3()]);
          const data = res.map((res) => res.data);
          console.log(data.flat());
          console.log('finished');
        } catch {
          throw Error('Promise failed');
        }
      },

      async save() {
        this.loading = true;

        if (!this.hasValidationErrors) {
          try {
            const saved = await this[this.identityMethod]();

            if (saved) {
              this.snackbarSuccess('Your changes are saved...');
              this.loading = false;
            } else {
              this.loading = false;
              this.snackbarError('There was an error saving');
            }
          } catch (error) {
            this.loading = false;
            this.snackbarError('There was an error saving');
          }
        } else {
          this.loading = false;
          this.snackbarError('There are validation errors');
        }
      },
    },
  };
</script>
