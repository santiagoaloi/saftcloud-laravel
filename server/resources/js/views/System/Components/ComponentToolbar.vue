<template>
  <div>
    <div class="box">
      <div>
        <v-card style="border-right: 1px solid grey" width="350" tile flat>
          <v-list color="#24292e">
            <v-list-item :ripple="false" @click="menuGroups = !menuGroups">
              <v-list-item-avatar>
                <v-icon>mdi-responsive</v-icon>
              </v-list-item-avatar>

              <v-list-item-content>
                <v-list-item-title class="blue--text">Component Groups</v-list-item-title>
                <v-list-item-subtitle>+7 Selected</v-list-item-subtitle>
              </v-list-item-content>

              <v-list-item-icon>
                <v-icon right> {{ menuGroups ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
              </v-list-item-icon>
            </v-list-item>
          </v-list>
        </v-card>

        <v-expand-transition>
          <v-card
            v-if="menuGroups"
            v-click-outside="onClickOutside"
            style="z-index: 1; position: absolute"
            height="50vh"
            width="350"
            elevation="5"
          >
          </v-card>
        </v-expand-transition>
      </div>

      <div>
        <v-card style="border-right: 1px solid grey" width="350" tile flat>
          <v-list color="#24292e">
            <v-list-item :ripple="false" @click="menuGroups1 = !menuGroups1">
              <v-list-item-avatar>
                <v-icon>mdi-responsive</v-icon>
              </v-list-item-avatar>

              <v-list-item-content>
                <v-list-item-title class="blue--text">Component Groups</v-list-item-title>
                <v-list-item-subtitle>+7 Selected</v-list-item-subtitle>
              </v-list-item-content>

              <v-list-item-icon>
                <v-icon right> {{ menuGroups ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
              </v-list-item-icon>
            </v-list-item>
          </v-list>
        </v-card>

        <v-expand-transition>
          <v-card
            v-if="menuGroups1"
            v-click-outside="onClickOutside"
            style="z-index: 1; position: absolute"
            height="50vh"
            width="350"
            elevation="5"
          >
          </v-card>
        </v-expand-transition>
      </div>
    </div>

    <v-divider></v-divider>
  </div>
</template>

<script>
  import { get, sync } from 'vuex-pathify';

  export default {
    name: 'ComponentsToolbar',
    data() {
      return {
        menuGroups: false,
        menuGroups1: false,
      };
    },

    methods: {
      onClickOutside() {
        this.menuGroups = false;
      },
    },
    computed: {
      ...sync('theme', ['isDark']),
    },
  };
</script>
<style scoped>
  .testList {
    min-height: 87vh;
    width: 320px;
    position: absolute;
    z-index: 99;
  }

  .box {
    display: flex;
    align-items: stretch;
  }
</style>
