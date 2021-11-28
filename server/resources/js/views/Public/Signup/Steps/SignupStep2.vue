<template>
  <div>
    <v-card-text>
      <h2 class="mb-5">Where is your bussiness headquartered?</h2>
      <ValidationObserver ref="step2" slim>
        <v-row justify="center">
          <v-col sm="12">
            <baseFieldLabel label="Country" />
            <validation-provider v-slot="{ errors, reset }" name="country" rules="required">
              <v-autocomplete
                v-model="signupForm.country"
                auto-select-first
                height="55"
                maxlength="30"
                :items="countryCodes"
                solo
                attach
                item-text="name"
                item-value="id"
                :outlined="isDark"
                :color="isDark ? '#208ad6' : 'grey'"
                :background-color="isDark ? '#28292b' : 'white'"
                :error="errors.length > 0"
                :menu-props="{ disableKeys: true }"
                @keydown.enter.prevent="validateAndProceed()"
                @change="getStates({ id: $event })"
                @focus="reset"
                @input="reset"
                @blur="reset"
              >
                <template slot="selection" slot-scope="data">
                  <!-- <country-flag class="mr-2" :country="data.item.iso2" /> -->
                  <span class="mr-2">{{ data.item.name }} </span>
                </template>

                <template #item="{ item, on }">
                  <v-list-item :ripple="false" v-on="on">
                    <v-list-item-avatar>
                      <!-- <country-flag class="mr-2" :country="item.iso2" /> -->
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title> {{ item.name }} </v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </template>
              </v-autocomplete>
            </validation-provider>
          </v-col>

          <v-col sm="6">
            <baseFieldLabel label="State, Province, or Region " />
            <validation-provider v-slot="{ errors, reset }" name="state" rules="required">
              <v-autocomplete
                v-model="signupForm.state"
                height="55"
                maxlength="30"
                :disabled="!states.length"
                :items="states"
                solo
                attach
                item-text="name"
                item-value="id"
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
            <baseFieldLabel label="City" />
            <validation-provider v-slot="{ errors, reset }" name="city" rules="required">
              <v-text-field
                v-model="signupForm.city"
                height="55"
                counter
                maxlength="30"
                :disabled="!states.length"
                solo
                prepend-inner-icon="mdi-city"
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

          <v-col sm="8">
            <baseFieldLabel label="Address" />
            <validation-provider v-slot="{ errors, reset }" name="address" rules="required">
              <v-text-field
                v-model="signupForm.address"
                height="55"
                counter
                maxlength="45"
                solo
                prepend-inner-icon="mdi-map-marker"
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

          <v-col sm="4">
            <baseFieldLabel label="Postal code" />
            <validation-provider v-slot="{ errors, reset }" name="zipcode" rules="required">
              <v-text-field
                v-model="signupForm.zipcode"
                height="55"
                counter
                maxlength="15"
                solo
                prepend-inner-icon="mdi-map-marker"
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
    name: 'SignupStep2',

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('signup', ['signupForm', 'step', 'countryCodes', 'states']),
      ...get('signup', ['filterCountries']),
    },

    methods: {
      ...call('signup/*'),
      validateAndProceed() {
        this.$refs.step2.validate().then((success) => {
          if (success) {
            this.step += 1;
          }
        });
      },
    },
  };
</script>
