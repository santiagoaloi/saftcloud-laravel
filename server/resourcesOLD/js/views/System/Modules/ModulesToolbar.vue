<template>
  <div>
    <v-card class="transparent" flat tile>
      <v-card-actions class="px-4">
        <!-- <v-spacer></v-spacer> -->
        <v-btn color="#373b4f" @click="dialogGroups = true"
          ><v-icon left small> mdi-vector-arrange-above</v-icon> Selected Groups ({{ selectedModuleGroups.length }})
          <v-icon>mdi-chevron-down</v-icon>
        </v-btn>
        <v-btn color="#373b4f"><v-icon left small> mdi-cog</v-icon> Manage Groups </v-btn>
        <v-btn color="#373b4f" @click="dialogEditor = true"><v-icon left small> mdi-cog</v-icon>Module Structure </v-btn>
        <v-btn color="#373b4f" @click="dialogModules = true"><v-icon left small> mdi-plus</v-icon>Add Module </v-btn>
        <v-spacer></v-spacer>

        <v-btn class="mr-3" :disabled="isAllFilteredModulesEmpty" plain @click="isTableLayout = !isTableLayout">
          <v-icon left>
            {{ isTableLayout ? ' mdi-view-grid-outline' : ' mdi-format-list-bulleted-square' }}
          </v-icon>
          {{ isTableLayout ? 'Grid' : 'List' }}
        </v-btn>

        <v-menu bottom left offset-y>
          <template #activator="{ on }">
            <v-btn x-small fab class="mr-3" color="white" text dark plain v-on="on">
              <v-icon> mdi-filter-outline </v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item v-for="(item, i) in sortMenuItemsFiltered" :key="i" @click="setOrderFilter(item.filter)">
              <v-icon class="mr-5">
                {{ item.icon }}
              </v-icon>
              <v-list-item-title class="mr-5">
                {{ item.title }}
              </v-list-item-title>
              <v-icon>
                {{ sortOrderAsc ? 'mdi-chevron-up' : 'mdi-chevron-down' }}
              </v-icon>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';

  export default {
    name: 'ModulesToolbar',

    data() {
      return {
        dialog: false,
        currentItem: '',
        sortMenuItems: [
          {
            icon: 'mdi-sort-alphabetical-ascending',
            filter: 'alpha',
            title: 'Name',
            view: ['table', 'grid'],
          },
          {
            icon: 'mdi-format-list-numbered',
            filter: 'Module Count',
            title: 'Module count',
            view: ['grid'],
          },
        ],
      };
    },
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('loaders', ['dialogModulesLoader']),
      ...get('modulesManagement', ['isAllFilteredModulesEmpty']),
      ...sync('modulesManagement', [
        'dialogModules',
        'dialogEditor',
        'dialogGroups',
        'sortOrderAsc',
        'sortFilter',
        'isTableLayout',
        'selectedModuleGroups',
      ]),

      currentView() {
        return this.isTableLayout ? 'table' : 'grid';
      },

      sortMenuItemsFiltered() {
        return this.sortMenuItems.filter((menu) => menu.view.includes(this.currentView));
      },
    },

    methods: {
      ...call('modulesManagement', ['selectGroup']),

      setOrderFilter(filter) {
        this.sortFilter = filter;
        this.sortOrderAsc = !this.sortOrderAsc;
      },

      dialogModulesTrigger() {
        this.dialogModules = true;
        this.dialogModulesLoader = true;
      },
    },
  };
</script>
