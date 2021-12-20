<template>
  <div>
    <v-item-group v-model="componentCardGroup" active-class="gridCardDark">
      <div v-for="(group, index) in allComponentsFilteredUniqueGroups" :key="group">
        <v-card-title class="ml-n1 mb-2" :class="{ 'my-5': index !== 0 }">
          <h3><v-icon class="mr-3"> mdi-vector-arrange-above </v-icon>{{ getGroupName(group) }}</h3>
        </v-card-title>

        <div class="gallery-card-container">
          <div v-for="(component, i) in filtered(group)" :key="i" class="gallery-card-container w-full">
            <base-grid-card
              v-bind="{ ...settings(component) }"
              @click.native="setSelectedComponent(findComponentIndex(component.id))"
            >
              <template #footer>
                <components-grid-group-chips :component="component" />
                <base-unsaved-changes-icon :unsaved="hasUnsavedChanges(component)" />
              </template>
            </base-grid-card>
          </div>
        </div>
      </div>
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
      ...get('componentManagement', [
        'hasUnsavedChanges',
        'isModularIcon',
        'isModularColor',
        'isStarredColor',
        'isStarredIcon',
        'isActiveColor',
        'isActiveIcon',
        'allComponentsFilteredUniqueGroups',
        'allComponentsFiltered',
        'allComponents',

        'allGroups',
        'selectedComponent',
      ]),
      ...sync('componentManagement', ['componentCardGroup']),

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

      settings(component) {
        return {
          'icon-only': true,
          'item': component,
          'index': component.id,
          'status-icons': this.icons,
          'icon': component.config_settings.icon.name,
          'icon-color': component.config_settings.icon.color,
          'title': component.config.general_config.title,
          'methods': this.mapMethods,
        };
      },

      filtered(group) {
        return this.allComponentsFiltered.filter((c) => c.component_group_id === group);
      },

      findComponentIndex(id) {
        return this.allComponentsFiltered.map((component) => component.id).indexOf(id);
      },

      getGroupName(group) {
        return this.allGroups.find((g) => g.id === group).name;
      },
    },
  };
</script>
