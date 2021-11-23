<template>
  <h4 class="white--text ml-8">
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
