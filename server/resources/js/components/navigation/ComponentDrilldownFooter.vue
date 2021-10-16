<template>
  <div v-if="selectedComponent" class="mt-3">
    <div class="text-end pr-3 pb-2">
      <v-tooltip transition="false" color="black" bottom>
        <template #activator="{ on }">
          <v-btn
            depressed
            dark
            large
            small
            :color="isDark ? '' : 'white'"
            @click="validateBeforeContinue()"
            v-on="on"
          >
            <v-icon color="#208ad6" dark> mdi-pencil-outline </v-icon>
          </v-btn>
        </template>
        <span>Edit</span>
      </v-tooltip>

      <v-tooltip transition="false" color="black" bottom>
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

      <v-tooltip transition="false" color="black" bottom>
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

      <v-tooltip transition="false" color="black" bottom>
        <template #activator="{ on }">
          <v-btn
            :disabled="!hasUnsavedChanges(selectedComponent)"
            depressed
            large
            small
            :color="isDark ? '' : 'white'"
            @click="validateBeforeContinue(selectedComponent)"
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

  export default {
    name: 'ComponentDrilldownFooter',
    computed: {
      ...sync('theme', ['isDark']),
      ...get('componentManagement', [
        'selectedComponent',
        'hasUnsavedChanges',
        'componentEditSheet',
      ]),
    },

    methods: {
      ...call('componentManagement/*'),

      validateBeforeContinue() {
        const refs = this.$parent.$children.find(
          (child) => child.$options._componentTag === 'component-drilldown',
        );

        refs.componentDrilldown.validate().then((success) => {
          if (success) {
            this.componentEditSheet = !this.componentEditSheet;
          } else {
            store.set('snackbar/value', true);
            store.set(
              'snackbar/text',
              'There are input validation errors, check them out before editing',
            );
            store.set('snackbar/color', 'pink darken-1');
          }
        });
      },
    },
  };
</script>
