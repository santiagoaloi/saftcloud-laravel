<template>
  <div>
    <v-item-group
      v-model="componentCardGroup"
      class="gallery-card-container pa-2"
      :active-class="isDark ? 'gridCardDark' : 'gridcardLight'"
    >
      <v-lazy
        v-for="(component, index) in allComponentsFiltered"
        :key="index"
        :options="{
          threshold: 0.8,
        }"
        min-height="200"
        transition="scroll-y-reverse-transition"
        width="100%"
        @click.native.prevent="setSelectedComponent(index)"
      >
        <base-grid-card
          icon-only
          class="d-flex flex-column justify-space-between pa-4 hoverElevationSoft"
          :item="component"
          :index="index"
          :status-icons="icons"
          :icon="component.config_settings.icon.name"
          :icon-color="component.config_settings.icon.color"
          :title="component.config.general_config.title"
          :methods="mapMethods"
        >
          <template #footer>
            <div class="gallery-card-subtitle-container">
              <div class="gallery-card-subtitle-wrapper">
                <h5 class="gallery-card-subtitle">
                  <v-chip
                    :color="isDark ? '#4c536c' : 'white'"
                    :text-color="isDark ? 'grey lighten-1' : 'indigo darken-4'"
                    class="col-12 pointer-events-none"
                    small
                  >
                    <v-icon x-small> mdi-folder-outline </v-icon>
                    <div class="col-12 text-truncate">
                      <template v-if="mapComponentGroup(component).component_group_id">
                        {{ mapGroupParent(component) }}
                        <v-icon small> mdi-menu-right </v-icon>
                      </template>
                      {{ mapComponentGroup(component).name }}
                    </div>
                  </v-chip>
                </h5>
              </div>
              <v-fade-transition>
                <div v-if="hasUnsavedChanges(component)" class="gallery-card-subtitle-wrapper">
                  <h5 class="gallery-card-subtitle">
                    <v-tooltip transition="false" color="black" bottom>
                      <template #activator="{ on }">
                        <v-icon :color="isDark ? 'white' : '#28292b'" v-on="on"> mdi-alert-outline </v-icon>
                      </template>
                      <span>Unsaved</span>
                    </v-tooltip>
                  </h5>
                </div>
              </v-fade-transition>
            </div>
          </template>
        </base-grid-card>
      </v-lazy>
    </v-item-group>
  </div>
</template>

<script>
  import { sync, get, call } from 'vuex-pathify';

  export default {
    name: 'ComponentsGridView',

    data() {
      return {
        icons: [
          {
            event: 'setStarred',
            color: 'isStarredColor',
            icon: 'isStarredIcon',
            tooltip: 'Star',
          },
          {
            event: 'setModular',
            color: 'isModularColor',
            icon: 'isModularIcon',
            tooltip: 'Modular',
          },
          {
            event: 'setActive',
            color: 'isActiveColor',
            icon: 'isActiveIcon',
            tooltip: 'Active',
          },
        ],
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['componentCardGroup']),
      ...get('componentManagement', [
        'allComponentsFiltered',
        'mapComponentGroup',
        'mapGroupParent',
        'hasUnsavedChanges',
        'isModularIcon',
        'isModularColor',
        'isStarredColor',
        'isStarredIcon',
        'isActiveColor',
        'isActiveIcon',
      ]),

      mapMethods() {
        const methods = [
          'isModularIcon',
          'isModularColor',
          'isStarredIcon',
          'isStarredColor',
          'isActiveIcon',
          'isActiveColor',
          'setStarred',
          'setModular',
          'setActive',
        ];

        return Object.fromEntries(methods.map((key) => [key, this[key]]));
      },
    },

    methods: {
      ...call('componentManagement/*'),
    },
  };
</script>
