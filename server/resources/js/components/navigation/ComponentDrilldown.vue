<template>
  <div>
    <v-expand-transition>
      <v-sheet v-if="hasUnsavedChanges(selectedComponent)" color="transparent" class="px-2">
        <v-alert class="mt-3" elevation="1" colored-border color="pink" border="right" dense>
          <div class="d-flex justify-space-between align-center">
            Unsaved
            <v-btn dark small @click="rollbackChanges(selectedComponent)"> rollback </v-btn>
          </div>
        </v-alert>
      </v-sheet>
    </v-expand-transition>

    <v-card-title> Edit Component View </v-card-title>

    <v-card-subtitle>
      Edit your module quickly, change group, component label, description, enable sidebar
      visibility and more...
    </v-card-subtitle>

    <ValidationObserver ref="componentDrilldownFormValidation" slim>
      <v-container>
        <baseFieldLabel required label="Component label" />
        <validation-provider
          v-slot="{ errors, invalid }"
          immediate
          mode="aggressive"
          name="component label"
          rules="required"
        >
          <v-text-field
            v-model="selectedComponent.config.general_config.title"
            v-lazy-input:debounce="100"
            outlined
            :color="isDark ? '#208ad6' : 'grey'"
            :prepend-inner-icon="selectedComponent.config_settings.icon.name"
            spellcheck="false"
            flat
            solo
            :error-messages="errors[0]"
            :error="errors.length > 0"
            hide-details="auto"
            class="mb-3"
            dense
            @change="setInvalid(invalid, 'componentName')"
          >
            <template #append>
              <v-tooltip transition="false" color="black" bottom>
                <template #activator="{ on }">
                  <v-btn
                    small
                    icon
                    :ripple="false"
                    v-on="on"
                    @click.stop="setStarred(selectedComponent)"
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
          spellcheck="false"
          :rows="2"
          dense
          hide-details
          class="mb-3"
          solo
        />

        <div class="mt-2">
          <baseFieldLabel required label="Component group " />
          <v-autocomplete
            v-model="selectedComponent.component_group_id"
            outlined
            :color="isDark ? '#208ad6' : 'grey'"
            item-color="indigo lighten-4"
            :items="allGroups"
            :maxlength="25"
            item-value="id"
            item-text="name"
            hide-no-data
            dense
            solo
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
          <v-list-item-title> Table </v-list-item-title>
          <v-list-item-subtitle>
            {{ selectedComponent.config.general_config.sql_table }}
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-list-item>
        <v-list-item-icon>
          <v-icon> mdi-table-row </v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>Fields</v-list-item-title>
          <v-list-item-subtitle>
            {{ selectedComponent.config.columns.length }}</v-list-item-subtitle
          >
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
    </v-list>
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';
  import { store } from '@/store';

  export default {
    name: 'ComponentDrilldown',

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

      setInvalid(invalid, field) {
        store.set(`validationStatesComponents/componentsEditBasic@${field}`, invalid);
      },
    },
  };
</script>
