<template>
  <div>
    <v-progress-linear
      height="1"
      color="grey darken-2"
      :indeterminate="loading"
    ></v-progress-linear>
    <v-item-group v-model="componentCardGroup" mandatory>
      <transition-group hide-on-leave class="gallery-card-container pa-2" name="fade-transition">
        <v-item
          v-for="(component, index) in allComponentsFilteredSorted"
          :key="`${index}`"
          v-slot="{ active, toggle }"
        >
          <v-hover v-slot="{ hover }">
            <v-card
              :ref="`SEL${componentCardGroup}ID${index}`"
              :color="getComponentCardColor(active)"
              height="210"
              width="100%"
              :ripple="false"
              class="d-flex flex-column justify-space-between pa-4 hoverElevationSoft"
              :class="{ activeBorder: active }"
              @click.stop="
                toggle();
                setSelectedComponent(index);
              "
              @dblclick.stop="validateBeforeEdit()"
            >
              <v-card-actions class="px-0">
                <v-hover v-slot="{ hover }">
                  <v-avatar
                    class="cursor-pointer"
                    size="65"
                    rounded
                    :color="component.config_settings.icon.color"
                    @click="dialogIcons = true"
                  >
                    <v-expand-transition>
                      <div
                        v-if="hover"
                        class="d-flex black v-card--reveal white--text"
                        style="height: 100%"
                      >
                        <v-icon size="30" dark> mdi-pencil </v-icon>
                      </div>
                    </v-expand-transition>
                    <v-fade-transition hide-on-leave>
                      <v-icon v-if="!hover" size="30" dark>
                        {{ component.config_settings.icon.name }}
                      </v-icon>
                    </v-fade-transition>
                  </v-avatar>
                </v-hover>

                <v-spacer />

                <div :class="{ 'show-btns': hover, 'hide-btns': !hover }">
                  <v-tooltip transition="false" color="black" bottom>
                    <template #activator="{ on }">
                      <v-btn
                        color="white"
                        small
                        icon
                        :ripple="false"
                        v-on="on"
                        @click.stop="setModular(component)"
                      >
                        <v-icon :color="isModularColor(component)">
                          {{ isModularIcon(component) }}
                        </v-icon>
                      </v-btn>
                    </template>
                    <span>Modular</span>
                  </v-tooltip>

                  <v-tooltip transition="false" color="black" bottom>
                    <template #activator="{ on }">
                      <v-btn
                        color="white"
                        small
                        icon
                        :ripple="false"
                        v-on="on"
                        @click.stop="setActive(component)"
                      >
                        <v-icon :color="isActiveColor(component)">
                          {{ isActiveIcon(component) }}
                        </v-icon>
                      </v-btn>
                    </template>
                    <span>Active</span>
                  </v-tooltip>

                  <v-tooltip transition="false" color="black" bottom>
                    <template #activator="{ on }">
                      <v-btn
                        color="white"
                        small
                        icon
                        :ripple="false"
                        v-on="on"
                        @click.stop="setStarred(component)"
                      >
                        <v-icon :color="isStarredColor(component)">
                          {{ isStarredIcon(component) }}
                        </v-icon>
                      </v-btn>
                    </template>
                    <span>Favourite</span>
                  </v-tooltip>
                </div>
              </v-card-actions>

              <span class="gallery-card-title pl-2">
                <template v-if="component.config.general_config.title">
                  {{ component.config.general_config.title }}
                </template>
                <template v-else>
                  <base-typing-indicator class="ml-n2" />
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
                          <v-icon :color="isDark ? 'white' : '#28292b'" v-on="on">
                            mdi-alert-outline
                          </v-icon>
                        </template>
                        <span>Unsaved</span>
                      </v-tooltip>
                    </h5>
                  </div>
                </v-fade-transition>
              </div>
            </v-card>
          </v-hover>
        </v-item>
      </transition-group>
    </v-item-group>

    <base-dialog-icons v-if="dialogIcons" v-model="dialogIcons" :icon="componentIcon" />
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';

  export default {
    name: 'ComponentsGridView',
    data() {
      return {
        dialogIcons: false,
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['componentCardGroup', 'componentEditSheet', 'loading']),
      ...get('componentManagement', [
        'mapComponentGroup',
        'mapGroupParent',
        'allComponentsFiltered',
        'hasUnsavedChanges',
        'isModularIcon',
        'selectedComponent',
        'isStarredColor',
        'isStarredIcon',
        'isModularColor',
        'isActiveColor',
        'isActiveIcon',
      ]),

      allComponentsFilteredSorted() {
        return this.allComponentsFiltered;
      },

      componentIcon() {
        if (!this.selectedComponent) return;
        return this.selectedComponent.config_settings.icon;
      },
    },

    methods: {
      ...call('componentManagement/*'),
      ...call('snackbar/*'),

      validateBeforeEdit() {
        if (this.selectedComponent.config.general_config.title) {
          this.componentEditSheet = !this.componentEditSheet;
        } else {
          this.snackbarError('There are input validation errors');
        }
      },

      getComponentCardColor(active) {
        return this.isDark ? (active ? '#373a44' : '#40444f') : active ? '#edeef2' : 'white';
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
