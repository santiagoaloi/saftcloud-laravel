<template>
  <div>
    <v-item-group v-model="entityCardGroup" mandatory>
      <transition-group class="gallery-card-container pa-2" name="slide-x-transition">
        <v-item
          v-for="(entity, index) in allEntitiesFilteredSorted"
          :key="`${index}`"
          v-slot="{ active, toggle }"
        >
          <v-hover v-slot="{ hover }">
            <v-card
              :ref="`SEL${entityCardGroup}ID${index}`"
              :color="getCardColor(active)"
              style="opacity: 0.8"
              height="210"
              width="100%"
              :ripple="false"
              class="d-flex flex-column justify-space-between pa-4 hoverElevationSoft"
              :class="{ activeBorder: active }"
              @click.stop="
                toggle();
                setSelectedEntity(index);
              "
            >
              <v-card-actions class="px-0">
                <v-avatar class="cursor-pointer" size="65" rounded color="primary">
                  <v-icon size="30" dark>
                    {{ selectedEntityType === 'Roles' ? 'mdi-lock-outline' : 'mdi-account' }}
                  </v-icon>
                </v-avatar>

                <v-spacer />
              </v-card-actions>

              <span class="gallery-card-title pl-2">
                <template v-if="selectedEntityType === 'Users'">
                  {{ fullName(entity.entity.first_name, entity.entity.last_name) }}
                </template>

                <template v-if="selectedEntityType === 'Roles'">
                  {{ selectedEntityType === 'Roles' ? entity.name : entity.email }}
                </template>
              </span>

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

                <v-scale-transition e-transition>
                  <div v-if="hasUnsavedChanges(entity)" class="gallery-card-subtitle-wrapper">
                    <h5 class="gallery-card-subtitle">
                      <v-tooltip transition="false" color="black" bottom>
                        <template #activator="{ on }">
                          <v-icon :color="isDark ? 'white' : '#28292b'" v-on="on">
                            mdi-alert-outline
                          </v-icon>
                        </template>
                        <span>Unsaved</span>
                      </v-tooltip>
                    </h5>
                  </div>
                </v-scale-transition>
              </div>
            </v-card>
          </v-hover>
        </v-item>
      </transition-group>
    </v-item-group>
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';
  import capitalize from 'lodash/capitalize';

  export default {
    name: 'EntitiesGridView',
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('entitiesManagement', ['entityCardGroup', 'allUsers', 'selectedEntityType']),
      ...get('entitiesManagement', [
        'allEntitiesFiltered',
        'hasUnsavedChanges',
        'isModularIcon',
        'selectedEntity',
        'isStarredColor',
        'isStarredIcon',
        'isModularColor',
        'isActiveColor',
        'isActiveIcon',
      ]),

      entityTypeData() {
        return this.selectedEntityType === 'Roles' ? this.allRoles : this.allUsers;
      },

      allEntitiesFilteredSorted() {
        return this.allEntitiesFiltered;
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
      getCardColor(active) {
        return this.isDark ? (active ? '#515664' : '#40434a') : active ? '#edeef2' : 'white';
      },
    },
  };
</script>

<style scoped>
  .show-btns {
    opacity: 1 !important;
    transition: opacity 0.3s ease-in-out;
  }

  .hide-btns {
    transition: opacity 0.3s ease-in-out;
    opacity: 0 !important;
  }

  .hoverElevationSoft {
    border-radius: 8px;
    -webkit-transition-property: color, background-color, -webkit-box-shadow, -webkit-transform;
    transition-property: color, background-color, box-shadow, transform, -webkit-box-shadow,
      -webkit-transform;
    transition-duration: 0.3s;
    box-shadow: 0 10px 60px -12px rgb(50 50 93 / 25%), 0 18px 36px -18px rgb(0 0 0 / 30%),
      0 -12px 36px -8px rgb(0 0 0 / 3%) !important;
  }

  .hoverElevationSoft:hover {
    transform: translateY(1px) !important;
    box-shadow: 0 13px 27px -5px rgb(50 50 93 / 25%), 0 8px 16px -8px rgb(0 0 0 / 30%),
      0 -6px 16px -6px rgb(0 0 0 / 3%) !important;
  }
  .v-card--link:before {
    background: white;
  }

  .gallery-card-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(264px, 1fr));
    grid-auto-rows: 5 0%;
    gap: 10px;
    justify-items: center;
  }

  .gallery-card-wrapper {
    box-sizing: border-box;
    text-align: left;
  }

  .gallery-card-title {
    font-size: 1.1rem;
    font-weight: bold;
    line-height: 1.2;
    letter-spacing: -0.008em;
    margin: 0px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .gallery-card-subtitle-container {
    width: 100%;
    height: 32px;
    display: flex;
    -webkit-box-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    align-items: center;
    color: rgb(107, 119, 140) !important;
  }

  .gallery-card-subtitle-wrapper {
    padding: 2px;
    margin-left: -2px;
    margin-right: 4px;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .gallery-card-subtitle {
    margin: 0px;
    -webkit-box-flex: 1;
    flex-grow: 1;
    flex-shrink: 1;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .v-card--reveal {
    align-items: center;
    bottom: 0;
    justify-content: center;
    opacity: 0.5;
    position: absolute;
    width: 100%;
  }

  .activeBorder {
    border-bottom: 3px solid #4169de !important;
  }
</style>
