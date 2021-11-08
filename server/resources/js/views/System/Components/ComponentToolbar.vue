<template>
  <div>
    <div class="box">
      <div :style="`z-index: ${zindex}`">
        <v-card style="border-right: 1px solid grey" class="transparent" width="350" tile flat>
          <v-list>
            <v-list-item :ripple="false" @click="activateMenu()">
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
            v-if="selectedComponentGroupsMenuTrigger"
            v-click-outside="onClickOutside"
            style="z-index: 1; position: absolute"
            width="350"
            elevation="5"
          >
            <v-card-actions class="px-1">
              <v-list-item class="px-1">
                <v-text-field
                  placeholder="Filter groups"
                  dense
                  solo
                  :outlined="isDark"
                  :color="isDark ? '#208ad6' : 'grey'"
                  :background-color="isDark ? '#28292b' : 'white'"
                  hide-details
                >
                </v-text-field>

                <v-row class="pl-4 mr-0" align="center" justify="end">
                  <v-btn height="40" block> Add </v-btn>
                </v-row>
              </v-list-item>
            </v-card-actions>

            <v-list>
              <v-list-item-group
                v-model="selectedComponentGroupsMenu"
                active-class="selected"
                multiple
              >
                <template v-for="(item, index) in allGroups">
                  <v-list-item :key="item.title" :ripple="false" @click="selectGroup(item)">
                    <template #default="{ active }">
                      <v-list-item-icon>
                        <v-icon :color="active ? 'indigo lighten-2' : 'grey'">
                          {{
                            active
                              ? 'mdi-checkbox-blank-circle'
                              : 'mdi-checkbox-blank-circle-outline'
                          }}</v-icon
                        >
                      </v-list-item-icon>

                      <v-list-item-content>
                        <v-list-item-title v-text="item.name"></v-list-item-title>
                      </v-list-item-content>

                      <v-list-item-action>
                        <v-avatar class="white--text" size="30" color="#282c3b">
                          <h6>{{ countComponentsInGroup(item.id) }}</h6>
                        </v-avatar>
                      </v-list-item-action>
                    </template>
                  </v-list-item>

                  <v-divider v-if="index < allGroups.length - 1" :key="index"></v-divider>
                </template>
              </v-list-item-group>
            </v-list>
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
  import { sync } from 'vuex-pathify';
  import componentGroups from '@/mixins/componentGroups';

  export default {
    name: 'ComponentsToolbar',
    mixins: [componentGroups],
    data() {
      return {
        menuGroups: false,
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

      zindex() {
        return this.selectedComponentGroupsMenuTrigger ? 8 : 3;
      },
    },

    created() {
      this.getGroups();
    },

    methods: {
      onClickOutside() {
        this.selectedComponentGroupsMenuTrigger = false;
      },

      activateMenu() {
        this.selectedComponentGroupsMenuTrigger = !this.selectedComponentGroupsMenuTrigger;
      },

      selectGroup(group) {
        const groupFound = this.selectedComponentGroups.find((g) => g.id === group.id);
        if (groupFound) {
          this.selectedComponentGroups = this.selectedComponentGroups.filter(
            (g) => g.id !== group.id,
          );
        } else {
          this.selectedComponentGroups = [...this.selectedComponentGroups, group];
        }
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

  .selected {
    background-color: red;
  }
</style>
