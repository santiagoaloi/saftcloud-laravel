<template>
  <div>
    <v-hover v-slot="{ hover }">
      <v-avatar class="cursor-pointer my-4" size="125" rounded color="primary">
        <v-expand-transition>
          <div v-if="hover" class="d-flex black v-card--reveal white--text" style="height: 100%">
            <v-icon size="30" dark> mdi-pencil </v-icon>
          </div>
        </v-expand-transition>
        <v-fade-transition hide-on-leave>
          <v-icon v-if="!hover" size="30" dark> mdi-account </v-icon>
        </v-fade-transition>
      </v-avatar>
    </v-hover>

    <ValidationObserver ref="ModulesEditBasic" slim>
      <v-row>
        <v-col sm="4">
          <div class="mt-2">
            <baseFieldLabel required label="first name" />
            <validation-provider v-slot="{ errors }" immediate mode="aggressive" name="first name" rules="required">
              <v-text-field
                v-model="selectedEntity.entity.first_name"
                :outlined="isDark"
                :solo="!isDark"
                :color="isDark ? '#208ad6' : 'grey'"
                :background-color="isDark ? '#28292b' : 'white'"
                spellcheck="false"
                :error-messages="errors[0]"
                :error="errors.length > 0"
              />
            </validation-provider>
          </div>

          <div class="mt-2">
            <baseFieldLabel required label="last name" />
            <validation-provider v-slot="{ errors }" immediate mode="aggressive" name="last name" rules="required">
              <v-text-field
                v-model="selectedEntity.entity.last_name"
                :outlined="isDark"
                :solo="!isDark"
                :color="isDark ? '#208ad6' : 'grey'"
                :background-color="isDark ? '#28292b' : 'white'"
                spellcheck="false"
                :error-messages="errors[0]"
                :error="errors.length > 0"
              />
            </validation-provider>
          </div>

          <div class="mt-2">
            <baseFieldLabel required label="Email" />
            <validation-provider v-slot="{ errors }" immediate mode="aggressive" name="email" rules="required">
              <v-text-field
                v-model="selectedEntity.email"
                :outlined="isDark"
                :solo="!isDark"
                :color="isDark ? '#208ad6' : 'grey'"
                :background-color="isDark ? '#28292b' : 'white'"
                spellcheck="false"
                :error-messages="errors[0]"
                :error="errors.length > 0"
              />
            </validation-provider>
          </div>
        </v-col>
      </v-row>
    </ValidationObserver>
  </div>
</template>

<script>
  import { sync, get } from 'vuex-pathify';

  export default {
    name: 'EntitiesEditViewsBasic',
    components: {},
    data() {
      return {
        dialogIcons: false,
      };
    },
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('entitiesManagement', ['entitiesEditSheet']),
      ...get('entitiesManagement', ['selectedEntity']),
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
