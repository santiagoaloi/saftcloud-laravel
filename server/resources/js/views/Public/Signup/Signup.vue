<template>
  <div>
    <Wrapper />
  </div>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'Signup',

    components: {
      Wrapper: () => import(/* webpackChunkName: 'signup-bundle' */ './Wrapper'),
    },

    computed: {
      ...sync('theme', ['isDark']),
    },
  };
</script>
