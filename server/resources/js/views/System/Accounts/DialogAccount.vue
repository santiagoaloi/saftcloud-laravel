<template>
  <baseDialog
    v-model="dialogAccount"
    title="Add new account"
    persistent
    max-width="900"
    icon="mdi-plus"
    @save="validateAccountForm()"
    @close="dialogAccount = !dialogAccount"
  >
    <ValidationObserver
      ref="createAccountForm"
      slim
    >
      <v-row>
        <v-col
          cols="12"
          lg="6"
        >
          <baseFieldLabel
            required
            label="Name"
          />
          <validation-provider
            v-slot="{ errors, reset }"
            name="Name"
            rules="required"
          >
            <v-text-field
              v-model="account.name"
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
              @keydown.enter.prevent="validateAccountForm()"
              @focus="reset"
              @input="reset"
              @blur="reset"
            />
          </validation-provider>
        </v-col>
        <v-col
          cols="12"
          lg="6"
        >
          <baseFieldLabel
            required
            label="Last Name"
          />
          <validation-provider
            v-slot="{ errors, reset }"
            name="Last Name"
            rules="required"
          >
            <v-text-field
              v-model="account.lastname"
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
              @keydown.enter.prevent="validateAccountForm()"
              @focus="reset"
              @input="reset"
              @blur="reset"
            />
          </validation-provider>
        </v-col>
        <v-col
          cols="12"
          lg="6"
        >
          <baseFieldLabel
            required
            label="Email"
          />
          <validation-provider
            v-slot="{ errors, reset }"
            name="Email"
            rules="required"
          >
            <v-text-field
              v-model="account.email"
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
              @keydown.enter.prevent="validateAccountForm()"
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
  name: 'DialogAccount',
  mixins: [componentGroups],

  mounted() {},

  computed: {
    ...sync('theme', ['isDark']),
    ...sync('accountsManagement', ['dialogAccount', 'account']),
  },

  methods: {
    ...call('accountsManagement/*'),

    validateAccountForm() {
      this.$refs.createAccountForm.validate().then((validated) => {
        if (validated) {
          this.createAccount().then((created) => {
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
