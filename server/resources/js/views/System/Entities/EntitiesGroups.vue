<template>
  <div>
    <v-responsive class="py-1" :width="$vuetify.breakpoint.mdAndUp ? 300 : null">
      <v-select
        v-model="selectedEntityType"
        item-value="id"
        item-text="name"
        placeholder="Select roles o users"
        :maxlength="20"
        :items="['Roles', 'Users']"
        solo
        hide-no-data
        hide-details
        chips
        :color="isDark ? '#208ad6' : 'grey'"
        item-color="primary lighten-4"
        dense
        small-chips
        :menu-props="{ bottom: true, offsetY: true }"
      >
        <template #item="{ item, on, attrs }">
          <v-list-item
            dense
            :ripple="false"
            :class="{
              backgroundSelected: attrs.inputValue && isDark,
              backgroundSelectedLight: attrs.inputValue && !isDark,
            }"
            v-on="on"
          >
            <v-list-item-action>
              <v-avatar class="white--text" tile size="30" color="primary">
                <h6>{{ countComponentsInGroup(item) }}</h6>
              </v-avatar>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title> {{ item }} </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-select>
    </v-responsive>
  </div>
</template>

<script>
  import { sync, call } from 'vuex-pathify';
  import componentGroups from '@/mixins/componentGroups';
  import componentActions from '@/mixins/componentActions';

  export default {
    name: 'EntitiesGroups',
    mixins: [componentGroups, componentActions],

    computed: {
      ...sync('entitiesManagement', ['selectedEntityType']),
    },
    methods: {
      ...call('entitiesManagement/*'),
    },
  };
</script>
