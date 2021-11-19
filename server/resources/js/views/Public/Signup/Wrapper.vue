<template>
  <div>
    <Steps />
    <Pricing />
    <Faq />
  </div>
</template>

<script>
  export default {
    name: 'SignupParent',
    components: {
      Faq: () => import(/* webpackChunkName: 'signup-bundle' */ '@/components/Landing/Faq'),
      Steps: () => import(/* webpackChunkName: 'signup-bundle' */ './Steps/Steps'),
      Pricing: () => import(/* webpackChunkName: 'signup-bundle' */ '@/components/Landing/Pricing'),
    },
  };
</script>
