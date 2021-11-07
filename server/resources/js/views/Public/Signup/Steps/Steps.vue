<template>
  <v-container class="fill-height">
    <v-img src="https://cdn.vuetifyjs.com/images/cards/cooking.png" class="white--text align-end" gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)" height="200px">
      <v-card-title> Join us</v-card-title>
    </v-img>

    <signup-alert ref="signupAlert" class="mt-4" />
    <v-card class="my-4" width="100%">
      <v-card-title> Top western road trips </v-card-title>

      <v-card-subtitle> 1,000 miles of wonder </v-card-subtitle>
    </v-card>
    <v-row>
      <v-col class="text-center" cols="12" lg="6">
        <v-expand-transition>
          <keep-alive>
            <component :is="`step${step}`" />
          </keep-alive>
        </v-expand-transition>
      </v-col>
      <v-col cols="12" lg="6">
        <v-card>
          <v-card-title>Cafe Badilico</v-card-title>

          <v-card-text>
            <div class="my-4 text-subtitle-1">$ • Italian, Cafe</div>

            <div>Small plates, salads & sandwiches - an intimate setting with 12 indoor seats plus patio seating.</div>
          </v-card-text>

          <v-divider class="mx-4"></v-divider>

          <v-card-title>Tonight's availability</v-card-title>

          <v-card-text>
            <v-chip-group active-class="deep-purple accent-4 white--text" column>
              <v-chip>5:30PM</v-chip>

              <v-chip>7:30PM</v-chip>

              <v-chip>8:00PM</v-chip>

              <v-chip>9:00PM</v-chip>
            </v-chip-group>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import { sync, get } from 'vuex-pathify';

  export default {
    name: 'SignupSteps',
    components: {
      SignupAlert: () => import(/* webpackChunkName: 'signup-bundle' */ './SignupAlert'),
      step0: () => import(/* webpackChunkName: 'Parent'  */ './SignupStep0'),
      step1: () => import(/* webpackChunkName: 'signup-step1' */ './SignupStep1'),
      step2: () => import(/* webpackChunkName: 'signup-step2' */ './SignupStep2'),
      step3: () => import(/* webpackChunkName: 'signup-step3' */ './SignupStep3'),
      step4: () => import(/* webpackChunkName: 'signup-step4' */ './SignupStep4'),
    },
    computed: {
      ...sync('signup', ['signupForm', 'step', 'terms', 'loading']),
      ...get('signup', ['getCountryNameAndCode', 'getCountryName', '']),
    },
  };
</script>
