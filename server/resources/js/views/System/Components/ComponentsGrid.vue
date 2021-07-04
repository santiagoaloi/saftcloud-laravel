<template>
 <div>
  <v-item-group mandatory v-model="componentCardGroup">
   <transition-group class="gallery-card-container pa-2" appear css name="slide-x-transition">
    <v-item :key="`${index}`" v-for="(component, index) in allComponentsFiltered" v-slot="{ active, toggle }">
     <v-hover v-slot="{ hover }">
      <v-card
       :ref="`SEL${componentCardGroup}ID${index}`"
       :color="getComponentCardColor(active)"
       height="210"
       width="100%"
       :ripple="false"
       class="d-flex flex-column justify-space-between pa-4 hoverElevationSoft"
       @click="
        toggle();
        setSelectedComponent(index);
       "
      >
       <v-card-actions class="px-0 ">
        <v-avatar @click="dialogIcons = true" rounded :color="component.config_settings.icon.color">
         <v-icon dark>
          {{ component.config_settings.icon.name }}
         </v-icon>
        </v-avatar>

        <v-spacer />

        <div :class="{ 'show-btns': hover, 'hide-btns': !hover }">
         <v-tooltip transition="false" color="black" bottom>
          <template v-slot:activator="{ on, attrs }">
           <v-btn v-on="on" @click.stop="setModular(component)" color="white" small icon :ripple="false">
            <v-icon :color="isModularColor(component)"> {{ isModularIcon(component) }} </v-icon>
           </v-btn>
          </template>
          <span>Modular</span>
         </v-tooltip>

         <v-tooltip transition="false" color="black" bottom>
          <template v-slot:activator="{ on, attrs }">
           <v-btn v-on="on" @click.stop="setActive(component)" color="white" small icon :ripple="false">
            <v-icon :color="isActiveColor(component)"> {{ isActiveIcon(component) }} </v-icon>
           </v-btn>
          </template>
          <span>Active</span>
         </v-tooltip>

         <v-tooltip transition="false" color="black" bottom>
          <template v-slot:activator="{ on, attrs }">
           <v-btn v-on="on" @click.stop="setStarred(component)" color="white" small icon :ripple="false">
            <v-icon :color="isStarredColor(component)"> {{ isStarredIcon(component) }} </v-icon>
           </v-btn>
          </template>
          <span>Favourite</span>
         </v-tooltip>
        </div>
       </v-card-actions>

       <span class="gallery-card-title"> {{ component.config.title }} </span>

       <div class="gallery-card-subtitle-container">
        <div class="gallery-card-subtitle-wrapper">
         <h5 class="gallery-card-subtitle">
          <v-chip
           style="pointer-events:none"
           :dark="isDark"
           :color="isDark ? 'rgb(54, 57, 63)' : 'grey lighten-4'"
           :text-color="isDark ? 'grey lighten-1' : 'indigo darken-4'"
           label
           class="col-6"
          >
           <v-icon small> mdi-folder-outline</v-icon>
           <div class="col-12 text-truncate">{{ mapComponentGroup(component) }}</div>
          </v-chip>
          <!-- <span v-else> {{ mapComponentGroup(component) }} </span> -->
         </h5>
        </div>
        <v-scale-transition>
         <div v-if="hasUnsavedChanges(component)" class="gallery-card-subtitle-wrapper">
          <h5 class="gallery-card-subtitle">
           <v-tooltip transition="false" color="black" bottom>
            <template v-slot:activator="{ on, attrs }">
             <v-icon v-on="on" :color="isDark ? 'white' : 'grey darken-4'">mdi-content-save-alert-outline</v-icon>
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

  <base-dialog-icons v-if="dialogIcons" :icon="componentIcon" v-model="dialogIcons" />
 </div>
</template>

<script>
import { store } from "@/store";
import globalMixin from "@/mixins/globalMixin";
import { sync, call, get } from "vuex-pathify";

export default {
 name: "ComponentsGridView",

 data() {
  return {
   dialogIcons: false
  };
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("drawers", ["secureComponentDrawer"]),
  ...get("componentManagement", [
   "allComponentsFiltered",
   "hasUnsavedChanges",
   "isModularIcon",
   "isStarredIcon",
   "selectedComponentIndex",
   "selectedComponent",
   "isStarredColor",
   "isActiveColor",
   "isModularColor",
   "isActiveIcon",
   "allGroups"
  ]),

  componentIcon() {
   if (!this.selectedComponent) return;
   return this.selectedComponent.config_settings.icon;
  },

  ...sync("componentManagement", ["componentCardGroup", "dialogs", "cardGroupKey"])
 },

 methods: {
  ...call("componentManagement/*"),

  getComponentCardColor(active) {
   if (this.$vuetify.theme.dark && !active) return "#40434a";
   if (this.$vuetify.theme.dark && active) return "#51555e";
   if (!this.$vuetify.theme.dark && !active) return "white";
   if (!this.$vuetify.theme.dark && active) return "indigo lighten-5";
  },

  setStarred(component) {
   component.status.starred = !component.status.starred;
   component.origin.status.starred = !component.origin.status.starred;
   this.setComponentStatus(component);
  },

  setModular(component) {
   component.status.modular = !component.status.modular;
   component.origin.status.modular = !component.origin.status.modular;
   this.setComponentStatus(component);
  },

  setActive(component) {
   component.status.active = !component.status.active;
   component.origin.status.active = !component.origin.status.active;
   this.setComponentStatus(component);
  },

  mapComponentGroup(component) {
   if (this.allGroups.length === 0) return;
   return this.allGroups.filter(g => g.id === component.component_group_id)[0].name;
  }
 }
};
</script>

<style scoped lang="scss">
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
 transition-property: color, background-color, box-shadow, transform, -webkit-box-shadow, -webkit-transform;
 transition-duration: 0.3s;
 box-shadow: 0 10px 60px -12px rgb(50 50 93 / 25%), 0 18px 36px -18px rgb(0 0 0 / 30%), 0 -12px 36px -8px rgb(0 0 0 / 3%) !important;
}

.hoverElevationSoft:hover {
 transform: translateY(1px) !important;
 box-shadow: 0 13px 27px -5px rgb(50 50 93 / 25%), 0 8px 16px -8px rgb(0 0 0 / 30%), 0 -6px 16px -6px rgb(0 0 0 / 3%) !important;
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
</style>
