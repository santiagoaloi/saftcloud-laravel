<template>
  <div>
    <v-item-group v-model="entityCardGroup" mandatory>
      <transition-group class="gallery-card-container pa-2" appear css name="slide-x-transition">
        <v-item
          v-for="(entity, index) in allEntitiesFilteredSorted"
          :key="`${index}`"
          v-slot="{ active, toggle }"
        >
          <v-hover v-slot="{ hover }">
            <v-card
              :ref="`SEL${entityCardGroup}ID${index}`"
              :color="getCardColor(active)"
              height="210"
              width="100%"
              :ripple="false"
              class="d-flex flex-column justify-space-between pa-4 hoverElevationSoft"
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
                <template>
                  {{ selectedEntityType === 'Roles' ? entity.name : entity.email }}
                </template>
              </span>

              <div class="gallery-card-subtitle-container">
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
  import { store } from '@/store';

  export default {
    name: 'AccountsGridView',
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('accountsManagement', ['entityCardGroup', 'allUsers', 'selectedEntityType']),
      ...get('accountsManagement', [
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
      ...call('accountsManagement/*'),

      getCardColor(active) {
        return this.isDark ? (active ? '#51555e' : '#40434a') : active ? '#edeef2' : 'white';
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
</style>
