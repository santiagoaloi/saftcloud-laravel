<template>
  <fragment>
    <!-- Navigation -->
    <v-navigation-drawer v-model="secureDefaultDrawer" dark width="250" app class="elevation-1 select-none">
      <!-- Navigation menu fixed  -->
      <template #prepend>
        <vue-diagonal
          class="mt-n5"
          :deg="-7"
          background="linear-gradient(331deg, rgba(34, 37, 48, 1) 0%, rgba(0, 10, 20 , 0.4) 0%)"
          space-after
          space-before
        >
          <v-container>
            <div class="title font-weight-bold">SaftCloud ™</div>
            <div class="overline white--text">v5.0.2</div>
            <div class="mx-auto mx-1 d-flex flex-column justify-space-between align-center px-2">
              <v-badge offset-x="35" offset-y="16" bordered :color="badgeColor()" :content="badgeText()" bottom>
                <v-avatar size="160">
                  <v-img :src="user.avatar || 'storage/defaults/avatar.png'"></v-img>
                </v-avatar>
              </v-badge>

              <div style="max-width: 200px" class="title my-2 text-truncate d-inline-block">
                {{ fullName }}
              </div>

              <small style="max-width: 200px" class="mt-n2 mb-4 text-truncate d-inline-block grey--text">
                {{ user.email }}
              </small>
            </div>
            <div class="text-center">
              <v-menu
                v-model="secureModulesDrawerBranch"
                nudge-right="20"
                nudge-top="45"
                transition="fade-transition"
                :close-on-content-click="false"
                offset-x
              >
                <template #activator="{ on, attrs }">
                  <v-btn class="strech" :ripple="false" block rounded v-bind="attrs" v-on="on">
                    <v-icon size="25" color="teal accent-2" left>mdi-store</v-icon>

                    {{ activeBranchName }}

                    <v-icon size="25" color="teal accent-2" right>
                      {{ !secureModulesDrawerBranch ? 'mdi-chevron-down' : 'mdi-chevron-right' }}</v-icon
                    >
                  </v-btn>
                </template>

                <v-card class="mx-auto" max-width="400">
                  <v-toolbar color="primary darken-1" dark>
                    <v-app-bar-nav-icon></v-app-bar-nav-icon>

                    <v-toolbar-title>Branches</v-toolbar-title>

                    <v-spacer></v-spacer>

                    <v-btn icon>
                      <v-icon>mdi-magnify</v-icon>
                    </v-btn>

                    <v-btn icon>
                      <v-icon>mdi-checkbox-marked-circle</v-icon>
                    </v-btn>
                  </v-toolbar>

                  <v-card-title> Switch workspace</v-card-title>

                  <v-card-subtitle>
                    You can switch to another branch location anytime without loosing any changes in your current branch. Set a
                    default one, request accesss or remove them.
                  </v-card-subtitle>

                  <v-divider></v-divider>

                  <v-list>
                    <v-list-item-group v-model="selected" active-class="white--text" mandatory>
                      <template v-for="(branch, index) in user.branch">
                        <v-list-item :key="branch.id" @click="activeBranch = branch.id">
                          <template #default="{ active }">
                            <v-list-item-icon>
                              <v-icon :color="active ? 'indigo lighten-2' : 'grey'">
                                {{ active ? 'mdi-check-circle' : 'mdi-checkbox-blank-circle-outline' }}</v-icon
                              >
                            </v-list-item-icon>

                            <v-list-item-content>
                              <v-list-item-title v-text="branch.name || 'Default Branch'"></v-list-item-title>
                            </v-list-item-content>
                          </template>
                        </v-list-item>

                        <v-divider v-if="index < user.branch.length - 1" :key="branch.id"></v-divider>
                      </template>
                    </v-list-item-group>
                  </v-list>
                </v-card>
              </v-menu>
            </div>
          </v-container>
        </vue-diagonal>
      </template>

      <!-- Navigation menu -->
      <main-menu class="pa-2" :menu="navigationStructure.menu" />
    </v-navigation-drawer>
  </fragment>
</template>

<script>
  import Vue from 'vue';
  import { sync, call } from 'vuex-pathify';
  import capitalize from 'lodash/capitalize';

  Vue.component('MainMenu', () => import(/* webpackChunkName: 'modules-drawer-menu' */ '@/components/navigation/MainMenu'));

  // @vue/Modules
  export default {
    name: 'SecureDrawer',

    data() {
      return {
        menu: false,
        selected: [2],
        items: [
          {
            action: '15 min',
            headline: 'Brunch this weekend?',
            subtitle: `I'll be in your neighborhood doing errands this weekend. Do you want to hang out?`,
            title: 'Ali Connors',
          },
          {
            action: '2 hr',
            headline: 'Summer BBQ',
            subtitle: `Wish I could come, but I'm out of town this weekend.`,
            title: 'me, Scrott, Jennifer',
          },
          {
            action: '6 hr',
            headline: 'Oui oui',
            subtitle: 'Do you have Paris recommendations? Have you ever been?',
            title: 'Sandra Adams',
          },
          {
            action: '12 hr',
            headline: 'Birthday gift',
            subtitle: 'Have any ideas about what we should get Heidi for her birthday?',
            title: 'Trevor Hansen',
          },
          {
            action: '18hr',
            headline: 'Recipe to try',
            subtitle: 'We should eat this: Grate, Squash, Corn, and tomatillo Tacos.',
            title: 'Britta Holt',
          },
        ],
      };
    },

    computed: {
      ...sync('theme', ['overlay']),
      ...sync('drawers', ['secureDefaultDrawer', 'secureModulesDrawerBranch']),
      ...sync('modulesManagement', ['navigationStructure']),
      ...sync('authentication', ['session', 'activeBranch']),
      user: sync('authentication@session.user'),

      fullName() {
        return `${capitalize(this.user.entity.first_name)} ${capitalize(this.user.entity.last_name)}`;
      },

      activeBranchName() {
        const branch = this.user.branch.find((b) => b.id === this.activeBranch);
        return branch.name || 'Default Branch';
      },
    },

    created() {
      this.getNavigationStructure();
    },

    methods: {
      ...call('modulesManagement/*'),

      badgeText() {
        if (this.$root.isRoot) {
          return 'Root';
        }
        if (this.$root.isAdmin && this.$root.isRoot) {
          return 'Root';
        }
        if (this.$root.isAdmin) {
          return 'Admin';
        }
        return 'User';
      },

      badgeColor() {
        if (this.$root.isRoot) {
          return 'red';
        }
        if (this.$root.isAdmin && this.$root.isRoot) {
          return 'red';
        }
        if (this.$root.isAdmin) {
          return 'green';
        }
        return 'primary';
      },
    },
  };
</script>
