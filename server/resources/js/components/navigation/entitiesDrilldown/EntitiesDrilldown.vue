<template>
  <div v-if="selectedEntity">
    <v-expand-transition>
      <v-sheet v-if="hasUnsavedChanges(selectedEntity)" :color="isDark ? '#2C2F33' : 'transparent'" class="px-2">
        <v-alert class="mt-3" elevation="1" colored-border color="pink" border="right" dense>
          <div class="d-flex justify-space-between align-center">
            Unsaved
            <v-btn dark small @click="rollbackChanges({ selectedEntity, selectedEntityType })"> rollback </v-btn>
          </div>
        </v-alert>
      </v-sheet>
    </v-expand-transition>

    <template v-if="selectedEntityType === 'Roles'">
      <v-card-title> Edit Role </v-card-title>

      <v-card-subtitle>
        Each application module has its own set of privileges that you can choose from to build your role in a more granular
        manner.
      </v-card-subtitle>
    </template>

    <template v-if="selectedEntityType === 'Users'">
      <v-card-title> Edit User account </v-card-title>

      <v-card-subtitle>
        Assign roles, enforce security policies, monitor activiy logs among other settings that applies to each invdividual user
        account.
      </v-card-subtitle>
    </template>

    <v-container>
      <template v-if="selectedEntityType === 'Roles'">
        <baseFieldLabel required label="Role Name" />
        <validation-provider v-slot="{ errors, invalid }" immediate mode="aggressive" name="Role name" rules="required">
          <v-text-field
            v-model="selectedEntity.name"
            v-lazy-input:debounce="100"
            outlined
            :color="isDark ? '#208ad6' : 'grey'"
            :background-color="isDark ? '#28292b' : 'white'"
            spellcheck="false"
            flat
            solo
            :error-messages="errors[0]"
            :error="errors.length > 0"
            hide-details="auto"
            class="mb-3"
            dense
            :disabled="['Root', 'Admin'].includes(selectedEntity.name)"
            @change="setInvalid(invalid, 'roleName')"
          >
          </v-text-field>
        </validation-provider>

        <baseFieldLabel label="Role Description" />
        <v-textarea
          v-model="selectedEntity.description"
          v-lazy-input:debounce="100"
          outlined
          :color="isDark ? '#208ad6' : 'grey'"
          :background-color="isDark ? '#28292b' : 'white'"
          spellcheck="false"
          :rows="2"
          dense
          class="mb-3"
          auto-grow
          :disabled="!$root.isRoot && ['Root', 'Admin'].includes(selectedEntity.name)"
        />

        <div class="mt-2">
          <baseFieldLabel class="mb-n3" label="Root role" />
          <v-list-item two-line>
            <v-list-item-icon>
              <v-switch hide-details class="mt-2" color="indigo lighten-2" />
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Enable admin access</v-list-item-title>
              <v-list-item-subtitle> Unlock all privileges </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </div>

        <div class="mt-2">
          <baseFieldLabel required label="Role Privileges " />
          <v-autocomplete
            v-model="selectedEntity.capability"
            outlined
            solo
            :color="isDark ? '#208ad6' : 'grey'"
            item-color="indigo lighten-4"
            :items="allCapabilities"
            :maxlength="25"
            item-value="id"
            item-text="name"
            hide-no-data
            hide-details
            multiple
            dense
            return-object
            attach
            :disabled="!$root.isRoot && ['Root', 'Admin'].includes(selectedEntity.name)"
          >
            <template #selection="data">
              <v-chip
                v-if="data.index === 0"
                :style="isDark ? 'color: white' : 'color:black'"
                :color="isDark ? 'grey-darken-4' : 'blue-white'"
                small
              >
                {{ selectedEntity.capability.length }} privileges selected.
              </v-chip>
            </template>

            <template #item="{ item, attrs }">
              <v-list-item-action>
                <v-icon>
                  {{ attrs.inputValue ? 'mdi-checkbox-marked' : 'mdi-checkbox-blank-outline' }}
                </v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  <b class="indigo--text text--lighten-3">{{ extractPrefix(item.name) }}</b
                  ><span class="blue--text text--lighten-3">{{ extractCapabilityName(item.name) }}</span>
                </v-list-item-title>
              </v-list-item-content>

              <v-tooltip v-if="item.description" transition="false" color="black" bottom max-width="250">
                <template #activator="{ on }">
                  <v-btn
                    plain
                    :ripple="false"
                    small
                    depressed
                    v-on="on"
                    @click.stop="removeGroupWarning(item.id, item.name, 'delete')"
                  >
                    <v-icon small> mdi-help-box </v-icon>
                  </v-btn>
                </template>
                <span>{{ item.description }}</span>
              </v-tooltip>
            </template>
          </v-autocomplete>
        </div>

        <div class="mt-2">
          <baseFieldLabel required label="Allow Modulel Navigation " />
          <v-autocomplete
            v-model="selectedEntity.modules"
            outlined
            :color="isDark ? '#208ad6' : 'grey'"
            item-color="indigo lighten-4"
            :items="allBranchModules"
            :maxlength="25"
            hide-no-data
            item-value="id"
            item-text="name"
            dense
            solo
            hide-details
            multiple
            :ripple="false"
            @click="getBranchModules()"
          />
        </div>
      </template>
    </v-container>

    <template v-if="selectedEntityType === 'Users'">
      <v-list subheader two-line>
        <v-subheader>Operations</v-subheader>

        <v-container class="text-end">
          <v-btn class="mr-2" color="red lighten-2">Disable</v-btn>
          <v-btn>Change password</v-btn>
        </v-container>
      </v-list>

      <div>
        <v-list-item>
          <v-list-item-icon>
            <v-avatar>
              <v-icon class="ml-n4 yellow--text text--lighten-3"> mdi-lock-open-alert-outline </v-icon>
            </v-avatar>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>This user account is locked</v-list-item-title>
            <v-list-item-subtitle>
              <h5>Unlock</h5>
            </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </div>

      <div class="mt-n5">
        <v-list-item>
          <v-list-item-icon>
            <v-avatar>
              <v-icon class="ml-n4 green--text text--lighten-3"> mdi-two-factor-authentication </v-icon>
            </v-avatar>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>Two factor authentication</v-list-item-title>
            <v-list-item-subtitle>
              <h5>Remove 2FA</h5>
            </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </div>

      <v-container>
        <v-list subheader two-line>
          <v-subheader>Assigned roles</v-subheader>

          <v-sheet elevation="4" rounded="xl">
            <div class="pa-4">
              <v-chip-group class="pointer-events-none" active-class="primary--text" column>
                <template v-if="selectedEntity.role.length">
                  <v-chip v-for="(role, i) in selectedEntity.role" :key="role + i" color="grey darken-4">
                    {{ role.name }}
                  </v-chip>
                </template>
                <template v-else>
                  <v-chip color="grey darken-4"> No Roles Assigned </v-chip>
                </template>
              </v-chip-group>
            </div>
          </v-sheet>
        </v-list>
      </v-container>
      <v-container class="text-end">
        <v-btn class="mr-2" :disabled="!selectedEntity.role.length" @click="dialogPrivileges = true">Show privilege list</v-btn>
        <v-btn color="primary" @click="dialogAssignRoles = true">Assign roles</v-btn>
      </v-container>
    </template>

    <v-divider />

    <v-list subheader two-line>
      <v-subheader>Metadata</v-subheader>

      <v-list-item>
        <v-list-item-icon>
          <v-icon> mdi-calendar-plus </v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>Created</v-list-item-title>
          <v-list-item-subtitle>
            {{ selectedEntity.created_at | momentDate }}
          </v-list-item-subtitle>
          <v-list-item-subtitle> {{ selectedEntity.created_at | momentDateAgo }}</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-list-item>
        <v-list-item-icon>
          <v-icon> mdi-calendar-edit </v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>Edited</v-list-item-title>
          <v-list-item-subtitle>
            {{ selectedEntity.updated_at | momentDate }}
          </v-list-item-subtitle>
          <v-list-item-subtitle>{{ selectedEntity.updated_at | momentDateAgo }} </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
    </v-list>

    <v-divider />
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';
  import modulesActions from '@/mixins/modulesActions';
  import { store } from '@/store';

  export default {
    name: 'EntitiesDrilldown',
    mixins: [modulesActions],

    computed: {
      ...sync('theme', ['isDark']),
      ...get('entitiesManagement', [
        'hasUnsavedChanges',
        'previousEntityDisabled',
        'nextEntityDisabled',
        'selectedEntity',
        'isAllFilteredEntitiesEmpty',
        'isStarredColor',
        'isStarredIcon',
        'allBranchModules',
      ]),
      ...sync('entitiesManagement', [
        'entityCardGroup',
        'selectedEntityIndex',
        'selectedEntityType',
        'allCapabilities',
        'dialogPrivileges',
        'dialogAssignRoles',
        'allBrachModules',
      ]),
    },

    // created() {
    //   this.getBrachModules();
    // },

    methods: {
      ...call('entitiesManagement/*'),

      setInvalid(invalid, field) {
        store.set(`validationStatesEntities/roles@${field}`, invalid);
      },

      extractPrefix(item) {
        const prefix = item.substr(0, item.indexOf('.'));
        return prefix;
      },

      extractCapabilityName(item) {
        const suffix = item.substr(item.indexOf('.'));
        return suffix;
      },
    },
  };
</script>
