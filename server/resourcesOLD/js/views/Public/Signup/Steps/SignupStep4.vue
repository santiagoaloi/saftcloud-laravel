<template>
  <div>
    <v-card-text class="text-left">
      <h2>Let's review those details now</h2>
      <div class="mt-5 mb-5 text-h5">
        let's double check the information your provided before we can move forward with the registration of your shiny new
        account "<b>{{ signupForm.companyName }}</b
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
      </div>
    </v-card-text>

    <v-checkbox v-model="terms" :color="isDark ? 'indigo lighten-2' : 'indigo'" :dark="isDark" :ripple="false" class="mt-10">
      <template #label>
        <div>
          I confirm that my information is genuine and that I represent the business I'm creating the account for, as well as
          reading and accepting
          <a target="_blank" href="https://vuetifyjs.com" @click.stop> our terms and conditions </a>
          thoroughly.
        </div>
      </template>
    </v-checkbox>

    <v-btn dark class="mx-1" large color="grey darken-2" @click="step--"> Back </v-btn>
    <v-btn :disabled="!terms" class="mx-1" large color="primary" :loading="loading" @click="accountCreation()"> Sign up </v-btn>
  </div>
</template>

<script>
  import { sync, get, call } from 'vuex-pathify';

  export default {
    name: 'SignupStep4',
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('signup', ['signupForm', 'step', 'terms', 'loading']),
      ...get('signup', ['getCountryNameAndCode', 'getCountryName', '']),
    },

    methods: {
      ...call('signup/*'),
    },
  };
</script>
