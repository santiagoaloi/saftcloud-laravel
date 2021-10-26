<template>
  <div v-if="selectedEntity" class="mt-3">
    <div class="text-end pr-3 pb-2">
      <v-tooltip v-if="selectedEntityType === 'Users'" transition="false" color="black" top>
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
            depressed
            dark
            large
            small
            :color="isDark ? '' : 'white'"
            :disabled="['Root', 'Admin'].includes(selectedEntity.name)"
            v-on="on"
            @click.stop="removeUserWarning(selectedEntity.id, selectedEntity.entity.first_name)"
          >
            <v-icon color="pink lighten-1" dark> mdi-trash-can-outline </v-icon>
          </v-btn>
        </template>
        <span>Delete</span>
      </v-tooltip>

      <v-tooltip transition="false" color="black" top>
        <template #activator="{ on }">
          <v-btn
            depressed
            :disabled="!hasUnsavedChanges(selectedEntity)"
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
  import { isEqual } from 'lodash';
  import entitiesActions from '@/mixins/entitiesActions';

  export default {
    name: 'ComponentDrilldownFooter',
    mixins: [entitiesActions],
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
        'entitiesEditSheet',
      ]),
      ...sync('entitiesManagement', ['entitiesEditSheet']),

      identityMethod() {
        return this.selectedEntityType === 'Users' ? 'saveEntityUser' : 'saveEntityRole';
      },
    },

    methods: {
      ...call('entitiesManagement/*'),
      ...call('snackbar/*'),

      save() {
        this[this.identityMethod]();
      },

      async saveEntityUser() {
        this.loading = true;

        const functionGroups = [];

        if (!isEqual(this.selectedEntity.role, this.selectedEntity.origin.role)) {
          functionGroups.push(this.saveUserRoles());
        }

        if (!isEqual(this.selectedEntity.entity, this.selectedEntity.origin.entity)) {
          functionGroups.push(this.saveUserMetadata());
        }

        if (!isEqual(this.selectedEntity.email, this.selectedEntity.origin.email)) {
          functionGroups.push(this.saveUserMetadata());
        }

        try {
          await Promise.all(functionGroups);
          // const data = res.map((res) => res.data);
          this.snackbarSuccess('Your changes are saved...');
          this.getUserAndReplace();
          this.loading = false;
        } catch {
          this.loading = false;
        }
      },

      async saveEntityRole() {
        this.loading = true;

        if (!this.hasValidationErrors) {
          try {
            const saved = await this.saveRole();

            if (saved) {
              this.getUsers();
              this.snackbarSuccess('Your changes are saved...');
              this.loading = false;
            } else {
              this.loading = false;
            }
          } catch (error) {
            this.loading = false;
          }
        } else {
          this.loading = false;
          this.snackbarError('There are validation errors');
        }
      },

      edit() {
        if (!this.hasValidationErrors) {
          this.entitiesEditSheet = !this.entitiesEditSheet;
        } else {
          this.snackbarError('There are validation errors');
        }
      },
    },
  };
</script>
