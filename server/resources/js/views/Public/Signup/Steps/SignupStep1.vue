<template>
  <div>
    <v-card-text>
      <h2 class="text--primary mb-5">How should we contact you?</h2>
      <ValidationObserver ref="step1" slim>
        <v-row justify="center">
          <v-col sm="12">
            <baseFieldLabel label="Email" />
            <span />
            <validation-provider v-slot="{ errors, reset }" name="email" rules="required|email">
              <v-text-field
                v-model="signupForm.email"
                height="55"
                counter
                maxlength="70"
                autofocus
                type="email"
                solo
                prepend-inner-icon="mdi-email"
                :outlined="isDark"
                :color="isDark ? '#208ad6' : 'grey'"
                :background-color="isDark ? '#28292b' : 'white'"
                :error="errors.length > 0"
                @keydown.enter.prevent="validateAndProceed()"
                @focus="reset"
                @input="reset"
                @blur="reset"
              />
            </validation-provider>
          </v-col>
          <v-col sm="6">
            <baseFieldLabel label="Country Code" />
            <validation-provider v-slot="{ errors, reset }" name="country code" rules="required">
              <v-autocomplete
                v-model="signupForm.phone_code"
                height="55"
                maxlength="30"
                :items="countryCodes"
                solo
                item-text="phone_code"
                :filter="filterCountries"
                hide-no-data
                :outlined="isDark"
                :color="isDark ? '#208ad6' : 'grey'"
                :background-color="isDark ? '#28292b' : 'white'"
                :error="errors.length > 0"
                @keydown.enter.prevent="validateAndProceed()"
                @focus="reset"
                @input="reset"
                @blur="reset"
              >
                <template slot="selection" slot-scope="data">
                  <country-flag country="hr" size="normal" />
                  <v-list-item-content class="pt-4 pl-2">
                    <v-list-item-title>
                      {{ `${data.item.name}` }}
                    </v-list-item-title>
                  </v-list-item-content>
                </template>

                <template #item="{ item, on }">
                  <v-list-item :ripple="false" v-on="on">
                    <v-list-item-avatar>
                      <country-flag :country="item.iso2" />
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title>
                        +{{ `${item.phone_code}` }}
                        {{ `${item.name}` }}
                      </v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </template>
              </v-autocomplete>
            </validation-provider>
          </v-col>
          <v-col sm="6">
            <baseFieldLabel label="Phone number" />
            <span />
            <validation-provider v-slot="{ errors, reset }" name="phone number" rules="required">
              <v-text-field
                v-model="signupForm.phoneNumber"
                height="55"
                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                maxlength="25"
                type="number"
                solo
                hide-details
                prepend-inner-icon="mdi-phone"
                :outlined="isDark"
                :color="isDark ? '#208ad6' : 'grey'"
                :background-color="isDark ? '#28292b' : 'white'"
                :error="errors.length > 0"
                @keydown.enter.prevent="validateAndProceed()"
                @focus="reset"
                @input="reset"
                @blur="reset"
              />
            </validation-provider>
          </v-col>
        </v-row>
      </ValidationObserver>
    </v-card-text>

    <v-btn dark class="mx-1" large color="grey darken-2" @click="step--"> Back </v-btn>
    <v-btn large color="primary" @click="validateAndProceed()"> Continue </v-btn>
  </div>
</template>

<script>
  import { sync, get, call } from 'vuex-pathify';

  export default {
    name: 'SignupStep0',

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('signup', ['signupForm', 'step', 'countryCodes']),
      ...get('signup', ['filterCountries']),
    },

    mounted() {
      if (!this.countryCodes.length) {
        this.getCountries();
      }
    },

    methods: {
      ...call('signup/*'),

      validateAndProceed() {
        this.$refs.step1.validate().then((success) => {
          if (success) {
            this.step += 1;
          }
        });
      },
    },
  };
</script>
