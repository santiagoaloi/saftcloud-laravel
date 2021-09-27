<template>
  <div>
    <v-row
      align="center"
      class="mt-2"
    >
      <v-col
        cols="12"
        sm="6"
        xl="4"
      >
        <baseFieldLabel label="Identity type" />
        <v-autocomplete
          item-value="id"
          item-text="name"
          item-color="primary"
          placeholder="Select roles o users"
          :maxlength="20"
          :items="['Roles', 'Accounts']"
          solo
          :color="isDark ? '#208ad6' : 'grey'"
          :background-color="isDark ? '#28292b' : 'white'"
          hide-no-data
        >
          <template #selection="data">
            <v-chip
              small
              :style="isDark ? 'color: white' : 'color:black'"
              :color="isDark ? 'grey-darken-4' : 'blue-white'"
            >
              hello
            </v-chip>
          </template>

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
      </v-col>
    </v-row>
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
    ...sync('accountsManagement', []),
  },
  methods: {
    ...call('accountsManagement/*'),
  },
};
</script>
