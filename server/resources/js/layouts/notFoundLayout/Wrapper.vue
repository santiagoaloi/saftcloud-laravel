<template>
  <not-found-view />
</template>

<script>
  export default {
    name: 'PublicWrapper',
    components: {
      NotFoundView: () => import(/* webpackChunkName: 'not-found-view' */ './View'),
    },
  };
</script>
