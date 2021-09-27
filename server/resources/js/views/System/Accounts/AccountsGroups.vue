<template>
  <div>
         <v-responsive width="500"> 
        <v-autocomplete
        v-model="selectedEntityType"
          item-value="id"
          item-text="name"
          item-color="primary"
          placeholder="Select roles o users"
          :maxlength="20"
          :items="['Roles', 'Accounts']"
          solo
          :color="isDark ? '#208ad6' : 'grey'"
          hide-no-data
          hide-details
          chips
          small-chips
        >
        
          <template #item="{ item, on, attrs }">
            <v-list-item
              dense
              :ripple="false"
              :class="{ backgroundSelected: attrs.inputValue && isDark, backgroundSelectedLight: attrs.inputValue && !isDark }"
              v-on="on"
            >
              <v-list-item-action>
                <v-avatar
                  class="white--text"
                  tile
                  size="30"
                  color="primary"
                >
                  <h6>{{ countComponentsInGroup(item) }}</h6>
                </v-avatar>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title> {{ item }} </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </template>
        </v-autocomplete>
         </v-responsive>

  </div>
</template>

<script>
import { sync, get, call } from 'vuex-pathify';
import componentGroups from '@/mixins/componentGroups';
import componentActions from '@/mixins/componentActions';

export default {
  name: 'AccountsGroups',
  mixins: [componentGroups, componentActions],

  mounted() {
  },

  computed: {
    ...sync('accountsManagement', ['selectedEntityType']),
  },
  methods: {
    ...call('accountsManagement/*'),
  },
};
</script>
