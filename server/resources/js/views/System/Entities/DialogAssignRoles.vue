<template>
  <baseDialog
    v-model="dialogAssignRoles"
    transition="fade-transition"
    width="40vw"
    title="Assign Roles"
    filled
    icon="mdi-lock-open-outline"
    no-container
    @close="dialogAssignRoles = false"
    @save="saveAssignRoles()"
  >
    <v-card flat width="100%" class="dialogHeight">
      <v-container>
        <v-autocomplete
          v-model="selectedEntity.role"
          outlined
          :color="isDark ? '#208ad6' : 'grey'"
          item-color="indigo lighten-4"
          :background-color="isDark ? '#28292b' : 'white'"
          :items="allRoles"
          :maxlength="25"
          item-value="id"
          item-text="name"
          hide-no-data
          hide-details
          multiple
          dense
          return-object
        >
          <template #selection="data">
            <v-chip
              v-if="data.index === 0"
              :style="isDark ? 'color: white' : 'color:black'"
              :color="isDark ? 'grey-darken-4' : 'blue-white'"
              small
            >
              {{ selectedEntity.role.length }} roles selected.
            </v-chip>
          </template>
        </v-autocomplete>
      </v-container>
    </v-card>
  </baseDialog>
</template>
<script>
  import { sync, get, call } from 'vuex-pathify';

  export default {
    name: 'DialogPrivileges',

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('entitiesManagement', ['dialogAssignRoles', 'allRoles', 'selectedUserRoles']),
      ...get('entitiesManagement', ['selectedEntity']),
    },

    methods: {
      ...call('entitiesManagement/*'),
    },
  };
</script>
<style>
  .dialogHeight {
    height: calc(40vh - 300px);
    overflow-y: auto;
  }
</style>
