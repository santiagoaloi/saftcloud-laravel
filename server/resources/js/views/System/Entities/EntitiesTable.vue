<template>
  <div>
    <v-data-table
      v-model="selectedEntityTableRow"
      fixed-header
      checkbox-color="primary"
      item-key="id"
      :height="calculateHeight()"
      :headers="headers"
      :items="allEntititesFiltered"
      style="cursor: pointer"
      calculate-widths
      @click:row="rowClicked"
    >
      <template #[`item.avatar`]="{ item }">
        <v-hover v-slot="{ hover }">
          <v-avatar
            class="cursor-pointer"
            size="35"
            rounded
            :color="item.config_settings.icon.color"
            @click="setModulesTableIcon(item), (dialogIcons = true)"
          >
            <v-expand-transition>
              <div v-if="hover" class="d-flex black v-card--reveal white--text" style="height: 100%">
                <v-icon size="20" dark> mdi-pencil </v-icon>
              </div>
            </v-expand-transition>
            <v-fade-transition hide-on-leave>
              <v-icon v-if="!hover" size="20" dark>
                {{ item.config_settings.icon.name }}
              </v-icon>
            </v-fade-transition>
          </v-avatar>
        </v-hover>
      </template>

      <template #[`item.name`]="{ item }">
        <router-link :class="{ 'grey--text': isDark }" :to="`/${item.name}`">
          {{ item.name }}
        </router-link>
      </template>

      <template #[`item.group`]="{ item }">
        <v-icon style="margin-top: -2px" class="mr-1" small> mdi-folder-outline </v-icon>
        <template v-if="mapModulesGroup(item).module_group_id">
          {{ mapGroupParent(item) }} <v-icon small> mdi-menu-right </v-icon>
        </template>
        {{ mapModulesGroup(item).name }}
      </template>

      <template #[`item.config.general_config.title`]="{ item }">
        <span class="gallery-card-title pl-2">
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
    <base-dialog-icons v-if="dialogIcons" v-model="dialogIcons" :icon="ModulesIcon" />
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';
  import modulesActions from '@/mixins/modulesActions';

  export default {
    name: 'EntitiesTableView',
    mixins: [modulesActions],
    data() {
      return {
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
        dialogIcons: false,
        ModulesIcon: '',
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('entitiesManagement', ['selectedEntityTableRow', 'entityCardGroup']),
      ...get('entitiesManagement', [
        'allEntitiesFiltered',
        'isStarredColor',
        'isStarredIcon',
        'isModularColor',
        'isModularIcon',
        'isActiveColor',
        'isActiveIcon',
        'hasUnsavedChanges',
      ]),
    },

    methods: {
      ...call('entitiesManagement/*'),

      setModulesTableIcon(item) {
        this.ModulesIcon = item.config_settings.icon;
      },

      rowClicked(row) {
        this.toggleSelection(row.id, row);
        const index = this.allEntitiesFiltered.findIndex((ent) => ent.id === row.id);
        this.entityCardGroup = index;
        this.setSelectedEntity(index);
      },

      toggleSelection(id, row) {
        this.selectedModuleTableRow = [row];
      },

      calculateHeight() {
        return Number(this.$vuetify.breakpoint.height - 270);
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
