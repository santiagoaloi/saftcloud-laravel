<template>
  <Wrapper />
</template>

<script>
  export default {
    name: 'Signup',
    components: {
      Wrapper: () => import(/* webpackChunkName: 'signup-bundle' */ './Wrapper'),
    },
  };
</script>
