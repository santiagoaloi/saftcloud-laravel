<template>
  <v-app-bar :class="{ darkBorder: isDark }" :flat="isDark" height="80">
    <v-icon dark class="mr-4"> mdi-pencil </v-icon>

    <h4 class="white--text">Editing</h4>
    <h4 class="ml-2 white--text">
      <template v-if="selectedComponent.config.general_config.title">
        {{ selectedComponent.config.general_config.title }}
      </template>
      <template v-else>
        <base-typing-indicator />
      </template>
    </h4>

    <v-spacer />

    <v-fade-transition>
      <div v-if="hasUnsavedChanges(selectedComponent)">
        <v-btn
          large
          rounded
          :color="isDark ? 'grey darken-2' : 'white'"
          class="mx-2"
          @click="rollbackChanges(selectedComponent)"
        >
          <span> Rollback changes</span>
        </v-btn>
      </div>
    </v-fade-transition>

    <v-tooltip transition="false" color="black" bottom>
      <template #activator="{ on }">
        <v-btn
          color="green lighten-2"
          class="mr-2"
          x-small
          text
          fab
          v-on="on"
          @click="validateBeforeSave(selectedComponent)"
        >
          <v-icon> mdi-check </v-icon>
        </v-btn>
      </template>
      <span>Save changes</span>
    </v-tooltip>

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
        <v-btn
          :to="`/${selectedComponent.name}`"
          fab
          class="mx-2"
          color="white"
          text
          x-small
          v-on="on"
        >
          <v-icon> mdi-link </v-icon>
        </v-btn>
      </template>
      <span>Open</span>
    </v-tooltip>

    <v-tooltip transition="false" color="black" bottom>
      <template #activator="{ on }">
        <v-btn
          dark
          :disabled="previousComponentDisabled"
          class="mr-2"
          fab
          text
          x-small
          v-on="on"
          @click="validateBeforePrevious()"
        >
          <v-icon>mdi-chevron-left</v-icon>
        </v-btn>
      </template>
      <span>Previous component</span>
    </v-tooltip>

    <v-tooltip transition="false" color="black" bottom>
      <template #activator="{ on }">
        <v-btn
          dark
          :disabled="nextComponentDisabled"
          fab
          text
          x-small
          v-on="on"
          @click="validateBeforeNext()"
        >
          <v-icon>mdi-chevron-right</v-icon>
        </v-btn>
      </template>
      <span>Next component</span>
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
    name: 'ComponentsEditAppbar',
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['componentEditSheet', 'componentEditDrawerActiveMenu']),
      ...get('componentManagement', [
        'previousComponentDisabled',
        'nextComponentDisabled',
        'selectedComponent',
        'hasUnsavedChanges',
        'hasValidationErrors',
      ]),
    },

    methods: {
      ...call('componentManagement/*'),

      validateBeforeSave(selectedComponent) {
        if (!this.hasValidationErrors) {
          this.saveComponent(selectedComponent);
        } else {
          store.set('snackbar/value', true);
          store.set(
            'snackbar/text',
            'There are input validation errors, check them out and try again',
          );
          store.set('snackbar/color', 'pink darken-1');
        }
      },

      validateBeforePrevious() {
        if (!this.hasValidationErrors) {
          this.previousComponent();
        } else {
          store.set('snackbar/value', true);
          store.set(
            'snackbar/text',
            'There are input validation errors, check them out and try again',
          );
          store.set('snackbar/color', 'pink darken-1');
        }
      },

      validateBeforeNext() {
        if (!this.hasValidationErrors) {
          this.nextComponent();
        } else {
          store.set('snackbar/value', true);
          store.set(
            'snackbar/text',
            'There are input validation errors, check them out and try again',
          );
          store.set('snackbar/color', 'pink darken-1');
        }
      },

      validateBeforeHide() {
        if (!this.hasValidationErrors) {
          this.componentEditSheet = false;
        } else {
          store.set('snackbar/value', true);
          store.set(
            'snackbar/text',
            'There are input validation errors, check them out and try again',
          );
          store.set('snackbar/color', 'pink darken-1');
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
