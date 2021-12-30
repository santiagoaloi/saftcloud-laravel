<template>
  <div class="box">
    <base-expandable-button
      v-model="selectedModuleGroupsMenuTrigger"
      title="Modules Groups"
      subtitle="subtitle"
      icon="mdi-responsive"
      width="350"
      :z-index="zIndex"
      :nudge-top="56"
    >
      <!-- <template #listTop>
        <v-sheet>
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
        </v-sheet>
      </template> -->

      <v-sheet>
        <v-list>
          <v-list-item-group v-model="selectedModuleGroupsMenu" active-class="selected" multiple>
            <template v-for="(item, index) in allGroups">
              <v-list-item :key="item.title" :ripple="false" @click.stop="selectGroup(item)">
                <template #default="{ active }">
                  <v-list-item-icon>
                    <v-icon :color="active ? 'indigo lighten-2' : 'grey'">
                      {{ active ? 'mdi-checkbox-blank-circle' : 'mdi-checkbox-blank-circle-outline' }}</v-icon
                    >
                  </v-list-item-icon>

                  <v-list-item-content>
                    <v-list-item-title v-text="item.name"></v-list-item-title>
                  </v-list-item-content>

                  <v-list-item-action>
                    <v-avatar class="white--text" size="30" color="#282c3b">
                      <h6>{{ countModulesInGroup(item.id) }}</h6>
                    </v-avatar>
                  </v-list-item-action>
                </template>
              </v-list-item>

              <v-divider v-if="index < allGroups.length - 1" :key="index"></v-divider>
            </template>
          </v-list-item-group>
        </v-list>
      </v-sheet>
    </base-expandable-button>

    <base-expandable-button title="Fetch Modules" subtitle="Last fetched just now" icon="mdi-responsive">
    </base-expandable-button>

    <base-expandable-button
      v-model="dialogModules"
      title="Create New Modules"
      subtitle="There are 15 Modules"
      icon="mdi-responsive"
    >
    </base-expandable-button>
  </div>
</template>

<script>
  import { sync } from 'vuex-pathify';
  import modulesGroups from '@/mixins/modulesGroups';

  export default {
    name: 'ModulesToolbar',
    mixins: [modulesGroups],

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('modulesManagement', ['dialogModules', 'dialogEditor']),
      ...sync('loaders', ['dialogModulesLoader']),

      configStructureTitle() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Config Structure' : '';
      },

      createmodulesTitle() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Create Modules' : '';
      },

      createGroupTitle() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Create group' : '';
      },

      zIndex() {
        return this.selectedModuleGroupsMenuTrigger ? 8 : 3;
      },
    },

    created() {
      this.getGroups();
    },

    methods: {
      dialogModulesTrigger() {
        this.dialogModules = true;
        this.dialogModulesLoader = true;
      },

      onClickOutside() {
        this.selectedModuleGroupsMenuTrigger = false;
      },

      activateMenu() {
        this.selectedModuleGroupsMenuTrigger = !this.selectedModuleGroupsMenuTrigger;
      },

      selectGroup(group) {
        const groupFound = this.selectedModuleGroups.find((g) => g.id === group.id);
        if (groupFound) {
          this.selectedModuleGroups = this.selectedModuleGroups.filter((g) => g.id !== group.id);
        } else {
          this.selectedModuleGroups = [...this.selectedModuleGroups, group];
        }
      },
    },
  };
</script>
<style scoped>
  .selected {
    background-color: #08082c;
  }
</style>
