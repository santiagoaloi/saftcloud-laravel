<template>
  <div>
    <!-- Navigation -->
    <v-navigation-drawer
      v-model="secureDefaultDrawer"
      src="storage/appbar/prism2.jpg"
      dark
      width="250"
      app
      class="elevation-1"
    >
      <!-- Navigation menu fixed  -->
      <template #prepend>
        <vue-diagonal
          class="mt-n5"
          :deg="-7"
          background="linear-gradient(331deg, rgba(44, 91, 122, 1) 0%, rgba(0, 10, 20 , 0.2) 0%)"
          space-after
          space-before
        >
          <v-card flat min-height="100" class="transparent px-4 my-2">
            <v-container>
              <div class="title font-weight-bold">SaftCloud ™</div>
              <div class="overline white--text">v5.0.2</div>
              <div class="mt-4" style="margin-left: -4px">
                <v-card-actions class="px-0">
                  <v-list-item dense class="pa-0">
                    <v-list-item-avatar color="grey darken-3">
                      <v-img class="elevation-6" :src="session.user.avatar"></v-img>
                    </v-list-item-avatar>

                    <v-list-item-content>
                      <v-list-item-title>{{ fullName }} </v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </v-card-actions>

                <baseFieldLabel color="white" label="Branch" />
                <v-select
                  v-model="activeBranch"
                  :menu-props="{ 'offset-y': true }"
                  item-color="primary lighten-4"
                  hide-details
                  :items="session.user.branch"
                  item-text="name"
                  item-value="entity_id"
                  dense
                  solo
                >
                  <!-- <template #item="data">
                    <template>
                      <v-list-item-avatar color="indigo" size="24">
                        <v-icon small color="blue lighten-3">mdi-map-marker</v-icon>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-title>{{ data.item.name }}</v-list-item-title>
                      </v-list-item-content>
                    </template>
                  </template> -->
                </v-select>
              </div>
            </v-container>
          </v-card>
        </vue-diagonal>
      </template>

      <!-- Navigation menu -->
      <main-menu class="pa-2" :menu="navigationStructure.menu" />
    </v-navigation-drawer>
  </div>
</template>

<script>
  import Vue from 'vue';
  import { sync, call } from 'vuex-pathify';
  import capitalize from 'lodash/capitalize';

  Vue.component('MainMenu', () =>
    import(/* webpackChunkName: 'components-drawer-menu' */ '@/components/Navigation/MainMenu'),
  );

  export default {
    name: 'SecureDrawer',

    computed: {
      ...sync('drawers', ['secureDefaultDrawer']),
      ...sync('componentManagement', ['navigationStructure']),
      ...sync('authentication', ['session', 'activeBranch']),
      user: sync('authentication@session.user'),

      fullName() {
        return `${capitalize(this.user.entity.first_name)} ${capitalize(
          this.user.entity.last_name,
        )}`;
      },
    },

    mounted() {
      this.getNavigationStructure();
    },

    methods: {
      ...call('componentManagement/*'),
    },
  };
</script>
