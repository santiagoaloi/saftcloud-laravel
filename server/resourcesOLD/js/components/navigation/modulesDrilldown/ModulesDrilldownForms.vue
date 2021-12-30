<template>
  <div>
    <ValidationObserver ref="modulesDrilldownFormValidation" slim>
      <v-container>
        <baseFieldLabel required label="Modules label" />
        <validation-provider v-slot="{ errors, invalid }" immediate mode="aggressive" name="Modules label" rules="required">
          <v-text-field
            v-model="selectedModule.config.general_config.title"
            v-lazy-input:debounce="100"
            outlined
            :color="isDark ? '#208ad6' : 'grey'"
            :prepend-inner-icon="selectedModule.config_settings.icon.name"
            spellcheck="false"
            solo
            :error-messages="errors[0]"
            :error="errors.length > 0"
            hide-details="auto"
            class="mb-3"
            dense
            @change="setInvalid(invalid, 'modulesName')"
          >
            <template #append>
              <v-tooltip transition="false" color="black" bottom>
                <template #activator="{ on }">
                  <v-btn small icon :ripple="false" v-on="on" @click.stop="setStarred(selectedModule)">
                    <v-icon :color="isStarredColor(selectedModule)">
                      {{ isStarredIcon(selectedModule) }}
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
          v-model="selectedModule.config.general_config.note"
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
          <baseFieldLabel required label="modules group " />
          <v-autocomplete
            v-model="selectedModule.module_group_id"
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
            hide-details
          />
        </div>
      </v-container>
    </ValidationObserver>

    <div class="mt-2">
      <v-list-item two-line>
        <v-list-item-icon>
          <v-switch
            v-model="selectedModule.config.general_config.isVisibleInSidebar"
            :ripple="false"
            hide-details
            class="mt-2 ml-1"
            inset
          />
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>Sidebar</v-list-item-title>
          <v-list-item-subtitle> Display in navigation drawer </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
    </div>
  </div>
</template>

<script>
  import { get, sync, call } from 'vuex-pathify';

  export default {
    name: 'ModulesDrilldownForms',
    computed: {
      ...sync('theme', ['isDark']),
      ...get('modulesManagement', ['selectedModule', 'isStarredColor', 'isStarredIcon']),
      ...sync('modulesManagement', ['allGroups']),
    },

    methods: {
      ...call('modulesManagement', ['selectGroup']),
    },
  };
</script>
