<template>
  <div>
    <Steps />
    <Pricing />
    <Faq />
  </div>
</template>

<script>
  import { sync, get } from 'vuex-pathify';
  import Vue from 'vue';
  import Faq from '@/components/Landing/Faq.vue';

  Vue.component('SignupAlert', () => ({
    component: import(
      /* webpackChunkName: 'signup-steps-alert', webpackPrefetch: true */ './Steps/SignupAlert'
    ),
  }));

  export default {
    name: 'Signup',
    components: {
      Faq: () => import(/* webpackChunkName: 'faq' */ '@/components/Landing/Faq'),
      Steps: () =>
        import(/* webpackChunkName: 'signup-steps', webpackPrefetch: true */ './Steps/Steps'),
      Pricing: () =>
        import(
          /* webpackChunkName: 'pricing', webpackPrefetch: true */ '@/components/Landing/Pricing'
        ),
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
