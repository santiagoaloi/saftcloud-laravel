<template>
  <h4 class="white--text">
    {{ routeTitle }}
  </h4>
</template>

<script>
  // Utilities

  export default {
    name: 'BaseAppBarTitle',

    computed: {
      routeTitle() {
        return this.$route.meta.title;
      },
    },
  };
</script>
