<template>
  <v-item-group
    v-model="componentCardGroup"
    class="gallery-card-container pa-4"
    :active-class="isDark ? 'gridCardDark' : 'gridcardLight'"
  >
    <base-grid-card
      v-for="(component, i) in allComponentsFiltered"
      :key="i"
      icon-only
      :item="component"
      :index="i"
      :status-icons="icons"
      :icon="component.config_settings.icon.name"
      :icon-color="component.config_settings.icon.color"
      :title="component.config.general_config.title"
      :methods="mapMethods"
      @click.native.prevent="setSelectedComponent(i)"
    >
      <template #footer>
        <components-grid-group-chips :component="component" />
        <base-unsaved-changes-icon :unsaved="hasUnsavedChanges(component)" />
      </template>
    </base-grid-card>
  </v-item-group>
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
