<template>
 <v-main>
  <v-container fluid>
   <v-fade-transition hide-on-leave>
    <router-view />
   </v-fade-transition>
  </v-container>
  <status-bar v-if="$route.name.startsWith('components')" />
 </v-main>
</template>

<script>
export default {
 name: "Secureview",
 components: {
  StatusBar: () => import(/* webpackChunkName: 'components-status-bar' */ "./StatusBar")
 }
};
</script>
