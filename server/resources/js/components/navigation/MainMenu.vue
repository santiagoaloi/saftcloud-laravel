<template>
  <v-list rounded nav dense class="pa-3">
    <div v-for="(item, index) in menu" :key="index">
      <div v-if="item.key || item.text" class="pa-1 mt-2 overline">
        {{ item.text }}
      </div>
      <nav-menu :menu="item.items" />
    </div>
  </v-list>
</template>

<script>
  import NavMenu from './NavMenu';

  export default {
    components: {
      NavMenu,
    },
    props: {
      menu: {
        type: Array,
        default: () => [],
      },
    },
  };
</script>
