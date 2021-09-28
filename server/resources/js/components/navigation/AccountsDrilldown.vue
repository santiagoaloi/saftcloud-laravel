<template>
  <div v-if="selectedEntity">
    <v-expand-transition>
      <v-sheet
        v-if="hasUnsavedChanges(selectedEntity)"
        :color="isDark ? '#2C2F33' : 'transparent'"
        class="px-2"
      >
        <v-alert
          class="mt-3"
          elevation="1"
          colored-border
          color="pink"
          border="right"
          dense
        >
          <div class="d-flex justify-space-between align-center">
            Unsaved
            <v-btn
              dark
              small
              @click="rollbackChanges(selectedEntity)"
            >
              rollback
            </v-btn>
          </div>
        </v-alert>
      </v-sheet>
    </v-expand-transition>

    <template v-if="selectedEntityType === 'Roles'">
   <v-card-title>
      Edit Role
    </v-card-title>

    <v-card-subtitle>
     Each application module has its own set of capabilities that you can chose to be part of this or not.
    </v-card-subtitle>

    </template>
  
      <template v-if="selectedEntityType === 'Accounts'">
   <v-card-title>
      Edit User account
    </v-card-title>

    <v-card-subtitle>
     Assign roles, enforce security policies, monitor activiy among other settings that applies to each invdividual user account.
    </v-card-subtitle>

    </template>
  
   

    <div class="text-end mb-3 mt-2">


      <v-tooltip
        transition="false"
        color="black"
        bottom
      >
        <template #activator="{ on }">
          <v-btn
            depressed
            dark
            large
            small
            :color="isDark ? '' : 'white'"
            v-on="on"
          >
            <v-icon
              color="pink lighten-1"
              dark
            >
              mdi-trash-can-outline
            </v-icon>
          </v-btn>
        </template>
        <span>Delete</span>
      </v-tooltip>

      <v-tooltip
        transition="false"
        color="black"
        bottom
      >
        <template #activator="{ on }">
          <v-btn
            :disabled="!hasUnsavedChanges(selectedEntity)"
            depressed
            large
            small
            :color="isDark ? '' : 'white'"
            v-on="on"
          >
            <v-icon
              color="green"
              dark
            >
              {{ hasUnsavedChanges(selectedEntity) ? "mdi-check" : "mdi-check-all" }}
            </v-icon>
          </v-btn>
        </template>
        <span>Save</span>
      </v-tooltip>
    </div>

  <v-container>

    <template v-if="selectedEntityType === 'Roles'">

  <div class="mt-2">
            <baseFieldLabel
              class="mb-n3"
              label="Root account"
            />
            <v-list-item two-line>
              <v-list-item-icon>
                <v-switch
                  hide-details
                  class="mt-2"
                  color="indigo lighten-2"
                />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>Enable root access</v-list-item-title>
                <v-list-item-subtitle>
                  Unlock all capabilities 
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </div>







 <div class="mt-2">
            <baseFieldLabel
              required
              label="Role Capabilities "
            />
            <v-autocomplete
            v-model="selectedCapabilities"
              outlined
              :color="isDark ? '#208ad6' : 'grey'"
              item-color="indigo lighten-4"
              :background-color="isDark ? '#28292b' : 'white'"
              :items="allCapabilities"
              :maxlength="25"
              item-value="id"
              item-text="name"
              hide-no-data
              hide-details
              multiple
            >

                      <template #selection="data">
            <v-chip
              v-if="data.index === 0"
              
              :style="isDark ? 'color: white' : 'color:black'"
              :color="isDark ? 'grey-darken-4' : 'blue-white'"
            >
              {{ selectedCapabilities.length }} capabilities selected.
            </v-chip>
          </template>
            </v-autocomplete>
          </div>
    </template>

  </v-container>


    <template v-if="selectedEntityType === 'Accounts'">

      
            <div class="mt-n5">
         
            <v-list-item >
              <v-list-item-icon>
                <v-avatar >
                     <v-icon class="ml-n4 yellow--text text--lighten-3">
                mdi-lock-open-alert-outline
              </v-icon>
                  </v-avatar>
           
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>This accout is locked</v-list-item-title>
                <v-list-item-subtitle>
                  <h5>Unlock user account </h5>
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </div>

    <div class="mt-2">
      <v-list-item two-line>
        <v-list-item-icon>
          <v-switch
            :ripple="false"
            hide-details
            class="mt-2"
          />
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>Enable user account</v-list-item-title>
          <v-list-item-subtitle>
           This account is disabled
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
    </div>
    </template>


    <v-divider />

    <v-list
      subheader
      two-line
    >
      <v-subheader>Database</v-subheader>



      <v-list-item>
        <v-list-item-icon>
          <v-icon>
            mdi-calendar-plus
          </v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>Created</v-list-item-title>
          <v-list-item-subtitle> {{ selectedEntity.created_at | momentDate }} </v-list-item-subtitle>
          <v-list-item-subtitle> {{ selectedEntity.created_at | momentDateAgo }}</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-list-item>
        <v-list-item-icon>
          <v-icon>
            mdi-calendar-edit
          </v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>Edited</v-list-item-title>
          <v-list-item-subtitle> {{ selectedEntity.updated_at | momentDate }} </v-list-item-subtitle>
          <v-list-item-subtitle>{{ selectedEntity.updated_at | momentDateAgo }} </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider />
    </v-list>
  </div>
</template>

<script>
import isEqual from 'lodash/isEqual';
import { sync, call, get } from 'vuex-pathify';
import { store } from '@/store';
import componentActions from '@/mixins/componentActions';

export default {
  name: 'ComponentDrilldown',
  mixins: [componentActions],

  data() {
    return {
      selectedCapabilities: []
    }
  },

  computed: {
    ...sync('theme', ['isDark']),
    ...get('accountsManagement', [
      'hasUnsavedChanges',
      'previousEntityDisabled',
      'nextEntityDisabled',
      'selectedEntity',
      'isAllFilteredEntitiesEmpty',
      'isStarredColor',
      'isStarredIcon',
    ]),
    ...sync('accountsManagement', ['entityCardGroup',  'selectedEntityIndex',  'selectedEntityType', 'allCapabilities']),
  },

  methods: {
    ...call('accountsManagement/*'),



  },
};
</script>
