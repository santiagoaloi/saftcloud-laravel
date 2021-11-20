<template>
  <v-app-bar :class="{ darkBorder: isDark }" :flat="isDark" src="storage/appbar/prism2.jpg">
    <v-icon dark class="mr-4"> mdi-pencil </v-icon>

    <h4 class="white--text">Editing</h4>
    <h4 class="ml-2 white--text">
      <template v-if="selectedEntity.entity.first_name">
        {{ selectedEntity.entity.first_name }}
      </template>
      <template v-else>
        <base-typing-indicator />
      </template>
    </h4>

    <v-spacer />
    <!-- 
    <v-fade-transition>
      <div v-if="hasUnsavedChanges(selectedEntity)">
        <v-btn
          large
          rounded
          :color="isDark ? 'grey darken-2' : 'white'"
          class="mx-2"
          @click="rollbackChanges({ selectedEntity, selectedEntityType })"
        >
          <span> Rollback changes</span>
        </v-btn>
      </div>
    </v-fade-transition> -->

    <!-- <v-tooltip transition="false" color="black" bottom>
      <template #activator="{ on }">
        <v-btn
          color="green lighten-2"
          class="mr-2"
          x-small
          text
          fab
          v-on="on"
          @click="validateBeforeSave(selectedEntity)"
        >
          <v-icon> mdi-check </v-icon>
        </v-btn>
      </template>
      <span>Save changes</span>
    </v-tooltip> -->

    <v-tooltip transition="false" color="black" bottom>
      <template #activator="{ on }">
        <v-btn fab class="mx-2" color="white" text x-small v-on="on" @click="isDark = !isDark">
          <v-icon v-if="isDark"> mdi-lightbulb-on-outline </v-icon>
          <v-icon v-else> mdi-lightbulb-outline </v-icon>
        </v-btn>
      </template>
      <span> {{ isDark ? ' Light mode' : 'Dark mode' }}</span>
    </v-tooltip>

    <v-divider inset vertical class="mx-3 grey" />

    <v-tooltip transition="false" color="black" bottom>
      <template #activator="{ on }">
        <v-btn dark :disabled="previousEntityDisabled" class="mr-2" fab text x-small v-on="on" @click="validateBeforePrevious()">
          <v-icon>mdi-chevron-left</v-icon>
        </v-btn>
      </template>
      <span>Previous user</span>
    </v-tooltip>

    <v-tooltip transition="false" color="black" bottom>
      <template #activator="{ on }">
        <v-btn dark :disabled="nextEntityDisabled" fab text x-small v-on="on" @click="validateBeforeNext()">
          <v-icon>mdi-chevron-right</v-icon>
        </v-btn>
      </template>
      <span>Next user</span>
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
    name: 'EntitiesEditAppbar',
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('entitiesManagement', ['entitiesEditSheet', 'entitiesEditDrawerActiveMenu']),
      ...get('entitiesManagement', [
        'previousEntityDisabled',
        'nextEntityDisabled',
        'selectedEntity',
        'hasUnsavedChanges',
        'hasValidationErrors',
        'selectedEntityType',
      ]),
    },

    methods: {
      ...call('entitiesManagement/*'),
      ...call('snackbar/*'),

      validateBeforeSave(selectedComponent) {
        if (!this.hasValidationErrors) {
          this.saveComponent(selectedComponent);
        } else {
          this.snackbarError('There are input validation errors');
        }
      },

      validateBeforePrevious() {
        if (!this.hasValidationErrors) {
          this.previousEntity();
        } else {
          this.snackbarError('There are input validation errors');
        }
      },

      validateBeforeNext() {
        if (!this.hasValidationErrors) {
          this.nextEntity();
        } else {
          this.snackbarError('There are input validation errors');
        }
      },

      validateBeforeHide() {
        if (!this.hasValidationErrors) {
          this.entitiesEditSheet = false;
          this.$router.push('/Entities');
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
