<template>
  <div>
    <v-item-group
      v-model="entityCardGroup"
      class="gallery-card-container pa-2"
      :active-class="isDark ? 'gridCardDark' : 'gridcardLight'"
    >
      <v-lazy
        v-for="(entity, index) in allEntitiesFiltered"
        :key="index"
        :options="{
          threshold: 0.8,
        }"
        min-height="200"
        transition="scroll-y-reverse-transition"
        width="100%"
      >
        <base-grid-card
          no-actions
          class="d-flex flex-column justify-space-between pa-4 hoverElevationSoft"
          :item="entity"
          :index="index"
          :status-icons="icons"
          icon="mdi-shield-lock-outline"
          :icon-color="selectedEntityType === 'Roles' ? 'primary' : 'transparent'"
          :icon-only="selectedEntityType === 'Roles'"
          :avatar="entity.avatar"
          :title="selectedEntityType === 'Roles' ? entity.name : fullName(entity.entity.first_name, entity.entity.last_name)"
          :methods="mapMethods"
          @click.native="setSelectedEntity(index)"
        >
          <template #footer>
            <div class="gallery-card-subtitle-container">
              <div class="gallery-card-subtitle-wrapper">
                <h5 class="gallery-card-subtitle">
                  <v-chip
                    :color="isDark ? '#4c536c' : 'white'"
                    :text-color="isDark ? 'white' : 'indigo darken-4'"
                    class="col-12 pointer-events-none"
                    small
                  >
                    <template v-if="selectedEntityType === 'Roles'">
                      {{ privileges(entity.privileges) }}
                      <span style="margin-top: 1.6px" class="ml-2 white--text"> Privileges</span>
                    </template>

                    <template v-if="selectedEntityType === 'Users'">
                      <span class="d-inline-block text-truncate" style="max-width: 200px"> {{ entity.email }} </span>
                    </template>
                  </v-chip>
                </h5>
              </div>

              <v-fade-transition>
                <div v-if="hasUnsavedChanges(entity)" class="gallery-card-subtitle-wrapper">
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
  import { sync, call, get } from 'vuex-pathify';
  import capitalize from 'lodash/capitalize';

  export default {
    name: 'EntitiesGridView',
    data() {
      return {
        isMounted: false,
        icons: [
          {
            event: 'setStarred',
            color: 'isStarredColor',
            icon: 'isStarredIcon',
            tooltip: 'Star',
          },
        ],
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('entitiesManagement', ['entityCardGroup', 'allUsers', 'selectedEntityType']),
      ...get('entitiesManagement', [
        'allEntitiesFiltered',
        'hasUnsavedChanges',
        'selectedEntity',
        'isStarredColor',
        'isStarredIcon',
      ]),

      entityTypeData() {
        return this.selectedEntityType === 'Roles' ? this.allRoles : this.allUsers;
      },

      mapMethods() {
        const methods = ['isStarredIcon', 'setStarred'];

        return Object.fromEntries(methods.map((key) => [key, this[key]]));
      },
    },

    mounted() {
      this.isMounted = true;
    },
    methods: {
      ...call('entitiesManagement/*'),

      privileges(privileges) {
        return `${privileges.length} `;
      },

      fullName(first, last) {
        return `${capitalize(first)} ${capitalize(last)}`;
      },
    },
  };
</script>
