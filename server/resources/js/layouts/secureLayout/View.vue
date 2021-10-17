<template>
  <v-main>
    <v-container style="height: calc(100vh - 105px)" fluid>
      <v-fade-transition mode="out-in" :duration="400" hide-on-leave>
        <router-view />
      </v-fade-transition>
    </v-container>
    <Status-bar v-if="$route.name.startsWith('Components')" />
  </v-main>
</template>

<script>
  export default {
    name: 'SecureView',
    components: {
      StatusBar: () => import(/* webpackChunkName: 'components-status-bar' */ './StatusBar'),
    },
  };
</script>
