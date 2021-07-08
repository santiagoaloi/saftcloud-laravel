<template>
 <div>
  <v-card-text>
   <h2 class="text--primary  mb-5">
    Where is your bussiness headquartered?
   </h2>
   <ValidationObserver ref="step2" slim>
    <v-row justify="center">
     <v-col sm="12">
      <baseFieldLabel label="Country" />
      <validation-provider v-slot="{ errors }" name="Country" rules="required">
       <v-autocomplete
        :items="countryCodes"
        v-model="signupForm.country"
        solo
        attach
        item-text="name"
        item-value="id"
        hide-details
        @keydown.enter.prevent="validateAndProceed()"
        :outlined="isDark"
        :color="isDark ? '#208ad6' : 'grey'"
        :background-color="isDark ? 'grey darken-4' : 'grey lighten-4'"
        :error="errors.length > 0"
        @change="getStates({ id: $event })"
       >
        <template slot="selection" slot-scope="data">
         <country-flag class="mr-2" :country="data.item.iso2" />
         <span class="mr-2">{{ data.item.name }} </span>
        </template>

        <template #item="{ item, on }">
         <v-list-item :ripple="false" v-on="on">
          <v-list-item-avatar>
           <country-flag class="mr-2" :country="item.iso2" />
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
      <validation-provider v-slot="{ errors }" name="State" rules="required">
       <v-autocomplete
        :disabled="!states.length"
        :items="states"
        v-model="signupForm.state"
        solo
        attach
        item-text="name"
        item-value="id"
        hide-details
        @keydown.enter.prevent="validateAndProceed()"
        :outlined="isDark"
        :color="isDark ? '#208ad6' : 'grey'"
        :background-color="isDark ? 'grey darken-4' : 'grey lighten-4'"
        :error="errors.length > 0"
       >
       </v-autocomplete>
      </validation-provider>
     </v-col>

     <v-col sm="6">
      <baseFieldLabel label="City" />
      <validation-provider v-slot="{ errors }" name="City" rules="required">
       <v-text-field
        :disabled="!states.length"
        v-model="signupForm.city"
        solo
        hide-details
        @keydown.enter.prevent="validateAndProceed()"
        prepend-inner-icon="mdi-city"
        :outlined="isDark"
        :color="isDark ? '#208ad6' : 'grey'"
        :background-color="isDark ? 'grey darken-4' : 'grey lighten-4'"
        :error="errors.length > 0"
       ></v-text-field>
      </validation-provider>
     </v-col>

     <v-col sm="8">
      <baseFieldLabel label="Address" />
      <validation-provider v-slot="{ errors }" name="Address" rules="required">
       <v-text-field
        v-model="signupForm.address"
        solo
        hide-details
        @keydown.enter.prevent="validateAndProceed()"
        prepend-inner-icon="mdi-map-marker"
        :outlined="isDark"
        :color="isDark ? '#208ad6' : 'grey'"
        :background-color="isDark ? 'grey darken-4' : 'grey lighten-4'"
        :error="errors.length > 0"
       ></v-text-field>
      </validation-provider>
     </v-col>

     <v-col sm="4">
      <baseFieldLabel label="Postal code" />
      <validation-provider v-slot="{ errors }" name="Zipcode" rules="required">
       <v-text-field
        v-model="signupForm.zipcode"
        solo
        hide-details
        @keydown.enter.prevent="validateAndProceed()"
        prepend-inner-icon="mdi-map-marker"
        :outlined="isDark"
        :color="isDark ? '#208ad6' : 'grey'"
        :background-color="isDark ? 'grey darken-4' : 'grey lighten-4'"
        :error="errors.length > 0"
       ></v-text-field>
      </validation-provider>
     </v-col>
    </v-row>
   </ValidationObserver>
  </v-card-text>

  <v-btn dark class="mx-1" @click="step--" large color="grey darken-2">Back</v-btn>
  <v-btn @click="validateAndProceed()" large color="primary">Continue</v-btn>
 </div>
</template>

<script>
import { sync, get, call } from "vuex-pathify";
import CountryFlag from "vue-country-flag";

export default {
 name: "SignupStep2",
 components: {
  CountryFlag
 },
 data() {
  return {};
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("signup", ["signupForm", "step", "countryCodes", "states"]),
  ...get("signup", ["filterCountries"])
 },

 methods: {
  ...call("signup/*"),
  validateAndProceed() {
   this.$refs.step2.validate().then(success => {
    if (success) {
     this.step++;
    }
   });
  },
  test(e) {
   console.log(e);
  }
 }
};
</script>
