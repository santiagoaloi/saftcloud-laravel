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
              <components-grid-group-chips :component="component" />
              <base-unsaved-changes-icon :unsaved="hasUnsavedChanges(component)" />
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

    components: {
      ComponentsGridGroupChips: () => import('./ComponentsGridGroupChips'),
    },

    data() {
      return {
        icons: [
          {
            method: 'setStarred',
            color: 'isStarredColor',
            icon: 'isStarredIcon',
            tooltip: 'Star',
          },
          {
            method: 'setModular',
            color: 'isModularColor',
            icon: 'isModularIcon',
            tooltip: 'Modular',
          },
          {
            method: 'setActive',
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
