<template>
  <v-list-item-group v-model="selectedMennuItem" mandatory>
    <v-list class="pa-2 text-start" dark nav dense>
      <template v-for="(item, i) in menu">
        <div v-if="item.header" :key="i" class="pa-1 mt-2 overline">
          {{ item.header }}
        </div>
        <v-list-item v-else :key="i" :disabled="i === selectedMennuItem + 1" @click="switchActiveSheet(item.route)">
          <v-list-item-icon>
            <v-icon small :class="{ 'grey--text': item.disabled }">
              {{ item.icon || 'mdi-circle-medium' }}
            </v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title v-html="item.text" />
            <v-list-item-subtitle v-html="item.group" />
          </v-list-item-content>
        </v-list-item>
      </template>
    </v-list>
  </v-list-item-group>
</template>

<script>
  export default {
    name: 'ModulesEditSheetMenu',
    props: {
      menu: {
        type: [Array],
        default: () => [],
      },
    },

    data() {
      return {
        selectedMennuItem: 0,
      };
    },
    mounted() {
      this.switchActiveSheet(this.menu[1].route);
    },

    methods: {
      switchActiveSheet(sheet) {
        this.$emit('switchActiveSheet', sheet);
      },
    },
  };
</script>
