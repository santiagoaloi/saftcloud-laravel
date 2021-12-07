<template>
  <div>
    <!-- menu level 1 -->
    <nav-menu-item v-for="(level1Item, level1Index) in menu" :key="level1Index" :menu-item="level1Item">
      <template v-if="level1Item.items">
        <!-- menu level 2 -->
        <nav-menu-item
          v-for="(level2Item, level2Index) in level1Item.items"
          :key="level2Index"
          :menu-item="level2Item"
          subgroup
          small
        >
        </nav-menu-item>
      </template>
    </nav-menu-item>
  </div>
</template>

<script>
  import NavMenuItem from './NavMenuItem';

  /*
|---------------------------------------------------------------------
| Navigation Menu Component
|---------------------------------------------------------------------
|
| Multi-layer navigation menu
|
| menu: [{ text: 'Menu Levels',
|    items: [
|      { text: 'Menu Levels 2.1' },
|      { text: 'Menu Levels 2.2',
|        items: [
|          { text: 'Menu Levels 3.1' },
|          { text: 'Menu Levels 3.2' }
|        ]
|      }
|    ]
|  }]
|
*/
  export default {
    components: {
      NavMenuItem,
    },
    props: {
      menu: {
        type: Array,
        default: () => [],
      },
    },
  };
</script>
