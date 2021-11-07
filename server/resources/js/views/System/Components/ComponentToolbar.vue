<template>
  <div>
    <div class="box">
      <div>
        <v-card style="border-right: 1px solid grey" class="transparent" width="350" tile flat>
          <v-list color="transparent">
            <v-list-item :ripple="false" @click="menuGroups = !menuGroups">
              <v-list-item-avatar>
                <v-icon>mdi-responsive</v-icon>
              </v-list-item-avatar>

              <v-list-item-content>
                <h5 class="indigo--text text--lighten-2">Component Groups</h5>
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
        <v-card style="border-right: 1px solid grey" class="transparent" width="350" tile flat>
          <v-list color="transparent">
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

      <v-spacer></v-spacer>

      <v-btn
        tile
        large
        class="ml-2"
        :color="isDark ? '#373b4f' : 'primary'"
        @click.stop="dialogComponent = true"
      >
        <v-icon :left="$vuetify.breakpoint.lgAndUp" small> mdi-view-grid-plus </v-icon
        >{{ createComponentTitle }}
      </v-btn>

      <v-btn
        tile
        large
        class="ml-2"
        :color="isDark ? '#373b4f' : 'primary'"
        @click="addGroupDialog()"
      >
        <v-icon :left="$vuetify.breakpoint.lgAndUp" small> mdi-view-grid-plus </v-icon
        >{{ createGroupTitle }}
      </v-btn>
    </div>

    <v-divider></v-divider>
  </div>
</template>

<script>
  import { get, sync } from 'vuex-pathify';
  import componentGroups from '@/mixins/componentGroups';

  export default {
    name: 'ComponentsToolbar',
    mixins: [componentGroups],
    data() {
      return {
        menuGroups: false,
        menuGroups1: false,
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['dialogComponent', 'dialogEditor']),

      configStructureTitle() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Config Structure' : '';
      },

      createComponentTitle() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Create component' : '';
      },

      createGroupTitle() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Create group' : '';
      },

      methods: {
        onClickOutside() {
          this.menuGroups = false;
        },
      },
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
</style>
