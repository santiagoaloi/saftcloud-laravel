<template>
  <div>
    <components-appbar :parent-data="$data" />

    <v-card color="transparent" flat class="mt-8">
      <v-row align="center">
        <v-col cols="12" sm="3">
          <small>Component groups</small>
          <v-autocomplete
            @update:search-input="catchGroupInputValue($event)"
            solo
            v-model="selectedComponentGroups"
            :items="allGroups"
            multiple
            :maxlength="25"
            item-value="id"
            item-text="name"
            return-object
          >
            <template v-slot:prepend-item>
              <v-list-item ripple @click="toggle">
                <v-list-item-action>
                  <v-icon :color="selectedComponentGroups.length > 0 ? 'indigo darken-4' : 'grey darken-3'">
                    {{ icon }}
                  </v-icon>
                </v-list-item-action>
                <v-list-item-content>
                  <v-list-item-title>
                    Select All
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-divider></v-divider>
            </template>

            <template v-slot:selection="data">
              <template>
                <span v-if="data.index === 0" class="grey--text caption"
                  ><v-chip labal style="color: black" small label color="blue-grey lighten-4">
                    {{ selectedComponentGroups.length }} groups selected.</v-chip
                  ></span
                >
              </template>
            </template>

            <template v-slot:no-data>
              <v-list-item class="ml-1">
                <v-list-item-content>
                  <v-list-item-title>
                    <a @click="dialogGroup = !dialogGroup">+ Create group </a> {{ groupInputValue }}
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </template>
          </v-autocomplete>
        </v-col>
        <v-col cols="12" sm="9">
          <div>
            <v-chip-group showArrows centerActive>
              <v-chip :ripple="false" close @click:close="" v-for="item in selectedComponentGroups" :key="item">
                {{ item.name }}
              </v-chip>
            </v-chip-group>
          </div>
        </v-col>
      </v-row>
    </v-card>

    <div class="d-flex justify-space-between align-center">
      <v-tabs showArrows class="col-6 mt-n3" background-color="transparent" sliderSize="1">
        <v-tab :key="i" y v-for="(tab, i) in componentTabs" :ripple="false">
          <v-icon :color="tab.color" small left>
            {{ tab.icon }}
          </v-icon>
          {{ tab.name }}
        </v-tab>
      </v-tabs>

      <div class="d-flex">
        <v-switch v-model="multipleSelect" label="Multiple selection" class="mt-1 mx-4"> </v-switch>
        <v-btn @click="isTableLayout = !isTableLayout"><v-icon left> mdi-view-grid-outline</v-icon> Switch to grid view</v-btn>
      </div>
    </div>

    <v-divider></v-divider>

    <v-fade-transition hide-on-leave>
      <template v-if="isTableLayout">
        <v-card class="mt-2" flat>
          <v-data-table
            fixed-header
            height="40vh"
            checkbox-color="primary"
            item-key="id"
            show-select
            :headers="headers"
            :items="allComponents"
            :items-per-page="5"
            class="elevation-0"
          ></v-data-table>
        </v-card>
      </template>
    </v-fade-transition>

    <v-fade-transition hide-on-leave>
      <template v-if="!isTableLayout">
        <v-item-group v-model="componentCardGroup" mandatory :multiple="multipleSelect">
          <div class="gallery-card-container py-2">
            <v-item :key="index" v-for="(component, index) in allComponents" v-slot="{ active, toggle }">
              <v-card
                hover
                :color="active ? 'indigo lighten-5' : 'white'"
                :max-width="$vuetify.breakpoint.smAndDown ? '' : 320"
                height="180"
                width="100%"
                :ripple="false"
                class="d-flex flex-column justify-space-between pa-4 "
                @click="
                  toggle();
                  secureComponentDrawer = true;
                "
              >
                <v-card-actions class="px-0 ">
                  <v-avatar rounded :color="component.config_settings.icon.color">
                    <v-icon dark>
                      {{ component.config_settings.icon.name }}
                    </v-icon>
                  </v-avatar>
                  <v-spacer />
                  <v-btn color="white" small @click.stop icon :ripple="false"> <v-icon color="yellow"> mdi-star</v-icon></v-btn>
                </v-card-actions>

                <span class="gallery-card-title"> {{ component.config.title }} </span>

                <div class="gallery-card-subtitle-container">
                  <div class="gallery-card-subtitle-wrapper">
                    <h5 class="gallery-card-subtitle">
                      <v-chip style="pointer-events:none" color="grey lighten-5" text-color="blue darken-4" label class="col-6">
                        <div class="col-12 text-truncate">
                          {{ mapComponentGroup(component) }}
                        </div>
                      </v-chip>
                    </h5>
                  </div>
                </div>
              </v-card>
            </v-item>
          </div>
        </v-item-group>
      </template>
    </v-fade-transition>
    <!-- 
    <dialog-system-operations v-model="dialogSystemOperations" :parent-data="$data" />
    <dialog-group v-model="dialogGroup" :parent-data="$data" /> -->
    <dialog-component v-if="dialogComponent" ref="dialogNewComponent" v-model="dialogComponent" :parent-data="$data" />
  </div>
</template>

<script>
import axios from "axios";
import { store } from "@/store";
import moment from "moment";
import globalMixin from "@/mixins/globalMixin";
import { sync, call } from "vuex-pathify";

export default {
  name: "ComponentManagement",
  components: {
    DialogGroup: () => import("./DialogGroup"),
    DialogComponent: () => import("./DialogComponent"),
    DialogSystemOperations: () => import("./DialogSystemOperations"),
    ComponentsAppbar: () => import("./ComponentsAppbar")
  },

  mixins: [globalMixin],

  provide() {
    return {
      ...this.getComponentMethods()
    };
  },

  data() {
    return this.initialState();
  },

  computed: {
    ...sync("drawers", ["secureComponentDrawer"]),
    ...sync("componentManagement", ["componentCardGroup", "allComponents", "allGroups"]),

    selectedAllComponents() {
      return this.selectedComponentGroups.length === this.allGroups.length;
    },

    selectedSomeComponents() {
      return this.selectedComponentGroups.length > 0 && !this.selectedAllComponents;
    },

    icon() {
      if (this.selectedAllComponents) return "mdi-close-box";
      if (this.selectedSomeComponents) return "mdi-minus-box";
      return "mdi-checkbox-blank-outline";
    }
  },

  mounted() {
    this.getGroups();
    this.getComponents();
  },

  methods: {
    initialState() {
      return {
        //Dialogs
        dialogSystemOperations: false,
        dialogComponent: false,
        dialogGroup: false,

        loading: false,
        view_type: false,
        isTableLayout: false,
        multipleSelect: false,
        groupInputValue: "",
        selectedComponentGroups: [],

        group_settings: {
          group_id: "",
          name: "",
          folder: "",
          icon: "",
          total: "",
          ordering: ""
        },

        componentSettings: {
          component_group_id: 0,
          prev_group_id: 0,
          title: "",
          name: "",
          table: "",
          note: ""
        },

        componentTabs: [
          { name: "All", icon: "mdi-all-inclusive", color: "" },
          { name: "Starred", icon: "mdi-star", color: "" },
          { name: "Active", icon: "mdi-lightbulb-on", color: "blue darken-4" },
          { name: "Inactive", icon: "mdi-lightbulb-on-outline", color: "red lighten-1" },
          { name: "Modular", icon: "mdi-view-module", color: "" }
        ],
        headers: [
          {
            text: "Name",
            align: "start",
            value: "title"
          }
        ],
        items_type: [{ value: "blank", text: " Blank Template" }]
      };
    },

    mapComponentGroup(item) {
      return this.allGroups.filter(cg => cg.id === item.component_group_id)[0].name;
    },

    catchGroupInputValue(e) {
      this.groupInputValue = e;
    },

    toggle() {
      this.$nextTick(() => {
        if (this.selectedAllComponents) {
          this.selectedComponentGroups = [];
        } else {
          this.selectedComponentGroups = this.allGroups.slice();
        }
      });
    },

    // Saves group data
    saveGroup() {
      axios.post("api/ComponentGroup", { name: this.group_settings.name }).then(response => {
        if (response.data.status) {
          this.dialogGroup = false;
          this.allGroups = response.data.rows;
        }
      });
    },

    // get groups
    getGroups() {
      axios.get("api/showAllGroups").then(response => {
        if (response.data.status) {
          this.allGroups = response.data.rows;
        }
      });
    },

    getComponents() {
      axios.get("api/showAllComponents").then(response => {
        if (response.data.status) {
          this.allComponents = response.data.components;
        }
      });
    },

    addNewComponent() {
      this.dialogComponent = true;
    },

    addNewGroup() {
      this.dialogGroup = true;
    },

    sidebarEnabledCheck() {
      return this.rows.filter(item => item.menu == "1").length;
    },

    generate() {
      axios.post("api/Component", this.componentSettings).then(response => {
        if (response.data.status) {
          this.allComponents = response.data.components;
          this.dialogComponent = false;
          this.componentSettings = this.initialState().componentSettings;
          store.set("snackbar/value", true);
          store.set("snackbar/text", "Component created");
          store.set("snackbar/color", "indigo darken-1");
        }
      });
    }
  }
};
</script>

<style scoped>
.v-card--link:before {
  background: white;
}

.gallery-card-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(264px, 1fr));
  grid-auto-rows: 180px;
  gap: 16px;

  animation: slideAround 10s infinite alternate linear;
  will-change: grid-template-columns, grid-template-rows;
}

.gallery-card-wrapper {
  box-sizing: border-box;

  text-align: left;
}

.gallery-card-title {
  font-size: 1.1rem;
  font-weight: bold;
  line-height: 1.2;
  color: rgb(23, 43, 77);
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
