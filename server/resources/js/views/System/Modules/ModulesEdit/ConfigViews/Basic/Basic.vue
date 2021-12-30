<template>
  <div>
    <v-hover v-slot="{ hover }">
      <v-avatar
        class="cursor-pointer my-4"
        size="125"
        rounded
        :color="selectedModule.config_settings.icon.color"
        @click="dialogIcons = true"
      >
        <v-expand-transition>
          <div v-if="hover" class="d-flex black v-card--reveal white--text" style="height: 100%">
            <v-icon size="30" dark> mdi-pencil </v-icon>
          </div>
        </v-expand-transition>
        <v-fade-transition hide-on-leave>
          <v-icon v-if="!hover" size="30" dark>
            {{ selectedModule.config_settings.icon.name }}
          </v-icon>
        </v-fade-transition>
      </v-avatar>
    </v-hover>

    <ValidationObserver ref="ModulesEditBasic" slim>
      <v-row>
        <v-col sm="4">
          <div class="mt-2">
            <baseFieldLabel required label="Modules name" />
            <validation-provider v-slot="{ errors, invalid }" immediate mode="aggressive" name="field label" rules="required">
              <v-text-field
                v-model="selectedModule.config.general_config.title"
                height="55"
                :outlined="isDark"
                :solo="!isDark"
                :color="isDark ? '#208ad6' : 'grey'"
                :background-color="isDark ? '#28292b' : 'white'"
                spellcheck="false"
                :error-messages="errors[0]"
                :error="errors.length > 0"
                @change="setInvalid(invalid, 'ModulesName')"
              />
            </validation-provider>
          </div>

          <div class="mt-2">
            <baseFieldLabel label="Modules description" />
            <v-textarea
              v-model="selectedModule.config.general_config.note"
              :outlined="isDark"
              :solo="!isDark"
              :color="isDark ? '#208ad6' : 'grey'"
              :background-color="isDark ? '#28292b' : 'white'"
              spellcheck="false"
              :rows="2"
              auto-grow
            />
          </div>

          <div class="mt-2">
            <baseFieldLabel required label="Modules group " />
            <v-autocomplete
              v-model="selectedModule.module_group_id"
              height="55"
              solo
              :color="isDark ? '#208ad6' : 'grey'"
              :background-color="isDark ? '#28292b' : 'white'"
              hide-selected
              :items="allGroups"
              :maxlength="25"
              item-value="id"
              item-text="name"
              hide-no-data
            />
          </div>

          <v-divider class="my-5" />
          <div class="mt-2">
            <baseFieldLabel class="mb-n3" label="Navigation drawer settings" />
            <v-list-item two-line>
              <v-list-item-icon>
                <v-switch v-model="selectedModule.config.general_config.isVisibleInSidebar" hide-details class="mt-2" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>Visible in sidebar</v-list-item-title>
                <v-list-item-subtitle> Display this Modules in the left navigation drawer. </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </div>
        </v-col>
      </v-row>
    </ValidationObserver>

    <!-- trigger Modules icons dialog -->
    <base-dialog-icons v-if="dialogIcons" v-model="dialogIcons" :icon="ModulesIcon" />
  </div>
</template>

<script>
  import { sync, get } from 'vuex-pathify';
  import { store } from '@/store';

  export default {
    name: 'ModulesEditViewsBasic',
    data() {
      return {
        dialogIcons: false,
      };
    },
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('modulesManagement', ['modulesEditSheet', 'allGroups']),
      ...get('modulesManagement', ['selectedModule']),

      ModulesIcon() {
        if (!this.selectedModule) return;
        return this.selectedModule.config_settings.icon;
      },
    },

    methods: {
      setInvalid(invalid, field) {
        store.set(`validationStatesModules/ModulesEditBasic@${field}`, invalid);
      },
    },
  };
</script>

<style scoped>
  .v-card--reveal {
    align-items: center;
    bottom: 0;
    justify-content: center;
    opacity: 0.5;
    position: absolute;
    width: 100%;
  }
</style>
