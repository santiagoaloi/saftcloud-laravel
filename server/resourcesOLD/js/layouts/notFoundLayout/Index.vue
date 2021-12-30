<template>
  <Wrapper />
</template>

<script>
  export default {
    name: 'PublicLayout',
    components: {
      Wrapper: () => import(/* webpackChunkName: 'public-bundle' */ './Wrapper'),
    },
  };
</script>
