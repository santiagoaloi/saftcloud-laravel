<template>
  <div>
    <v-item-group v-model="entityCardGroup" :active-class="isDark ? 'gridCardDark' : 'gridcardLight'" mandatory>
      <transition-group class="gallery-card-container pa-2" name="fade-transition">
        <base-grid-card
          v-for="(entity, index) in allEntitiesFiltered"
          :key="index + 1"
          no-actions
          class="d-flex flex-column justify-space-between pa-4 hoverElevationSoft"
          :item="entity"
          :index="index"
          :status-icons="icons"
          :icon="selectedEntityType === 'Roles' ? 'mdi-security' : 'mdi-account'"
          icon-color="primary"
          :avatar="selectedEntityType === 'Roles' ? null : entity.avatar"
          :title="selectedEntityType === 'Roles' ? entity.name : fullName(entity.entity.first_name, entity.entity.last_name)"
          :methods="mapMethods"
          @click.native="setSelectedEntity(index)"
        >
          <template #footer>
            <div class="gallery-card-subtitle-container">
              <div class="gallery-card-subtitle-wrapper">
                <h5 class="gallery-card-subtitle">
                  <v-chip
                    :dark="isDark"
                    :color="isDark ? 'rgb(54, 57, 63)' : 'white'"
                    :text-color="isDark ? 'grey lighten-1' : 'indigo darken-4'"
                    label
                    class="col-12 pointer-events-none"
                    small
                  >
                    <template v-if="selectedEntityType === 'Roles'">
                      {{ privileges(entity.privileges) }}
                      <span style="margin-top: 1.6px" class="ml-2 white--text"> Privileges</span>
                    </template>

                    <template v-if="selectedEntityType === 'Users'">
                      {{ entity.email }}
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
      </transition-group>
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
