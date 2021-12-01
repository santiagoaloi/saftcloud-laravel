<template>
  <div class="box">
    <base-expandable-button
      v-model="selectedComponentGroupsMenuTrigger"
      title="Component Groups"
      subtitle="subtitle"
      icon="mdi-responsive"
      width="350"
      :z-index="zIndex"
      :nudge-top="56"
    >
      <template #listTop>
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
      </template>

      <v-sheet>
        <v-list>
          <v-list-item-group v-model="selectedComponentGroupsMenu" active-class="selected" multiple>
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
                      <h6>{{ countComponentsInGroup(item.id) }}</h6>
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

    <base-expandable-button title="Fetch Components" subtitle="Last fetched just now" icon="mdi-responsive" />

    <v-btn plain class="mx-2" @click="dialogEditor = true">
      <v-icon :left="$vuetify.breakpoint.lgAndUp" small> mdi-code-json </v-icon>{{ configStructureTitle }}
    </v-btn>

    <base-expandable-button
      v-model="dialogComponent"
      title="Create New Component"
      subtitle="There are 15 components"
      icon="mdi-responsive"
    >
    </base-expandable-button>

    <dialog-config-editor v-if="dialogEditor" />
  </div>
</template>

<script>
  import { sync } from 'vuex-pathify';
  import componentGroups from '@/mixins/componentGroups';

  export default {
    name: 'ComponentsToolbar',
    components: {
      DialogConfigEditor: () => import(/* webpackChunkName: 'components-dialog-config-editor' */ './DialogConfigEditor'),
    },
    mixins: [componentGroups],
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['dialogComponent', 'dialogEditor']),
      ...sync('loaders', ['dialogComponentLoader']),

      configStructureTitle() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Config Structure' : '';
      },

      createComponentTitle() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Create component' : '';
      },

      createGroupTitle() {
        return this.$vuetify.breakpoint.lgAndUp ? 'Create group' : '';
      },

      zIndex() {
        return this.selectedComponentGroupsMenuTrigger ? 8 : 3;
      },
    },

    created() {
      this.getGroups();
    },

    methods: {
      dialogComponentTrigger() {
        this.dialogComponent = true;
        this.dialogComponentLoader = true;
      },

      onClickOutside() {
        this.selectedComponentGroupsMenuTrigger = false;
      },

      activateMenu() {
        this.selectedComponentGroupsMenuTrigger = !this.selectedComponentGroupsMenuTrigger;
      },

      selectGroup(group) {
        const groupFound = this.selectedComponentGroups.find((g) => g.id === group.id);
        if (groupFound) {
          this.selectedComponentGroups = this.selectedComponentGroups.filter((g) => g.id !== group.id);
        } else {
          this.selectedComponentGroups = [...this.selectedComponentGroups, group];
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
