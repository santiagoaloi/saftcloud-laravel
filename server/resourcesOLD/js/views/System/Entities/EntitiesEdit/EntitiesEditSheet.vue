<template>
  <v-bottom-sheet v-model="entitiesEditSheet" eager no-click-animation persistent fullscreen>
    <v-card tile>
      <template v-if="entitiesEditSheet">
        <Entities-edit-sheet-appbar />
        <v-row no-gutters class="text-start">
          <v-col :style="height" cols="auto">
            <Entities-edit-sheet-drawer />
          </v-col>
          <v-col>
            <v-card-text class="overflow-auto">
              <v-chip label small style="float: right">Basic user information</v-chip>

              <v-divider class="mt-2" />

              <!--! keep alive is important to cross-validate entities edit navigation drawer sections -->
              <v-fade-transition mode="out-in" :duration="520" hide-on-leave>
                <keep-alive>
                  <router-view />
                </keep-alive>
              </v-fade-transition>
            </v-card-text>
          </v-col>
        </v-row>
      </template>
    </v-card>
  </v-bottom-sheet>
</template>

<script>
  import { sync, get } from 'vuex-pathify';

  export default {
    name: 'EntitiesEdit',
    components: {
      EntitiesEditSheetAppbar: () => import(/* webpackChunkName:   'ent-edit-bundle' */ './EntitiesEditSheetAppbar'),
      EntitiesEditSheetDrawer: () => import(/* webpackChunkName:   'ent-edit-bundle' */ './EntitiesEditSheetDrawer'),
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('entitiesManagement', ['entitiesEditSheet']),
      ...get('entitiesManagement', ['selectedEntity']),

      height() {
        return `height:${this.$vuetify.breakpoint.height - this.$vuetify.application.top}px;overflow:auto`;
      },
    },
  };
</script>
