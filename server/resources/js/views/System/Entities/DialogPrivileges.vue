<template>
  <baseDialog
    v-model="dialogPrivileges"
    transition="fade-transition"
    width="40vw"
    title="Privileges"
    filled
    icon="mdi-lock-open-outline"
    no-container
    close-only
    @close="dialogPrivileges = false"
  >
    <v-text-field
      v-model="searchPrivileges"
      hide-details
      label="Search Privilege"
      prepend-inner-icon="mdi-magnify"
      autocomplete="off"
      autocorrect="off"
      autocapitalize="off"
      spellcheck="false"
      solo
      class="mb-2"
      :color="isDark ? '#208ad6' : 'grey'"
      :background-color="isDark ? '#28292b' : 'white'"
      :outlined="isDark"
      dense
    >
    </v-text-field>

    <v-card flat width="100%" class="dialogHeight">
      <v-container>
        <v-simple-table>
          <template #default>
            <thead>
              <tr>
                <th class="text-left">Privilege name</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, i) in filteredPrivileges" :key="item + i">
                <td>{{ item }}</td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-container>
    </v-card>
  </baseDialog>
</template>
<script>
  import { sync, get } from 'vuex-pathify';

  export default {
    name: 'DialogPrivileges',
    data() {
      return {
        headers: [
          {
            text: 'Privilege',
            align: 'start',
            value: 'privilege',
          },
        ],
      };
    },
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('entitiesManagement', ['dialogPrivileges', 'searchPrivileges']),
      ...get('entitiesManagement', ['selectedEntity', 'filteredPrivileges']),
    },
  };
</script>
<style>
  .dialogHeight {
    height: calc(80vh - 300px);
    overflow-y: auto;
  }
</style>
