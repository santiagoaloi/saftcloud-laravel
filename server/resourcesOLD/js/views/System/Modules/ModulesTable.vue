<template>
  <div class="h-full select-none">
    <v-data-table
      v-model="selectedModuleTableRow"
      height="100%"
      fixed-header
      item-key="id"
      :headers="headers"
      :items="allModulesFilteredSorted"
      style="cursor: pointer"
      calculate-widths
      class="solidBackground px-3"
      @click:row="rowClicked"
      @dblclick:row="validateBeforeEdit"
    >
      <template #[`item.avatar`]="{ item }">
        <v-avatar class="cursor-pointer" size="35" rounded :color="item.config_settings.icon.color">
          <v-icon size="20" dark>
            {{ item.config_settings.icon.name }}
          </v-icon>
        </v-avatar>
      </template>

      <template #[`item.name`]="{ item }">
        <router-link :class="{ 'grey--text': isDark }" :to="`/${item.name}`">
          {{ item.name }}
        </router-link>
      </template>

      <template #[`item.group`]="{ item }">
        <!-- <v-icon style="margin-top: -2px" class="mr-1" small> mdi-folder-outline </v-icon>
        <template v-if="mapModulesGroup(item).module_group_id">
          {{ mapGroupParent(item) }} <v-icon small> mdi-menu-right </v-icon>
        </template>
        {{ mapModulesGroup(item).name }} -->

        <modules-grid-group-chips :modules="item" />
      </template>

      <template #[`item.config.general_config.title`]="{ item }">
        <span class="pl-2">
          <template v-if="item.config.general_config.title">
            {{ item.config.general_config.title }}
          </template>
          <template v-else>
            <base-typing-indicator class="ml-1 mt-2" style="zoom: 0.7" />
          </template>
        </span>
      </template>

      <template #[`item.status`]="{ item }">
        <v-tooltip v-if="hasUnsavedChanges(item)" transition="false" color="black" bottom>
          <template #activator="{ on }">
            <v-btn color="white" small icon :ripple="false" v-on="on">
              <v-icon :color="isDark ? 'white' : '#28292b'"> mdi-alert-outline </v-icon>
            </v-btn>
          </template>
          <span>Unsaved</span>
        </v-tooltip>

        <v-tooltip transition="false" color="black" bottom>
          <template #activator="{ on }">
            <v-btn color="white" small icon :ripple="false" v-on="on" @click.stop="setStarred(item)">
              <v-icon :color="isStarredColor(item)">
                {{ isStarredIcon(item) }}
              </v-icon>
            </v-btn>
          </template>
          <span>Favourite</span>
        </v-tooltip>

        <v-tooltip transition="false" color="black" bottom>
          <template #activator="{ on }">
            <v-btn color="white" small icon :ripple="false" v-on="on" @click.stop="setModular(item)">
              <v-icon :color="isModularColor(item)">
                {{ isModularIcon(item) }}
              </v-icon>
            </v-btn>
          </template>
          <span>Modular</span>
        </v-tooltip>

        <v-tooltip transition="false" color="black" bottom>
          <template #activator="{ on }">
            <v-btn color="white" small icon :ripple="false" v-on="on" @click.stop="setActive(item)">
              <v-icon :color="isActiveColor(item)">
                {{ isActiveIcon(item) }}
              </v-icon>
            </v-btn>
          </template>
          <span>Active</span>
        </v-tooltip>
      </template>
    </v-data-table>
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';
  import modulesActions from '@/mixins/modulesActions';

  export default {
    name: 'ModulesTableView',
    components: {
      ModulesGridGroupChips: () => import('./ModulesGridGroupChips'),
    },
    mixins: [modulesActions],
    data() {
      return {
        contentHeight: 0,
        headers: [
          {
            text: 'Avatar',
            align: 'start',
            sortable: false,
            value: 'avatar',
            width: 0,
          },
          {
            text: 'Modules',
            align: 'start',
            sortable: true,
            value: 'config.general_config.title',
          },

          {
            text: 'Route',
            align: 'end',
            value: 'name',
            divider: true,
          },

          {
            text: 'Group',
            align: 'end',
            value: 'group',
            divider: true,
          },

          {
            text: 'Status',
            align: 'end',
            sortable: false,
            value: 'status',
            width: 160,
          },
        ],
        modulesIcon: '',
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...get('modulesManagement', [
        'allModulesFilteredSorted',
        'isStarredColor',
        'isStarredIcon',
        'isModularColor',
        'isModularIcon',
        'isActiveColor',
        'isActiveIcon',
        'mapModulesGroup',
        'mapGroupParent',
        'hasUnsavedChanges',
        'selectedModule',
      ]),
      ...sync('modulesManagement', ['selectedModuleTableRow', 'modulesEditSheet']),
    },

    // watch: {
    //   modulesCardGroup: {
    //     immediate: true,
    //     handler(newValue, oldValue) {
    //       if (newValue !== oldValue) {
    //         this.selectedModuleTableRow = [this.allModulesFiltered[this.modulesCardGroup]];
    //       }
    //     },
    //   },
    // },

    methods: {
      ...call('modulesManagement/*'),
      ...call('snackbar/*'),

      validateBeforeEdit() {
        if (this.selectedModule.config.general_config.title) {
          this.modulesEditSheet = !this.modulesEditSheet;
        } else {
          this.snackbarError('There are input validation errors');
        }
      },

      rowClicked(row) {
        this.toggleSelection(row.id, row);
        const index = this.allModulesFiltered.findIndex((Modules) => Modules.id === row.id);
        // this.modulesCardGroup = index;
        this.setselectedModule(index);
      },

      toggleSelection(id, row) {
        this.selectedModuleTableRow = [row];
      },
    },
  };
</script>

<style scoped>
  .v-card--reveal {
    align-items: center;
    bottom: 0;
    justify-content: center;
    opacity: 0.5;
    position: absolute;
    width: 100%;
  }
</style>
