<template>
  <div>
    <SignupWrapper />
  </div>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'Signup',

    components: {
      SignupWrapper: () => import(/* webpackChunkName: 'Parent' */ './Parent'),
    },

    computed: {
      ...sync('theme', ['isDark']),
    },
  };
</script>
