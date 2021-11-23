<template>
  <div class="h-full select-none">
    <v-data-table
      v-model="selectedComponentTableRow"
      height="100%"
      fixed-header
      item-key="id"
      :headers="headers"
      :items="allComponentsFiltered"
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
        <v-icon style="margin-top: -2px" class="mr-1" small> mdi-folder-outline </v-icon>
        <template v-if="mapComponentGroup(item).component_group_id">
          {{ mapGroupParent(item) }} <v-icon small> mdi-menu-right </v-icon>
        </template>
        {{ mapComponentGroup(item).name }}
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
  import componentActions from '@/mixins/componentActions';

  export default {
    name: 'ComponentsTableView',
    mixins: [componentActions],
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
            text: 'Component',
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
        componentIcon: '',
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...get('componentManagement', [
        'allComponentsFiltered',
        'isStarredColor',
        'isStarredIcon',
        'isModularColor',
        'isModularIcon',
        'isActiveColor',
        'isActiveIcon',
        'mapComponentGroup',
        'mapGroupParent',
        'hasUnsavedChanges',
        'selectedComponent',
      ]),
      ...sync('componentManagement', ['selectedComponentTableRow', 'componentCardGroup', 'componentEditSheet']),
    },

    watch: {
      componentCardGroup: {
        immediate: true,
        handler(newValue, oldValue) {
          if (newValue !== oldValue) {
            this.selectedComponentTableRow = [this.allComponentsFiltered[this.componentCardGroup]];
          }
        },
      },
    },

    methods: {
      ...call('componentManagement/*'),
      ...call('snackbar/*'),

      validateBeforeEdit() {
        if (this.selectedComponent.config.general_config.title) {
          this.componentEditSheet = !this.componentEditSheet;
        } else {
          this.snackbarError('There are input validation errors');
        }
      },

      rowClicked(row) {
        this.toggleSelection(row.id, row);
        const index = this.allComponentsFiltered.findIndex((component) => component.id === row.id);
        this.componentCardGroup = index;
        this.setSelectedComponent(index);
      },

      toggleSelection(id, row) {
        this.selectedComponentTableRow = [row];
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
