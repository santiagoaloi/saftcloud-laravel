<template>
  <div>
    <!-- Navigation -->
    <v-navigation-drawer
      v-model="secureDefaultDrawer"
      src="storage/sidebar/bg1.jpg"
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
          background="linear-gradient(331deg, rgba(44, 91, 122, 1) 0%, rgba(109, 115, 135, 1) 0%)"
          space-after
          space-before
        >
          <v-card flat min-height="100" class="transparent px-4 my-2">
            <v-container>
              <div class="title font-weight-bold">SaftCloud ™</div>
              <div class="overline white--text">v5.0.2</div>
              <div class="mt-4" style="margin-left: -4px">
                <v-card-actions class="px-0">
                  <v-list-item class="pa-0">
                    <v-list-item-avatar color="grey darken-3">
                      <v-img
                        class="elevation-6"
                        alt=""
                        src="https://avataaars.io/?avatarStyle=Transparent&topType=ShortHairShortCurly&accessoriesType=Prescription02&hairColor=Black&facialHairType=Blank&clotheType=Hoodie&clotheColor=White&eyeType=Default&eyebrowType=DefaultNatural&mouthType=Default&skinColor=Light"
                      ></v-img>
                    </v-list-item-avatar>

                    <v-list-item-content>
                      <v-list-item-title
                        >{{ session.user.branches[0].entity.first_name }}
                      </v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </v-card-actions>

                <baseFieldLabel color="white" label="Branch" />
                <v-select
                  v-model="activeBranch"
                  :menu-props="{ 'offset-y': true }"
                  item-color="primary lighten-4"
                  hide-details
                  :items="session.user.branches"
                  item-text="name"
                  item-value="entity_id"
                  dense
                  solo
                >
                  <template #item="data">
                    <template>
                      <v-list-item-avatar color="indigo" size="24">
                        <v-icon small color="blue lighten-3">mdi-map-marker</v-icon>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-title>{{ data.item.name }}</v-list-item-title>
                      </v-list-item-content>
                    </template>
                  </template>
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
  import nav from '@/configs/navigation';

  Vue.component('MainMenu', () =>
    import(/* webpackChunkName: 'components-drawer-menu' */ '@/components/Navigation/MainMenu'),
  );

  export default {
    name: 'SecureDrawer',
    mounted() {
      this.getNavigationStructure();
    },
    computed: {
      ...sync('drawers', ['secureDefaultDrawer']),
      ...sync('componentManagement', ['navigationStructure']),
      ...sync('authentication', ['session', 'activeBranch']),
    },

    methods: {
      ...call('componentManagement/*'),
    },
  };
</script>
