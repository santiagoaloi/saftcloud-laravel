<template>
  <div>
    <v-responsive class="py-1" :width="$vuetify.breakpoint.mdAndUp ? 300 : null">
      <v-select
        v-model="selectedModuleGroups"
        multiple
        item-value="id"
        item-text="name"
        return-object
        placeholder="Select or create groups"
        :items="allGroups"
        solo
        :dark="isDark"
        hide-details
        :color="isDark ? '#208ad6' : 'grey'"
        item-color="primary lighten-4"
        :menu-props="{ bottom: true, offsetY: true }"
        @update:search-input="syncGroupInputValue($event)"
      >
        <template v-if="allGroups.length" #prepend-item>
          <v-list-item dense :ripple="false" @click.stop="selectAllGroups">
            <v-list-item-action>
              <v-icon class="ml-1">
                {{ icon }}
              </v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                {{ hasSelectedAllGroups ? 'Unselect all' : 'Select all' }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-divider />
        </template>

        <template #selection="data">
          <v-chip
            v-if="data.index === 0"
            small
            :style="isDark ? 'color: white' : 'color:black'"
            :color="isDark ? 'grey-darken-4' : 'blue-white'"
          >
            {{ selectedModuleGroups.length }} groups selected.
          </v-chip>
        </template>

        <template #item="{ item }">
          <v-list-item-action>
            <v-avatar class="white--text" tile size="30" color="primary">
              <h6>{{ countModulesInGroup(item.id) }}</h6>
            </v-avatar>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title> {{ item.name }} </v-list-item-title>
          </v-list-item-content>

          <v-tooltip transition="false" color="black" bottom>
            <template #activator="{ on }">
              <v-btn
                plain
                class="mr-2"
                :ripple="false"
                small
                depressed
                v-on="on"
                @click.stop="renameGroupDialog(item.id, item.name)"
              >
                <v-icon small> mdi-pencil-outline </v-icon>
              </v-btn>
            </template>
            <span>Edit group</span>
          </v-tooltip>

          <v-tooltip transition="false" color="black" bottom>
            <template #activator="{ on }">
              <v-btn
                plain
                :ripple="false"
                small
                depressed
                v-on="on"
                @click.stop="removeGroupWarning(item.id, item.name, 'delete')"
              >
                <v-icon small> mdi-delete-outline </v-icon>
              </v-btn>
            </template>
            <span>Remove group</span>
          </v-tooltip>
        </template>

        <template #no-data>
          <v-list-item @click="addGroupDialog()">
            <v-list-item-action>
              <v-icon> mdi-plus </v-icon>
            </v-list-item-action>

            <v-list-item-content>
              <v-list-item-title>
                <span>Create group </span>
                {{ formattedGroup }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-select>
    </v-responsive>

    <baseDialog
      v-if="modulesLinkedToGroupDialog"
      v-model="modulesLinkedToGroupDialog"
      width="700"
      title="Modules still linked to this group"
      icon="mdi-apps"
      @close="modulesLinkedToGroupDialog = !modulesLinkedToGroupDialog"
      @save="modulesLinkedToGroupDialog = !modulesLinkedToGroupDialog"
    >
      <v-expand-transition appear>
        <v-sheet v-if="modulesLinkedToGroup.length" color="transparent">
          <v-alert dismissible border="left" colored-border color="grey darken-2" elevation="2" class="text-left">
            <div>These componets are still associated with the group "{{ groupNameBeingRemoved }}"</div>
            <div>You can remove the Modules permanently and then remove the group.</div>
          </v-alert>
        </v-sheet>
      </v-expand-transition>

      <v-data-table
        v-if="modulesLinkedToGroup.length"
        checkbox-color="accent lighten-2"
        item-key="id"
        :headers="headers"
        :items="modulesLinkedToGroup"
        :items-per-page="-1"
      >
        <template #[`item.avatar`]="{ item }">
          <v-avatar class="cursor-pointer" size="30" rounded :color="item.config_settings.icon.color">
            <v-icon size="25" dark>
              {{ item.config_settings.icon.name }}
            </v-icon>
          </v-avatar>
        </template>

        <template #[`item.actions`]="{ item }">
          <v-menu origin="center center" transition="scale-transition" :nudge-bottom="10" offset-y>
            <template #activator="{ on }">
              <v-btn icon v-on="on">
                <v-icon>mdi-dots-vertical</v-icon>
              </v-btn>
            </template>

            <v-list class="pa-2" outlined>
              <v-list-item>
                <v-list-item-action>
                  <v-btn small icon dark color="#4C4C4C">
                    <v-icon color="grey darken-2" small class="mx-2"> mdi-pencil-outline </v-icon>
                  </v-btn>
                </v-list-item-action>
                <v-list-item-title>Restore </v-list-item-title>
              </v-list-item>

              <v-list-item @click.stop="removeModuleWarning(item.id, 'post', 'forceDestroy', item.config.general_config.title)">
                <v-list-item-action>
                  <v-btn small icon dark color="#4C4C4C">
                    <v-icon color="red lighten-2" small class="mx-2"> mdi-delete-outline </v-icon>
                  </v-btn>
                </v-list-item-action>
                <v-list-item-title>Remove permanently</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </template>
        <template #[`item.deleted_at`]="{ item }">
          <v-chip v-if="item.deleted_at"> Removed </v-chip>
          <v-chip v-else color="primary"> Active </v-chip>
        </template>
      </v-data-table>
      <v-btn
        v-if="!modulesLinkedToGroup.length"
        color="primary"
        @click="removeGroup(groupBeingRemoved), (modulesLinkedToGroupDialog = false)"
      >
        Try removing "{{ groupNameBeingRemoved }}" group again.
      </v-btn>
    </baseDialog>
  </div>
</template>

<script>
  import { sync, call } from 'vuex-pathify';
  import modulesGroups from '@/mixins/modulesGroups';
  import modulesActions from '@/mixins/modulesActions';

  export default {
    name: 'ModulesGroups',
    mixins: [modulesGroups, modulesActions],
    data() {
      return {
        removeAlert: true,
        dropDownValue: false,
        headers: [
          {
            text: 'Avatar',
            align: 'start',
            sortable: false,
            value: 'avatar',
          },
          {
            text: 'Modules',
            align: 'start',
            sortable: true,
            value: 'name',
          },
          {
            text: 'Status',
            align: 'center',
            sortable: true,
            value: 'deleted_at',
          },
          {
            text: 'Actions',
            align: 'end',
            sortable: false,
            value: 'actions',
          },
        ],
      };
    },

    computed: {
      ...sync('modulesManagement', ['modulesLinkedToGroupDialog', 'modulesLinkedToGroup', 'groupNameBeingRemoved']),
    },

    mounted() {
      this.getGroups();
    },

    methods: {
      ...call('modulesManagement/*'),
    },
  };
</script>
<style>
  .swalDarkTitle {
    color: white !important;
  }

  .swalDarkValidation {
    align-items: center;
    justify-content: center;
    margin: 0;
    padding: 0;
    background: transparent;
    color: white;
    font-size: 1em;
    font-weight: 300;
  }

  .swalDarkSelect {
    min-width: 100% !important;
    background: rgb(54, 57, 63) !important;
    color: white !important;
    border-radius: 8px;
    height: 50px;
  }
</style>
