<template>
  <baseDialog
    v-model="dialogEntity"
    :title="`Add new ${identityTypeButton}`"
    persistent
    max-width="900"
    icon="mdi-plus"
    @save="validateEntity()"
    @close="dialogEntity = !dialogEntity"
  >
    <ValidationObserver ref="createEntityForm" slim>
      <v-row>
        <v-col v-for="(ent, key) in entity" :key="key" cols="12" lg="6">
          <baseFieldLabel required :label="key" />
          <validation-provider v-slot="{ errors, reset }" :name="key" rules="required">
            <v-text-field
              v-model="entity[key]"
              spellcheck="false"
              solo
              :outlined="isDark"
              prepend-inner-icon="mdi-comment"
              counter
              maxlength="20"
              :color="isDark ? '#208ad6' : 'grey'"
              :background-color="isDark ? '#28292b' : 'white'"
              :error="errors.length > 0"
              :error-messages="errors[0]"
              @focus="reset"
              @input="reset"
              @blur="reset"
            />
          </validation-provider>
        </v-col>
      </v-row>
    </ValidationObserver>
  </baseDialog>
</template>
<script>
  import { sync, call } from 'vuex-pathify';
  import componentGroups from '@/mixins/componentGroups';

  export default {
    name: 'DialogEntity',
    mixins: [componentGroups],

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('entitiesManagement', ['dialogEntity', 'user', 'role', 'identityTypeButton']),

      entity() {
        return this.identityTypeButton === 'User' ? this.user : this.role;
      },
    },

    methods: {
      ...call('entitiesManagement/*'),

      validateEntity() {
        const action = this.identityTypeButton === 'User' ? 'createUser' : 'createRole';
        this.$refs.createEntityForm.validate().then((validated) => {
          if (validated) {
            this[action]().then((created) => {
              if (created) {
                alert('account created');
              }
            });
          }
        });
      },
    },
  };
</script>
