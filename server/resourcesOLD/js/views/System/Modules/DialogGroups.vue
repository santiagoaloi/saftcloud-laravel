<template>
  <base-dialog
    v-model="dialogGroups"
    close-only
    no-gutters
    width="60vw"
    title="Selected groups"
    icon="mdi-home"
    @close="
      dialogGroups = false;
      currentItem = '';
    "
  >
    <template #top>
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

    <v-list>
      <v-list-item-group v-model="selectedModuleGroupsMenu" active-class="selected" multiple>
        <template v-for="(item, index) in allGroups">
          <v-list-item :key="item.title" :ripple="false" @click.stop="selectGroup({ item })">
            <template #default="{ active }">
              <v-list-item-icon>
                <v-icon :color="active ? 'indigo lighten-2' : 'grey'">
                  {{ active ? 'mdi-check-circle' : 'mdi-checkbox-blank-circle-outline' }}</v-icon
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
  </base-dialog>
</template>
<script>
  import { sync, call, get } from 'vuex-pathify';

  export default {
    name: 'DialogGroups',

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('modulesManagement', ['dialogGroups', 'allGroups', 'selectedModuleGroupsMenu']),
      ...get('modulesManagement', ['countModulesInGroup']),
    },

    watch: {
      currentItem(newValue) {
        if (newValue === 0) {
          this.dialog = true;
        }
      },
    },

    created() {
      this.getGroups();
    },

    methods: {
      ...call('modulesManagement/*'),
    },
  };
</script>
<style scoped>
  .selected {
    background-color: #08082c;
  }
</style>
