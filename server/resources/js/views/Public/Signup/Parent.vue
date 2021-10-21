<template>
  <div>
    <Steps />
    <Pricing />
    <Faq />
  </div>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'SignupParent',
    components: {
      Faq: () => import(/* webpackChunkName: 'Parent' */ '@/components/Landing/Faq'),
      Steps: () => import(/* webpackChunkName: 'Parent' */ './Steps/Steps'),
      Pricing: () => import(/* webpackChunkName: 'Parent' */ '@/components/Landing/Pricing'),
    },

    computed: {
      ...sync('theme', ['isDark']),
    },
  };
</script>
