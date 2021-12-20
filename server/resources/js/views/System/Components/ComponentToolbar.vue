<template>
  <div>
    <v-tabs v-model="currentItem" class="left" optional background-color="#222530e6" grow show-arrows color="white" hide-slider>
      <v-tab v-for="item in items" :key="(item, i)" active-class="gridCardDark" :ripple="false" @click="select(i)">
        <div class="mx-6 mt-1">
          <v-icon class="mt-n1" size="19" left> {{ item.icon }} </v-icon>
          <span>{{ item.name }}</span>
        </div>
      </v-tab>
    </v-tabs>

    <base-dialog
      v-model="dialog"
      close-only
      no-gutters
      width="60vw"
      title="Selected groups"
      icon="mdi-home"
      @close="
        dialog = false;
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
        <v-list-item-group v-model="selectedComponentGroupsMenu" active-class="selected" multiple>
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
                    <h6>{{ countComponentsInGroup(item.id) }}</h6>
                  </v-avatar>
                </v-list-item-action>
              </template>
            </v-list-item>

            <v-divider v-if="index < allGroups.length - 1" :key="index"></v-divider>
          </template>
        </v-list-item-group>
      </v-list>
    </base-dialog>
  </div>
</template>

<script>
  import { sync, call } from 'vuex-pathify';
  import componentGroups from '@/mixins/componentGroups';

  export default {
    name: 'ComponentsToolbar',
    components: {
      DialogConfigEditor: () => import(/* webpackChunkName: 'components-dialog-config-editor' */ './DialogConfigEditor'),
    },
    mixins: [componentGroups],

    data() {
      return {
        dialog: false,
        currentItem: '',
        items: [
          {
            name: 'Selected Groups',
            icon: 'mdi-vector-arrange-above',
          },
          {
            name: 'Select Groups',
            icon: 'mdi-home',
          },
          {
            name: 'Select Groups',
            icon: 'mdi-home',
          },
          {
            name: 'Select Groups',
            icon: 'mdi-home',
          },
        ],
      };
    },
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
      ...call('componentManagement', ['selectGroup']),

      select(item) {
        if (this.currentItem) {
          this.currentItem = '';
        } else {
          this.currentItem = item;
        }
      },

      // selectGroup(group) {
      //   const groupFound = this.selectedComponentGroups.find((g) => g.id === group.id);
      //   if (groupFound) {
      //     this.selectedComponentGroups = this.selectedComponentGroups.filter((g) => g.id !== group.id);
      //   } else {
      //     this.selectedComponentGroups = [...this.selectedComponentGroups, group];
      //   }
      // },

      addItem(item) {
        const removed = this.items.splice(0, 1);
        this.items.push(...this.more.splice(this.more.indexOf(item), 1));
        this.more.push(...removed);
        this.$nextTick(() => {
          this.currentItem = `tab-${item}`;
        });
      },

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
    },
  };
</script>
<style scoped>
  .selected {
    background-color: #08082c;
  }
</style>
