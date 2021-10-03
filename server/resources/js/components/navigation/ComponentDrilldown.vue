<template>
  <div v-if="selectedComponent">
    <v-expand-transition>
      <v-sheet
        v-if="hasUnsavedChanges(selectedComponent)"
        :color="isDark ? '#2C2F33' : 'transparent'"
        class="px-2"
      >
        <v-alert class="mt-3" elevation="1" colored-border color="pink" border="right" dense>
          <div class="d-flex justify-space-between align-center">
            Unsaved
            <v-btn dark small @click="rollbackChanges(selectedComponent)"> rollback </v-btn>
          </div>
        </v-alert>
      </v-sheet>
    </v-expand-transition>

    <div class="text-end pr-3 pt-2">
      <v-tooltip transition="false" color="black" bottom>
        <template #activator="{ on }">
          <v-btn
            depressed
            dark
            large
            small
            :color="isDark ? '' : 'white'"
            @click="validateBeforeEdit()"
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
            @click="validateBeforeSave(selectedComponent)"
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

    <v-card-title> Edit Component View </v-card-title>

    <v-card-subtitle>
      Edit your module quickly, change group, component name, description, enable sidebar visibility
      and more...
    </v-card-subtitle>

    <ValidationObserver ref="componentDrilldown" slim>
      <v-container>
        <baseFieldLabel required label="Component name" />
        <validation-provider
          v-slot="{ errors }"
          immediate
          mode="aggressive"
          name="component name"
          rules="required"
        >
          <v-text-field
            v-model="selectedComponent.config.general_config.title"
            v-lazy-input:debounce="100"
            outlined
            :color="isDark ? '#208ad6' : 'grey'"
            :background-color="isDark ? '#28292b' : 'white'"
            :prepend-inner-icon="selectedComponent.config_settings.icon.name"
            spellcheck="false"
            flat
            solo
            :error-messages="errors[0]"
            :error="errors.length > 0"
            hide-details="auto"
            class="mb-3"
            dense
          >
            <template #append>
              <v-tooltip transition="false" color="black" bottom>
                <template #activator="{ on }">
                  <v-btn
                    small
                    icon
                    :ripple="false"
                    v-on="on"
                    @click="setStarred(selectedComponent)"
                  >
                    <v-icon :color="isStarredColor(selectedComponent)">
                      {{ isStarredIcon(selectedComponent) }}
                    </v-icon>
                  </v-btn>
                </template>
                <span>Favourite</span>
              </v-tooltip>
            </template>
          </v-text-field>
        </validation-provider>

        <baseFieldLabel label="Description / Notes" />
        <v-textarea
          v-model="selectedComponent.config.general_config.note"
          v-lazy-input:debounce="100"
          outlined
          :color="isDark ? '#208ad6' : 'grey'"
          :background-color="isDark ? '#28292b' : 'white'"
          spellcheck="false"
          :rows="2"
          dense
          hide-details
          class="mb-3"
        />

        <div class="mt-2">
          <baseFieldLabel required label="Component group " />
          <v-autocomplete
            v-model="selectedComponent.component_group_id"
            outlined
            :color="isDark ? '#208ad6' : 'grey'"
            item-color="indigo lighten-4"
            :background-color="isDark ? '#28292b' : 'white'"
            :items="allGroups"
            :maxlength="25"
            item-value="id"
            item-text="name"
            hide-no-data
            dense
          />
        </div>
      </v-container>
    </ValidationObserver>

    <div class="mt-2">
      <v-list-item two-line>
        <v-list-item-icon>
          <v-switch
            v-model="selectedComponent.config.general_config.isVisibleInSidebar"
            :ripple="false"
            hide-details
            class="mt-2"
          />
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>Sidebar</v-list-item-title>
          <v-list-item-subtitle> Display in navigation drawer </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
    </div>

    <v-divider />

    <v-list subheader>
      <v-subheader>Database</v-subheader>
      <v-list-item>
        <v-list-item-icon>
          <v-icon> mdi-table </v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>
            {{ selectedComponent.config.general_config.sql_table }}</v-list-item-title
          >
          <v-list-item-subtitle>Table</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-list-item>
        <v-list-item-icon>
          <v-icon> mdi-table-row </v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>{{ selectedComponent.config.columns.length }}</v-list-item-title>
          <v-list-item-subtitle> Table columns</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider />

      <v-list-item>
        <v-list-item-icon>
          <v-icon> mdi-calendar-plus </v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>Created</v-list-item-title>
          <v-list-item-subtitle>
            {{ selectedComponent.created_at | momentDate }}
          </v-list-item-subtitle>
          <v-list-item-subtitle>
            {{ selectedComponent.created_at | momentDateAgo }}</v-list-item-subtitle
          >
        </v-list-item-content>
      </v-list-item>

      <v-list-item>
        <v-list-item-icon>
          <v-icon> mdi-calendar-edit </v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>Edited</v-list-item-title>
          <v-list-item-subtitle>
            {{ selectedComponent.updated_at | momentDate }}
          </v-list-item-subtitle>
          <v-list-item-subtitle
            >{{ selectedComponent.updated_at | momentDateAgo }}
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider />
    </v-list>
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';
  import { store } from '@/store';
  import componentActions from '@/mixins/componentActions';

  export default {
    name: 'ComponentDrilldown',
    mixins: [componentActions],

    computed: {
      ...sync('theme', ['isDark']),
      ...get('componentManagement', [
        'hasUnsavedChanges',
        'previousComponentDisabled',
        'nextComponentDisabled',
        'selectedComponent',
        'isAllFilteredComponentsEmpty',
        'isStarredColor',
        'isStarredIcon',
      ]),
      ...sync('componentManagement', [
        'componentCardGroup',
        'allComponents',
        'allGroups',
        'selectedComponentIndex',
        'componentEditSheet',
      ]),
    },

    methods: {
      ...call('componentManagement/*'),

      validateBeforeSave(selectedComponent) {
        this.$refs.componentDrilldown.validate().then((success) => {
          if (success) {
            this.saveComponent(selectedComponent);
          } else {
            store.set('snackbar/value', true);
            store.set(
              'snackbar/text',
              'There are input validation errors, check them out before saving',
            );
            store.set('snackbar/color', 'pink darken-1');
          }
        });
      },

      validateBeforeEdit() {
        this.$refs.componentDrilldown.validate().then((success) => {
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
