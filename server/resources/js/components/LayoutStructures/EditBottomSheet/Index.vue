<template>
  <v-bottom-sheet v-model="internalValue" no-click-animation persistent fullscreen>
    <v-sheet height="100%">
      <base-flex-container>
        <template #top>
          <edit-sheet-appbar :title="toolbarTitle" :icon="toolbarIcon" />
        </template>

        <v-row class="h-full" no-gutters>
          <v-col class="h-full" cols="auto">
            <edit-sheet-drawer :menu="menuItems" @switchActiveSheet="switchActiveSheet" />
          </v-col>
          <v-col>
            <v-fade-transition leave-active-class="leaveTransition" mode="out-in" :duration="100">
              <component :is="activeSheet" class="pa-4"></component>
            </v-fade-transition>
            <!-- <v-card-text class="overflow-auto">
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

              <v-fade-transition leave-absolute>
                <keep-alive v-if="$route.meta.keepAlive">
                  <router-view></router-view>
                </keep-alive>
                <router-view v-else></router-view>
              </v-fade-transition>
            </v-card-text> -->
          </v-col>
        </v-row>
      </base-flex-container>
    </v-sheet>
  </v-bottom-sheet>
</template>

<script>
  export default {
    name: 'EditSheet',
    components: {
      EditSheetAppbar: () => import(/* webpackChunkName:'EditSheetAppbar' */ './EditBottomSheetAppbar'),
      EditSheetDrawer: () => import(/* webpackChunkName: 'EditSheetDrawer' */ './EditBottomSheetDrawer'),
    },

    props: {
      value: {
        type: [Boolean],
        default: false,
      },

      toolbarTitle: {
        type: [String],
        default: '',
      },
      toolbarIcon: {
        type: [String],
        default: '',
      },
      menuItems: {
        type: [Array],
        default: () => [],
      },
    },

    data() {
      return {
        activeSheet: null,
      };
    },

    computed: {
      internalValue() {
        return this.value;
      },
    },

    methods: {
      switchActiveSheet(sheet) {
        this.activeSheet = () => import(`@/${sheet}`);
      },
    },
  };
</script>
