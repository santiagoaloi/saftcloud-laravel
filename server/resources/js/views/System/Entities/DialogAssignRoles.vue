<template>
  <baseDialog
    v-model="dialogAssignRoles"
    transition="fade-transition"
    width="40vw"
    title="Assign Roles"
    filled
    icon="mdi-lock-open-outline"
    no-container
    close-only
    @close="dialogAssignRoles = false"
  >
    <v-card flat width="100%" class="dialogHeight">
      <v-container>
        <v-autocomplete
          outlined
          :color="isDark ? '#208ad6' : 'grey'"
          item-color="indigo lighten-4"
          :background-color="isDark ? '#28292b' : 'white'"
          :items="allRoles"
          :maxlength="25"
          item-value="name"
          item-text="name"
          hide-no-data
          hide-details
          multiple
          dense
        >
        </v-autocomplete>
      </v-container>
    </v-card>
  </baseDialog>
</template>
<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'DialogPrivileges',

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('entitiesManagement', ['dialogAssignRoles', 'allRoles']),
    },
  };
</script>
<style>
  .dialogHeight {
    height: calc(80vh - 300px);
    overflow-y: auto;
  }
</style>
