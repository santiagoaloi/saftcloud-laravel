<template>
  <div>
    <transition-group leave-active-class="leaveTransition" appear name="slide-y-transition">
      <div v-for="(group, index) in allModulesFilteredByGroupSorted" :key="group.groupId">
        <v-card-title class="ml-n1 mb-2" :class="{ 'my-5': index !== 0 }">
          <v-btn class="pointer-events-none mr-3 ml-n2" depressed rounded color="#373b4f" fab small>
            {{ group.modules.length }}
          </v-btn>
          <h3><v-icon class="mr-3"> mdi-vector-arrange-above </v-icon>{{ group.groupName }}</h3>
        </v-card-title>

        <div class="gallery-card-container">
          <base-grid-card
            v-for="module in group.modules"
            :key="module.id"
            v-bind="{ ...settings(module) }"
            @click.native="setselectedModule(findModuleIndex(module.id))"
          >
            <template #footer>
              <modules-grid-group-chips :module="module" />
              <base-unsaved-changes-icon :unsaved="hasUnsavedChanges(module)" />
            </template>
          </base-grid-card>
        </div>
      </div>
    </transition-group>
  </div>
</template>

<script>
  import { sync, get, call } from 'vuex-pathify';

  export default {
    name: 'ModulesGridView',

    components: {
      ModulesGridGroupChips: () => import('./ModulesGridGroupChips'),
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
      ...get('modulesManagement', [
        'hasUnsavedChanges',
        'isModularIcon',
        'isModularColor',
        'isStarredColor',
        'isStarredIcon',
        'isActiveColor',
        'isActiveIcon',
        'allModulesFilteredByGroupSorted',
        'allModulesFiltered',
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
      ...call('modulesManagement/*'),

      findModuleIndex(id) {
        return this.allModulesFiltered.map((module) => module.id).indexOf(id);
      },

      settings(module) {
        return {
          'icon-only': true,
          'item': module,
          'index': module.id,
          'status-icons': this.icons,
          'icon': module.config_settings.icon.name,
          'icon-color': module.config_settings.icon.color,
          'title': module.config.general_config.title,
          'methods': this.mapMethods,
        };
      },
    },
  };
</script>
