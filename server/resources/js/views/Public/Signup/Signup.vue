<template>
  <div>
    <Parent v-show="show" />
  </div>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'Signup',

    components: {
      Parent: () => import(/* webpackChunkName: 'Parent' */ './Parent'),
    },

    data() {
      return {
        show: false,
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
    },

    mounted() {
      this.$nextTick(() => {
        this.show = true;
      });
    },
  };
</script>
