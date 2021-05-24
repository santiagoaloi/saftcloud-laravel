<template>
  <div>
    <v-container class="fill-height my-15">
      <v-row justify="center">
        <v-col cols="12">
          <v-alert dismissible border="left" colored-border color="grey darken-2" elevation="2" class="text-left ">
            All new accounts are free of charge for the first 14 days since the day of registration, no payment information is required until the trial ends.
            The information uploaded to SaftCloud is confidential and only available to you. We don't comercialice any data uploaded to our databases. Once the
            trial ends, we will retain the data one week, to provide you with backups or exporting capabilities.
          </v-alert>
        </v-col>
      </v-row>

      <v-card color="white" class="pa-10" width="100%">
        <v-row justify="center">
          <v-col class="text-center" cols="12" lg="6">
            <v-scroll-x-transition hide-on-leave>
              <div v-if="step === 0">
                <v-card-text>
                  <p class="display-1 text--primary">Hi {{ signupForm.name }}, nice to meet you!</p>
                  <ValidationObserver ref="step0" slim>
                    <v-row justify="center">
                      <v-col sm="6">
                        <span>Name</span>
                        <validation-provider v-slot="{ errors }" name="First name" rules="required">
                          <v-text-field
                            autofocus
                            v-model="signupForm.name"
                            solo
                            hide-details
                            @keydown.enter.prevent="nextStep(1)"
                            :background-color="errors.length > 0 ? '#faebeb' : ''"
                          ></v-text-field>
                        </validation-provider>
                      </v-col>
                      <v-col sm="6">
                        <span>Last name </span>
                        <validation-provider v-slot="{ errors }" name="Last name" rules="required">
                          <v-text-field
                            v-model="signupForm.lastname"
                            solo
                            hide-details
                            @keydown.enter.prevent="nextStep(1)"
                            :background-color="errors.length > 0 ? '#faebeb' : ''"
                          ></v-text-field>
                        </validation-provider>
                      </v-col>
                    </v-row>
                  </ValidationObserver>
                </v-card-text>
                <v-btn @click="nextStep(1)" large color="primary">Continue</v-btn>
              </div>
            </v-scroll-x-transition>

            <!-- STEP 1 -->
            <v-scroll-x-transition hide-on-leave>
              <div v-if="step === 1">
                <v-card-text>
                  <p class="display-1 text--primary">
                    How should we contact you?
                  </p>
                  <ValidationObserver ref="step1" slim>
                    <v-row justify="center">
                      <v-col sm="12">
                        <span>Email</span>
                        <validation-provider v-slot="{ errors }" name="Email" rules="required|email">
                          <v-text-field
                            autofocus
                            type="email"
                            v-model="signupForm.email"
                            solo
                            hide-details
                            @keydown.enter.prevent="nextStep(2)"
                            :background-color="errors.length > 0 ? '#faebeb' : ''"
                          ></v-text-field>
                        </validation-provider>
                      </v-col>
                      <v-col sm="6">
                        <span>Country Code</span>
                        <validation-provider v-slot="{ errors }" name="CountryCode" rules="required">
                          <v-autocomplete
                            :items="countryCodes"
                            v-model="signupForm.phone_code"
                            solo
                            item-text="phone_code"
                            :filter="filterCountries"
                            hide-details
                            @keydown.enter.prevent="nextStep(2)"
                            :background-color="errors.length > 0 ? '#faebeb' : ''"
                          >
                            <template slot="selection" slot-scope="data">
                              <v-row no-gutters dense>
                                <v-col cols="4">
                                  <v-list-item-content>
                                    <country-flag class="mr-2" :country="data.item.iso2" />
                                  </v-list-item-content>
                                </v-col>

                                <v-col cols="8">
                                  <v-list-item-content class="pt-4">
                                    <v-list-item-title>
                                      +{{ `${data.item.phone_code}` }}

                                      {{ `${data.item.name}` }}
                                    </v-list-item-title>
                                  </v-list-item-content>
                                </v-col>
                              </v-row>
                            </template>

                            <template v-slot:item="data">
                              <v-row no-gutters dense>
                                <v-col cols="3">
                                  <v-list-item-content>
                                    <country-flag class="mr-2" :country="data.item.iso2" />
                                  </v-list-item-content>
                                </v-col>

                                <v-col cols="6">
                                  <v-list-item-content>
                                    <v-list-item-title>
                                      +{{ `${data.item.phone_code}` }}

                                      {{ `${data.item.name}` }}
                                    </v-list-item-title>
                                  </v-list-item-content>
                                </v-col>
                              </v-row>
                            </template>
                          </v-autocomplete>
                        </validation-provider>
                      </v-col>
                      <v-col sm="6">
                        <span>Phone number</span>
                        <validation-provider v-slot="{ errors }" name="Phone mumber" rules="required">
                          <v-text-field
                            type="number"
                            v-model="signupForm.phoneNumber"
                            solo
                            hide-details
                            @keydown.enter.prevent="nextStep(2)"
                            :background-color="errors.length > 0 ? '#faebeb' : ''"
                          ></v-text-field>
                        </validation-provider>
                      </v-col>
                    </v-row>
                  </ValidationObserver>
                </v-card-text>
                <v-btn class="mx-1" @click="step = 0" large color="grey lighten-2">Back</v-btn>
                <v-btn class="mx-1" @click="nextStep(2)" large color="primary">Continue</v-btn>
              </div>
            </v-scroll-x-transition>

            <!-- STEP 2 -->
            <v-scroll-x-transition hide-on-leave>
              <div v-if="step === 2">
                <v-card-text>
                  <p class="display-1 text--primary">
                    Where is your bussiness headquartered?
                  </p>

                  <ValidationObserver ref="step2" slim>
                    <v-row justify="center">
                      <v-col sm="12">
                        <span>Country</span>
                        <validation-provider v-slot="{ errors }" name="Country" rules="required">
                          <v-autocomplete
                            autofocus
                            :items="countryCodes"
                            v-model="signupForm.country"
                            solo
                            attach
                            item-text="name"
                            item-value="id"
                            hide-details
                            @keydown.enter.prevent="nextStep(3)"
                            :background-color="errors.length > 0 ? '#faebeb' : ''"
                          >
                            <template slot="selection" slot-scope="data">
                              <country-flag class="mr-2" :country="data.item.iso2" />
                              <span class="mr-2">{{ data.item.name }} </span>
                            </template>
                          </v-autocomplete>
                        </validation-provider>
                      </v-col>

                      <v-col sm="6">
                        <span>State, Province, or Region </span>
                        <validation-provider v-slot="{ errors }" name="State" rules="required">
                          <v-text-field
                            v-model="signupForm.state"
                            solo
                            hide-details
                            @keydown.enter.prevent="nextStep(3)"
                            :background-color="errors.length > 0 ? '#faebeb' : ''"
                          ></v-text-field>
                        </validation-provider>
                      </v-col>

                      <v-col sm="6">
                        <span>City </span>
                        <validation-provider v-slot="{ errors }" name="City" rules="required">
                          <v-text-field
                            v-model="signupForm.city"
                            solo
                            hide-details
                            @keydown.enter.prevent="nextStep(3)"
                            :background-color="errors.length > 0 ? '#faebeb' : ''"
                          ></v-text-field>
                        </validation-provider>
                      </v-col>

                      <v-col sm="8">
                        <span>Address</span>
                        <validation-provider v-slot="{ errors }" name="Address" rules="required">
                          <v-text-field
                            v-model="signupForm.address"
                            solo
                            hide-details
                            @keydown.enter.prevent="nextStep(3)"
                            :background-color="errors.length > 0 ? '#faebeb' : ''"
                          ></v-text-field>
                        </validation-provider>
                      </v-col>

                      <v-col sm="4">
                        <span>Postal code</span>
                        <validation-provider v-slot="{ errors }" name="Zipcode" rules="required">
                          <v-text-field
                            v-model="signupForm.zipcode"
                            solo
                            hide-details
                            @keydown.enter.prevent="nextStep(3)"
                            :background-color="errors.length > 0 ? '#faebeb' : ''"
                          ></v-text-field>
                        </validation-provider>
                      </v-col>
                    </v-row>
                  </ValidationObserver>
                </v-card-text>
                <v-btn class="mx-1" @click="step = 1" large color="grey lighten-2">Back</v-btn>
                <v-btn class="mx-1" @click="nextStep(3)" large color="primary">Continue</v-btn>
              </div>
            </v-scroll-x-transition>

            <!-- STEP 3 -->
            <v-scroll-x-transition hide-on-leave>
              <div v-if="step === 3">
                <v-card-text>
                  <p class="display-1 text--primary">
                    Define your parent account
                  </p>
                  <ValidationObserver ref="step3" slim>
                    <v-row justify="center">
                      <v-col sm="6">
                        <validation-provider v-slot="{ errors }" name="Company name" rules="required">
                          <span>Account name</span>
                          <!-- V-MODEL companyName SHOULD CHANGE TO accountName -->
                          <v-text-field
                            autofocus
                            v-model="signupForm.companyName"
                            hint="Oficial registed company name"
                            solo
                            hide-details
                            :background-color="errors.length > 0 ? '#faebeb' : ''"
                            @keydown.enter.prevent="nextStep(4)"
                          ></v-text-field>
                        </validation-provider>
                      </v-col>
                      <v-col sm="6">
                        <span>Parent company name alias</span>
                        <validation-provider v-slot="{ errors }" name="Company name alias" rules="required">
                          <v-text-field
                            v-model="signupForm.companyNameAlias"
                            hint="Public company name alias"
                            solo
                            hide-details
                            :background-color="errors.length > 0 ? '#faebeb' : ''"
                            @keydown.enter.prevent="nextStep(4)"
                          ></v-text-field>
                        </validation-provider>
                      </v-col>
                    </v-row>
                  </ValidationObserver>
                </v-card-text>
                <v-btn class="mx-1" @click="step = 2" large color="grey lighten-2">Back</v-btn>
                <v-btn @click="nextStep(4)" class="mx-1" large color="primary">Review application</v-btn>
              </div>
            </v-scroll-x-transition>
            <!-- STEP 4 -->
            <v-scroll-x-transition hide-on-leave>
              <div v-if="step === 4">
                <v-card>
                  <v-card-text class="text-left ">
                    <h2>Let's review those details</h2>
                    <div class="mt-5 mb-5 text-h5">
                      let's double check the information your provided before we can move forward with the registration of your shiny new account "<b>{{
                        signupForm.companyName
                      }}</b
                      >"
                    </div>
                    <div class="mt-10 text-h5">
                      We can reach you on your number from
                      <span>
                        <b>
                          {{ getCountryNameAndCode(signupForm.phone_code) }}
                          {{ signupForm.phoneNumber }}
                        </b>
                        and on your email
                        <b> {{ signupForm.email }}</b
                        >.
                      </span>
                    </div>
                    <div class="text-h5 mt-5">
                      Your business
                      <b> {{ signupForm.companyNameAlias }}</b>
                      is registered in
                      <b>
                        {{ getCountryName(signupForm.country) }}
                      </b>
                      on the address
                      <b> {{ signupForm.address }} ({{ signupForm.zipcode }}), {{ signupForm.state }}, {{ signupForm.city }}. </b>
                    </div></v-card-text
                  ></v-card
                >

                <v-card-text>
                  <v-checkbox :ripple="false" class="mt-10" v-model="terms">
                    <template v-slot:label>
                      <div>
                        I confirm that my information is genuine and that I represent the business I'm creating the account for, as well as reading and
                        accepting

                        <a target="_blank" href="https://vuetifyjs.com" @click.stop>
                          our terms and conditions
                        </a>
                        thoroughly.
                      </div>
                    </template>
                  </v-checkbox>
                </v-card-text>
                <v-btn class="mx-1" @click="step = 3" large color="grey lighten-2">Back</v-btn>
                <v-btn :disabled="!terms" @click="accountCreation()" class="mx-1" large color="primary" :loading="loading">Sign up</v-btn>
              </div>
            </v-scroll-x-transition>
          </v-col>
          <v-col cols="12" lg="6">
            <!-- <v-img contain src="storage/signup.svg" max-height="280"></v-img> -->

            <v-list two-line flat>
              <v-list-item>
                <v-list-item-avatar>
                  <v-icon> mdi-check</v-icon>
                </v-list-item-avatar>

                <v-list-item-content>
                  <v-list-item-title>Notifications</v-list-item-title>
                  <v-list-item-subtitle>Allow notifications</v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
            </v-list>
          </v-col>
        </v-row>
      </v-card>

      <!-- <v-row class="text-center justify-center">
        <v-col cols="12" lg="6">
       
    
        </v-col>

        <v-col
          :order="$vuetify.breakpoint.smAndDown ? 'first' : null"
          cols="12"
          lg="6"
        >
          <v-img src="storage/signup.svg" max-height="280" contain></v-img>
        </v-col>
      </v-row> -->
      <Faq />
    </v-container>

    <vue-diagonal :deg="-7" background="linear-gradient(331deg, rgba(101, 235, 235, 1) 0%, rgba(54, 49, 125, 1) 50%)" space-after space-before>
      <Pricing />
    </vue-diagonal>
  </div>
</template>

<script>
import Pricing from "@/components/landing/Pricing.vue";
import Faq from "@/components/landing/Faq.vue";

import globalMixin from "@/mixins/globalMixin";
import filterFunctionsMixin from "@/mixins/filterFunctions";
import CountryFlag from "vue-country-flag";
import axios from "axios";
export default {
  name: "Signup",
  mixins: [globalMixin, filterFunctionsMixin],
  components: {
    CountryFlag,
    Pricing,
    Faq
  },
  props: {
    value: {
      type: [Boolean],
      default: false
    }
  },

  data() {
    return {
      loading: false,
      controller: "Signup",
      terms: false,
      countryCodes: [],
      states: [],
      cities: [],
      step: 0,
      signupForm: {
        name: "",
        lastname: "",
        email: "",
        phone_code: null,
        phoneNumber: "",
        companyNameAlias: "",
        companyName: "",
        state: "",
        city: "",
        country: null,
        zipcode: "",
        address: ""
      }
    };
  },

  mounted() {
    this.getCountries();
  },

  methods: {
    nextStep(nextStep) {
      //Fist step
      if (this.step == 0) {
        this.$refs.step0.validate().then(success => {
          if (success) {
            this.step = nextStep;
          }
        });
        //Second step
      } else if (this.step == 1) {
        this.$refs.step1.validate().then(success => {
          if (success) {
            this.step = nextStep;
          }
        });
        //Third step
      } else if (this.step == 2) {
        this.$refs.step2.validate().then(success => {
          if (success) {
            this.step = nextStep;
          }
        });
        //fourth step
      } else if (this.step == 3) {
        this.$refs.step3.validate().then(success => {
          if (success) {
            this.step = nextStep;
          }
        });
      }
    },

    getCountryNameAndCode(phone_code) {
      let countryObject = this.countryCodes.filter(item => {
        return item.phone_code === phone_code;
      });
      return `${countryObject[0].name} +${countryObject[0].phone_code} `;
    },

    getCountryName(countryId) {
      let countryObject = this.countryCodes.filter(item => {
        return item.id === countryId;
      });
      return `${countryObject[0].name}`;
    },

    accountCreation() {
      this.loading = true;
      axios.post("api/makeAccount", this.signupForm).then(response => {
        if (response.data.status) {
          this.$router.push("/VerifyAccount");
        } else {
          this.loading = false;
        }
      });
    },

    getCountries() {
      axios.get("api/countries").then(response => {
        if (response.data.status) {
          this.countryCodes = response.data.rows;
        }
      });
    }
  }
};
</script>
<style scoped>
::v-deep .v-alert__content {
  line-height: 1.3;
}
</style>
