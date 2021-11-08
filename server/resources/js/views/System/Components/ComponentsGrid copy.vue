<template>
  <div>
    <v-item-group v-model="componentCardGroup" mandatory>
      <transition-group class="gallery-card-container pa-2" name="fade-transition">
        <components-grid-card
          v-for="(component, index) in allComponentsFilteredSorted"
          :key="component.id"
          :component="component"
          :index="index"
        >
        </components-grid-card>
      </transition-group>
    </v-item-group>

    <base-dialog-icons v-if="dialogIcons" v-model="dialogIcons" :icon="componentIcon" />
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';

  export default {
    name: 'ComponentsGridView',

    components: {
      ComponentsGridCard: () => import(/* webpackChunkName: 'cgc' */ './ComponentsGridCard'),
    },
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
        'allComponentsFiltered',
        'selectedComponent',
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

      getCardColorComponents(active) {
        return this.isDark ? (active ? '#373b4f' : '#282c3b') : active ? '#edeef2' : 'white';
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
    border-bottom: 3px solid #3e425c !important;
  }
</style>
