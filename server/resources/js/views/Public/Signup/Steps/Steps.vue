<template>
  <v-container class="fill-height">
    <signup-alert ref="signupAlert" />
    <v-card class="d-flex justify-center align- transparent" flat min-height="300" width="100%">
      <v-container>
        <v-row>
          <v-col class="text-center" cols="12" lg="6">
            <v-expand-transition>
              <keep-alive>
                <component :is="`step${step}`" />
              </keep-alive>
            </v-expand-transition>
          </v-col>
          <v-col cols="12" lg="6">
            <!-- <v-list two-line flat>
              <v-list-item>
                <v-list-item-avatar>
                  <v-icon> mdi-check</v-icon>
                </v-list-item-avatar>
                <v-list-item-content>
                  <v-list-item-title>Notifications</v-list-item-title>
                  <v-list-item-subtitle>Allow notifications</v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
            </v-list> -->
          </v-col>
        </v-row>
      </v-container>
    </v-card>
  </v-container>
</template>

<script>
  import { sync } from 'vuex-pathify';

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
      ...sync('signup', ['step']),
    },
  };
</script>
