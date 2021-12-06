<template>
  <v-app-bar flat src="storage/appbar/prism2.jpg">
    <v-icon dark class="mr-4"> {{ icon }} </v-icon>

    <h4 v-if="title" class="ml-2 white--text">Editing {{ title }}</h4>
    <base-typing-indicator v-else />

    <v-spacer />

    <v-fade-transition>
      <div v-if="hasUnsavedChanges(selectedComponent)">
        <v-btn large rounded :color="isDark ? 'grey darken-2' : 'white'" class="mx-2" @click="rollbackChanges(selectedComponent)">
          <span> Rollback changes</span>
        </v-btn>
      </div>
    </v-fade-transition>

    <v-tooltip transition="false" color="black" bottom>
      <template #activator="{ on }">
        <v-btn color="green lighten-2" class="mr-2" x-small text fab v-on="on" @click="validateBeforeSave(selectedComponent)">
          <v-icon> mdi-check </v-icon>
        </v-btn>
      </template>
      <span>Save changes</span>
    </v-tooltip>

    <v-divider inset vertical class="mx-3 grey" />

    <v-tooltip transition="false" color="black" bottom>
      <template #activator="{ on }">
        <v-btn :to="`/${selectedComponent.name}`" fab class="mx-2" color="white" text x-small v-on="on">
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
        <v-btn dark :disabled="nextComponentDisabled" fab text x-small v-on="on" @click="validateBeforeNext()">
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

    props: {
      title: {
        type: [String],
        default: '',
      },
      icon: {
        type: [String],
        default: '',
      },
    },

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
          this.previousComponent();
        } else {
          this.snackbarError('There are input validation errors');
        }
      },

      validateBeforeNext() {
        if (!this.hasValidationErrors) {
          this.nextComponent();
        } else {
          this.snackbarError('There are input validation errors');
        }
      },

      validateBeforeHide() {
        if (!this.hasValidationErrors) {
          this.componentEditSheet = false;
          this.$router.push('/Components');
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
