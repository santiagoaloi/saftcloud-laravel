<template>
<<<<<<< HEAD
  <v-app>
    <public-bar />
    <public-view />
    <public-footer v-if="!$route.name.startsWith('Login')" />
    <snackbar />
  </v-app>
</template>

<script>
  import { sync } from 'vuex-pathify';

=======
  <Wrapper />
</template>

<script>
>>>>>>> c8d2fe2c4ddbb5aade247a79b9a77d7bdd4ee893
  export default {
    name: 'PublicLayout',

    components: {
      Wrapper: () => import(/* webpackChunkName: 'public-bundle' */ './Wrapper'),
    },
  };
</script>
