<template>
  <v-fade-transition>
    <div v-show="!delay">
      <v-container style="background: #2c2f33">
        <signup-alert ref="signupAlert" />
        <v-card class="d-flex justify-center align- transparent" flat min-height="300" width="100%">
          <v-container>
            <v-row>
              <v-col class="text-center" cols="12" lg="6">
                <steps />
              </v-col>
              <v-col cols="12" lg="6">
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
          </v-container>
        </v-card>
        <Faq />
      </v-container>
      <vue-diagonal
        style="margin-top: -100px"
        :deg="-7"
        background="linear-gradient(331deg, rgba(101, 235, 235, 1) 0%, rgba(54, 49, 125, 1) 50%)"
        space-after
      >
        <Pricing />
      </vue-diagonal>
    </div>
  </v-fade-transition>
</template>

<script>
  import { sync, get } from 'vuex-pathify';
  import { waitForReadystate } from '@/util/helpers';

  export default {
    name: 'Signup',
    components: {
      Faq: () => import(/* webpackChunkName: 'faq' */ '@/components/Landing/Faq'),
      steps: () => import(/* webpackChunkName: 'signup-steps' */ './Steps/Steps'),
      Pricing: () => import(/* webpackChunkName: 'pricing' */ '@/components/Landing/Pricing'),
      signupAlert: () => import(/* webpackChunkName: 'signup-steps-alert' */ './Steps/SignupAlert'),
    },

    data() {
      return {
        delay: true,
      };
    },

    mounted() {
      this.$nextTick(() => {
        setTimeout(() => {
          this.delay = false;
        }, 200);
      });
    },

    props: {
      value: {
        type: [Boolean],
        default: false,
      },
    },
    computed: {
      ...sync('theme', ['isDark']),
    },
  };
</script>
