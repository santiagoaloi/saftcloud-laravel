<template>
  <v-navigation-drawer permanent src="storage/appbar/prism2.jpg" color="#2f3136" width="250" clipped height="100%">
    <edit-sheet-menu :menu="menu" v-on="$listeners" />
  </v-navigation-drawer>
</template>

<script>
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
  };
</script>
