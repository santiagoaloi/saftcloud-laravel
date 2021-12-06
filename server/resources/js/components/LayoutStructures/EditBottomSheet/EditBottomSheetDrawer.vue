<template>
  <v-navigation-drawer color="#434750" permanent width="250" clipped height="100%">
    <edit-sheet-menu :menu="menu" v-on="$listeners" />
  </v-navigation-drawer>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'ComponentsEditSheetDrawer',
    components: {
      EditSheetMenu: () => import('./EditBottomSheetMenu'),
    },
    props: {
      menu: {
        type: [Array],
        default: () => [],
      },
    },

    computed: {
      ...sync('theme', ['isDark']),
    },
  };
</script>
