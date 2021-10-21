<template>
  <v-bottom-sheet v-model="componentEditSheet" eager no-click-animation persistent fullscreen>
    <v-card tile>
      <template v-if="componentEditSheet">
        <components-edit-sheet-appbar />
        <v-row no-gutters class="text-start">
          <v-col :style="height" cols="auto">
            <components-edit-sheet-drawer />
          </v-col>
          <v-col>
            <v-card-text class="overflow-auto">
              <v-chip
                class="ml-n2 pointer-events-none"
                :color="'transparent'"
                :text-color="isDark ? 'grey lighten-1' : 'indigo darken-4'"
                label
                small
              >
                <v-icon x-small> mdi-folder-outline</v-icon>
                <div class="col-12 text-truncate">
                  <template v-if="mapComponentGroup(selectedComponent).component_group_id">
                    {{ mapGroupParent(selectedComponent) }} <v-icon small>mdi-menu-right</v-icon>
                  </template>
                  {{ mapComponentGroup(selectedComponent).name }}
                  <v-icon small>mdi-menu-right</v-icon>
                  {{ selectedComponent.config.general_config.title }}
                </div>
              </v-chip>

              <v-chip label small style="float: right">Basic view configuration</v-chip>

              <v-divider class="mt-2" />

              <!-- keep alive is important to cross-validate compoment edit navigation drawer sections -->
              <v-scroll-y-transition hide-on-leave>
                <keep-alive>
                  <router-view />
                </keep-alive>
              </v-scroll-y-transition>
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
    name: 'ComponentsEdit',
    components: {
      ComponentsEditSheetAppbar: () =>
        import(/* webpackChunkName:   'edit-bundle' */ './ComponentsEditSheetAppbar'),
      ComponentsEditSheetDrawer: () =>
        import(/* webpackChunkName:   'edit-bundle' */ './ComponentsEditSheetDrawer'),
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['componentEditSheet']),
      ...get('componentManagement', ['selectedComponent', 'mapComponentGroup', 'mapGroupParent']),

      height() {
        return `height:${
          this.$vuetify.breakpoint.height - this.$vuetify.application.top
        }px;overflow:auto`;
      },
    },
  };
</script>
