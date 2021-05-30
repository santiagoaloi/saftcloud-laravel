<template>
  <div>
    <components-appbar :parent-data="$data" />

    <v-card color="transparent" flat class="mt-8">
      <v-row align="center">
        <v-col cols="12" sm="3">
          <span>Group</span>
          <v-autocomplete
            @update:search-input="catchGroupInputValue($event)"
            solo
            v-model="selectedFruits"
            :items="componentGroups"
            label="Favorite Fruits"
            multiple
            :maxlength="25"
            item-value="id"
            item-text="name"
            return-object
          >
            <template v-slot:prepend-item>
              <v-list-item ripple @click="toggle">
                <v-list-item-action>
                  <v-icon :color="selectedFruits.length > 0 ? 'indigo darken-4' : 'grey darken-3'">
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
                    {{ selectedFruits.length }} groups selected.</v-chip
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
              <v-chip :ripple="false" close @click:close="" v-for="item in selectedFruits" :key="item">
                {{ item.name }}
              </v-chip>
            </v-chip-group>
          </div>
        </v-col>
      </v-row>
    </v-card>

    <div class="d-flex justify-space-between align-center">
      <v-tabs showArrows class="col-6 mt-n3" background-color="transparent" sliderSize="1">
        <v-tab :ripple="false">All (32)</v-tab>
        <v-tab :ripple="false">Active (20)</v-tab>
        <v-tab :ripple="false">Inactive (4)</v-tab>
        <v-tab :ripple="false">Modular (4)</v-tab>
        <v-tab :ripple="false">Archived (12)</v-tab>
      </v-tabs>

      <div class="d-flex">
        <v-switch v-model="multipleSelect" label="Multiple selection" class="mt-1 mx-4"> </v-switch>
        <v-btn @click="isTableLayout = !isTableLayout"
          ><v-icon left> mdi-view-grid-outline</v-icon> Switch to grid view</v-btn
        >
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
            item-key="name"
            show-select
            :headers="headers"
            :items="components"
            :items-per-page="5"
            class="elevation-0"
          ></v-data-table>
        </v-card>
      </template>
    </v-fade-transition>

    <v-fade-transition hide-on-leave>
      <template v-if="!isTableLayout">
        <v-item-group v-model="componentCardGroup" :multiple="multipleSelect">
          <div class="gallery-card-container py-2">
            <v-item :key="card" v-for="card in allComponents" v-slot="{ active, toggle }">
              <v-card
                hover
                :color="active ? 'indigo lighten-5' : 'white'"
                :max-width="$vuetify.breakpoint.smAndDown ? '' : 320"
                height="180"
                width="100%"
                :ripple="false"
                class="d-flex flex-column justify-space-between pa-4 "
                @click="toggle"
              >
                <v-card-actions class="px-0 ">
                  <v-avatar rounded color="indigo">
                    <v-icon dark>
                      mdi-alarm
                    </v-icon>
                  </v-avatar>
                  <v-spacer />

                  <v-chip text-color="blue" outlined label class="col-6"
                    ><div class="col-12 text-truncate">
                      {{ mapComponentGroup(card) }}
                    </div></v-chip
                  >
                </v-card-actions>

                <span class="gallery-card-title"> {{ card.title }} </span>

                <div class="gallery-card-subtitle-container">
                  <div class="gallery-card-subtitle-wrapper">
                    <h5 class="gallery-card-subtitle">
                      {{ card.note }}
                    </h5>
                  </div>
                </div>
              </v-card>
            </v-item>
          </div>
        </v-item-group>
      </template>
    </v-fade-transition>

    <dialog-system-operations v-if="dialogSystemOperations" v-model="dialogSystemOperations" :parent-data="$data" />

    <dialog-group v-if="dialogGroup" v-model="dialogGroup" :parent-data="$data" />

    <dialog-table v-if="dialogTable" v-model="dialogTable" :parent-data="$data" />

    <dialog-component v-if="dialogComponent" ref="dialogNewComponent" v-model="dialogComponent" :parent-data="$data" />

    <dialog-selected v-if="dialogSelected" v-model="dialogSelected" :parent-data="$data" />

    <dialog-sort v-if="dialogSort" v-model="dialogSort" :parent-data="$data" />
  </div>
</template>

<script>
import axios from "axios";
import { mapActions, mapGetters } from "vuex";
import { store } from "@/store";
import moment from "moment";
import orderBy from "lodash/orderBy";
import draggable from "vuedraggable";
import globalMixin from "@/mixins/globalMixin";
// import routesBuilder from "@/mixins/routesBuilder";

export default {
  name: "ComponentManagement",

  components: {
    DialogSort: () => import("./DialogSort"),
    DialogGroup: () => import("./DialogGroup"),
    DialogTable: () => import("./DialogTable"),
    DialogSelected: () => import("./DialogSelected"),
    DialogComponent: () => import("./DialogComponent"),
    DialogSystemOperations: () => import("./DialogSystemOperations"),
    ComponentsTable: () => import("./ComponentsTable"),
    ComponentsAppbar: () => import("./ComponentsAppbar"),
    ComponentsCarousel: () => import("./ComponentsCarousel"),
    draggable
  },

  mixins: [globalMixin],

  provide() {
    return {
      ...this.getComponentMethods()
    };
  },

  data() {
    return {
      tags: [
        "Work",
        "Home Improvement",
        "Vacation",
        "Food",
        "Drawers",
        "Shopping",
        "Art",
        "Tech",
        "Creative Writing",
        "Work",
        "Home Improvement",
        "Vacation",
        "Food",
        "Drawers",
        "Shopping",
        "Art",
        "Tech",
        "Creative Writing"
      ],

      fruits: [
        "Apples",
        "Apricots",
        "Avocado",
        "Bananas",
        "Blueberries",
        "Blackberries",
        "Boysenberries",
        "Bread fruit",
        "Cantaloupes (cantalope)",
        "Cherries",
        "Cranberries",
        "Cucumbers",
        "Currants",
        "Dates",
        "Eggplant",
        "Figs",
        "Grapes",
        "Grapefruit",
        "Guava",
        "Honeydew melons",
        "Huckleberries",
        "Kiwis",
        "Kumquat",
        "Lemons",
        "Limes",
        "Mangos",
        "Mulberries",
        "Muskmelon",
        "Nectarines",
        "Olives",
        "Oranges",
        "Papaya",
        "Peaches",
        "Pears",
        "Persimmon",
        "Pineapple",
        "Plums",
        "Pomegranate",
        "Raspberries",
        "Rose Apple",
        "Starfruit",
        "Strawberries",
        "Tangerines",
        "Tomatoes",
        "Watermelons",
        "Zucchini"
      ],
      selectedFruits: [],

      headers: [
        {
          text: "Dessert (100g serving)",
          align: "start",
          sortable: false,
          value: "name"
        },
        { text: "Calories", value: "calories" },
        { text: "Fat (g)", value: "fat" },
        { text: "Carbs (g)", value: "carbs" },
        { text: "Protein (g)", value: "protein" },
        { text: "Iron (%)", value: "iron" }
      ],
      desserts: [
        {
          name: "Frozen Yogurt",
          calories: 159,
          fat: 6.0,
          carbs: 24,
          protein: 4.0,
          iron: "1%"
        },
        {
          name: "Ice cream sandwich",
          calories: 237,
          fat: 9.0,
          carbs: 37,
          protein: 4.3,
          iron: "1%"
        },
        {
          name: "Eclair",
          calories: 262,
          fat: 16.0,
          carbs: 23,
          protein: 6.0,
          iron: "7%"
        },
        {
          name: "Cupcake",
          calories: 305,
          fat: 3.7,
          carbs: 67,
          protein: 4.3,
          iron: "8%"
        },
        {
          name: "Gingerbread",
          calories: 356,
          fat: 16.0,
          carbs: 49,
          protein: 3.9,
          iron: "16%"
        },
        {
          name: "Jelly bean",
          calories: 375,
          fat: 0.0,
          carbs: 94,
          protein: 0.0,
          iron: "0%"
        },
        {
          name: "Lollipop",
          calories: 392,
          fat: 0.2,
          carbs: 98,
          protein: 0,
          iron: "2%"
        },
        {
          name: "Honeycomb",
          calories: 408,
          fat: 3.2,
          carbs: 87,
          protein: 6.5,
          iron: "45%"
        },
        {
          name: "Donut",
          calories: 452,
          fat: 25.0,
          carbs: 51,
          protein: 4.9,
          iron: "22%"
        },
        {
          name: "KitKat",
          calories: 518,
          fat: 26.0,
          carbs: 65,
          protein: 7,
          iron: "6%"
        }
      ],

      alert: false,
      addItems: [
        {
          icon: "mdi-puzzle-outline",
          function: this.addNewComponent,
          title: "New Component"
        },
        {
          icon: "mdi-folder-plus",
          function: this.addGroup,
          title: "New Group"
        }
      ],

      last_search_filter: sessionStorage.getItem("last_search_filter"),

      upload_path: store.state.baseUrl + "uploads/images/",
      carouselActiveIndex: 0,
      model: 0,
      first_boot: true,
      loading_boot: true,
      bulk_action_executing: false,

      dialogSystemOperations: false,
      dialogSort: false,
      dialogComponent: false,
      dialogGroup: false,
      dialogSelected: false,
      dialogTable: false,
      dialogIconModal: false,
      tab_item: 0,
      table_tabs: [
        {
          icon: "mdi-table-plus",
          menu_name: "Table"
        },

        {
          icon: "mdi-table-column-plus-before",
          menu_name: "Fields"
        }
      ],
      loading: false,
      loadingRows: false,

      log_insert: 0,
      log_change: 0,

      view_type: false,

      // lodash SORT
      order_id: false,
      order_owner: false,
      order_updated: false,
      orderCreationOrder: false,
      order_sidebar: false,
      order_global: false,

      component_details: false,

      val_errors_group: [],
      val_errors_component: [],
      val_errors_icon: [],

      protected: false,
      date_time: moment().format("YYYY-MM-DD HH:mm:ss"),
      dragthis: ".item",
      count: 0,

      activeGroupFolder: "",
      activeGroupItem: 0,
      activeGroupId: "",

      menu_folders: null,

      newGroup: 0,
      selected_table: null,
      selected_key: null,
      selected_group: null,

      tables: [],
      field: [],
      groups: [],
      selected: [],
      selectedComponent: [],

      rows: [],

      search: "",
      searchGroups: "",

      componentSettings: {
        component_group_id: 0,
        prev_group_id: 0,
        title: "",
        name: "",
        table: "",
        note: "",
        config: {}
      },

      group_settings: {
        group_id: "",
        name: "",
        folder: "",
        icon: "",
        total: "",
        ordering: ""
      },

      table_settings: {
        table_name: ""
      },

      table_fields: {
        table_name: ""
      },

      groupComponent: ["No Parent"],

      items_type: [
        { value: "blank", text: " Blank Template" }
        // { value: "crud", text: " Complete CRUD" },
        // { value: "crud2", text: " Simple Table CRUD" },
        // { value: "crud3", text: " Dropdown function CRUD" }
      ],

      nodata: store.state.baseUrl + "uploads/images/no-data.png",

      //NEW VARS
      isTableLayout: false,
      multipleSelect: false,
      componentCardGroup: 0,
      groupInputValue: "",
      componentGroups: [],
      allComponents: []
    };
  },

  computed: {
    likesAllFruit() {
      return this.selectedFruits.length === this.fruits.length;
    },
    likesSomeFruit() {
      return this.selectedFruits.length > 0 && !this.likesAllFruit;
    },
    icon() {
      if (this.likesAllFruit) return "mdi-close-box";
      if (this.likesSomeFruit) return "mdi-minus-box";
      return "mdi-checkbox-blank-outline";
    },

    filteredGroups: function() {
      const searchGroups = this.searchGroups.toString().toLowerCase();
      return this.groups.filter(item => {
        return item.name.toLowerCase().match(searchGroups);
      });
    }

    // filteredComponents: function () {
    //   const search = this.search.toString().toLowerCase()
    //   return this.rows.filter(item => {
    //     return (
    //       item.title.toLowerCase().match(search) ||
    //       item.controller.toLowerCase().match(search) ||
    //       item.owner.toLowerCase().match(search)
    //     )
    //   })
    // },
  },

  watch: {
    "selected.length": {
      handler: function(val, oldVal) {
        if (val === 0 && oldVal >= 1 && this.bulk_action_executing) {
          window.getApp.$emit("APP_RELOAD_MENU");
          window.getApp.$emit("APP_REFRESH");
          this.bulk_action_executing = false;
        }
      },
      deep: true
    },

    groups() {
      if (this.dialogComponent && this.groups != null) {
        this.componentSettings.group_id = this.groups[this.groups.length - 1].group_id;
      }
    }
  },

  mounted() {
    this.getGroups();
    this.getComponents();
  },

  methods: {
    mapComponentGroup(item) {
      // return item;
      return this.componentGroups.filter(cg => cg.id === item.component_group_id)[0].name;
    },

    catchGroupInputValue(e) {
      this.groupInputValue = e;
    },
    toggle() {
      this.$nextTick(() => {
        if (this.likesAllFruit) {
          this.selectedFruits = [];
        } else {
          this.selectedFruits = this.fruits.slice();
        }
      });
    },

    // Saves group data
    saveGroup() {
      axios.post("api/ComponentGroup", { name: this.group_settings.name }).then(response => {
        if (response.data.status) {
          this.dialogGroup = false;
          this.componentGroups = response.data.rows;
        }
      });
    },

    // get groups
    getGroups() {
      axios.get("api/showAllGroups").then(response => {
        if (response.data.status) {
          this.componentGroups = response.data.rows;
        }
      });
    },

    getComponents() {
      axios.get("api/showAllComponents").then(response => {
        if (response.data.status) {
          this.allComponents = response.data.rows;
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

    // copyToClipboard() {
    //   const copy = require("copy-text-to-clipboard");
    //   const value =
    //     this.rows[this.carouselActiveIndex].folder +
    //     "/" +
    //     this.rows[this.carouselActiveIndex].controller;
    //   copy(value);

    //   this.snackbar = true;
    //   this.is_status = "primary";
    //   this.is_message = value + " copied to clipboard.";
    // },

    selectComponent(item) {
      this.selectedComponent = Object.assign({}, item);
    },

    setView() {
      this.view_type = !this.view_type;
    },

    sortTitle() {
      if (!this.order_id) {
        this.rows = orderBy(this.rows, ["title"], ["desc"]);
      } else {
        this.rows = orderBy(this.rows, ["title"], ["asc"]);
      }
      this.order_id = !this.order_id;
    },

    sortCreationOrder() {
      if (!this.orderCreationOrder) {
        this.rows = orderBy(this.rows, ["id"], ["desc"]);
      } else {
        this.rows = orderBy(this.rows, ["id"], ["asc"]);
      }
      this.orderCreationOrder = !this.orderCreationOrder;
    },

    sortOwner() {
      if (!this.order_owner) {
        this.rows = orderBy(this.rows, ["owner"], ["desc"]);
      } else {
        this.rows = orderBy(this.rows, ["owner"], ["asc"]);
      }
      this.order_owner = !this.order_owner;
    },

    sortUpdated() {
      if (!this.order_updated) {
        this.rows = orderBy(this.rows, ["updated"], ["desc"]);
      } else {
        this.rows = orderBy(this.rows, ["updated"], ["asc"]);
      }
      this.order_updated = !this.order_updated;
    },

    sortSidebarVisibility() {
      if (!this.order_sidebar) {
        this.rows = orderBy(this.rows, ["menu"], ["desc"]);
      } else {
        this.rows = orderBy(this.rows, ["menu"], ["asc"]);
      }
      this.order_sidebar = !this.order_sidebar;
    },

    sortGlobal() {
      if (!this.order_global) {
        this.rows = orderBy(this.rows, ["global"], ["desc"]);
      } else {
        this.rows = orderBy(this.rows, ["global"], ["asc"]);
      }
      this.order_global = !this.order_global;
    },

    // routes the page to the desktop
    showDesktop() {
      this.$router.push("/desktop");
    },

    // Removes the selected component from selected items.
    unselect(item) {
      this.selected.splice(item.index, 1);
    },

    // Shows the little chip icon that says sidebar in case that group is visible in the sidebar.
    getSidebarActiveItems() {
      this.menu_folders = JSON.parse(sessionStorage.getItem("sitemenu_folder"));
    },

    get_tables() {
      const searchfilter = "sximo/components/searchfilter/" + "All";
      axios.get(searchfilter).then(response => {
        this.tables = response.data.tables;
      });
    },

    // Shows components that belongs to that group and stores that last group accesed to remember position.
    filterGroup(folder, groupId) {
      this.rows = [];
      this.carouselActiveIndex = 0;
      this.$store.commit("SET_COMPONENTS_activeCarouselItem", 0);

      this.$store.commit("SET_COMPONENTS_activeGroupItem", this.activeGroupItem);
      this.$store.commit("SET_COMPONENTS_activeGroupId", groupId);
      this.$store.commit("SET_COMPONENTS_activeGroupFolder", folder);

      this.activeGroupFolder = folder;
      this.getComponents("reset", groupId);
    },

    refreshGroupItems(mode) {
      this.getComponents(mode, this.GET_COMPONENTS_activeGroupId);
    },

    // Add new table in DB
    addTable() {
      this.loading = true;

      const post = {
        fields: this.table_fields
      };

      axios.post("sximo/components/addTable/" + this.table_settings.table_name, post).then(response => {
        if (response.data.status == "success") {
          // this.groups = response.data.groups
          this.snackbar = true;
          this.is_status = "primary ";
          this.is_icon = "done";
          this.is_message = "New table created successfully.";
          this.dialogTable = false;
          this.loading = false;
          this.getComponents("reset");
        } else {
          this.val_errors_group = response.data.Validation_Errors;
          this.loading = false;

          setTimeout(() => {
            this.val_errors_group = [];
          }, 3000);
        }
      });
    },

    // **** Component group dragging functions **** //
    updateGroup(evt) {
      const vm = this;
      vm.dragReorderGroup(evt.oldIndex, evt.newIndex);
    },

    dragReorderGroup(oldIndex, newIndex) {
      // move the item in the underlying array
      this.groups.splice(newIndex, 0, this.groups.splice(oldIndex, 1)[0]);

      // set new order values in each row item field "itemOrder"
      this.groups.forEach(function(item, index) {
        item.ordering = index;
      });

      // collect new row values and post changes to backend.
      this.groups.forEach(function(item) {
        const post = item;
        post.group_id = item.group_id;

        axios.post("sximo/components/saveGroup", post);
        window.getApp.$emit("APP_RELOAD_MENU");
      });
      // this.snackbar = true
      // this.is_status = 'primary '
      // this.is_icon = 'done'
      // this.is_message = 'Group order changed.'
      this.alert = true;
    },
    // **** END Component group dragging functions **** //
    // **** Components  dragging functions **** //

    updateComponents(evt) {
      const vm = this;
      vm.dragReorderComponents(evt.oldIndex, evt.newIndex);
    },

    dragReorderComponents(oldIndex, newIndex) {
      // move the item in the underlying array
      this.rows.splice(newIndex, 0, this.rows.splice(oldIndex, 1)[0]);

      // set new order values in each row item field "itemOrder"

      this.rows.forEach((item, index) => {
        item.itemOrder = index;
      });

      // collect new row values and post changes to backend.
      this.rows.forEach(item => {
        const save = {
          id: item.controller,
          data: item
        };

        axios.post("sximo/components/saveComponentSortOrder/" + item.controller, save).then(response => {
          if (response.data.status == "success") {
            // this.bulk_action_executing = true
            // this.is_status = 'primary '
            // this.is_icon = 'thumb_up'
            // this.is_message = 'Components re-arranged.'
            // this.snackbar = true
            this.alert = true;
            window.getApp.$emit("APP_RELOAD_MENU");
          }
        });
      });
    },

    // **** END Component group dragging functions **** //

    getComponentByGroup() {
      axios.get("sximo/components/getComponentByGroup/" + this.componentSettings.group_id).then(response => {
        this.groupComponent = response.data.data;
      });
    },

    getField() {
      axios.get("sximo/components/keys/" + this.componentSettings.table).then(response => {
        this.field = response.data.data;
      });
    },

    add() {
      this.dialogComponent = true;
    },

    addGroup() {
      this.dialogGroup = true;
      this.newGroup = 1;
      this.group_id = "";
      this.dialogGroup = true;
      this.group_settings = {
        name: "",
        folder: "",
        icon: "",
        ordering: "",
        group_id: ""
      };

      if (this.groups[0] == null) {
        this.group_settings.group_settings = 1;
      }
      this.group_settings.ordering = this.groups[this.groups.length - 1].ordering * 1 + 1;
    },

    editGroup(item) {
      this.newGroup = 0;
      this.group_id = item.group_id;
      this.group_settings = item;
      this.dialogGroup = true;
    },

    deleteGroup(total, id, name) {
      if (this.group_settings.total === "0") {
        this.$swal({
          title: "Remove group " + name + "?",
          text: "Are you sure you want to remove this group?",
          showCancelButton: true,
          confirmButtonText: "Yes",
          cancelButtonText: "Cancel",
          confirmButtonColor: "grey",
          backdrop: "rgba(108, 122, 137, 0.8)"
        }).then(result => {
          if (result.value) {
            axios.get("sximo/components/deleteGroup/" + id).then(response => {
              if (response.data.status == "error") {
                this.is_status = "error";
                this.is_message = response.data.message;
                this.snackbar = true;
              } else {
                this.dialogGroup = false;
                this.groups = response.data.groups;
                this.$store.commit("SET_COMPONENTS_activeGroupItem", 0);

                this.$store.commit("SET_COMPONENTS_activeGroupId", "All");

                window.getApp.$emit("APP_RELOAD_MENU");
                window.getApp.$emit("APP_REFRESH");
              }
            });
          } else {
            console.log("cancel");
          }
        });
      } else {
        this.$swal({
          title: "Group Removal",
          text: "This group still contains " + total + " components inside",
          type: "warning",
          confirmButtonText: "Close",
          confirmButtonColor: "primary",
          backdrop: "rgba(108, 122, 137, 0.8)"
        });
      }
    },

    close() {
      this.dialogComponent = false;
      this.dialogGroup = false;
      this.dialogSelected = false;
      this.val_errors_group = [];
      this.val_errors_icon = [];
      this.val_errors_component = [];
    },

    closeComponent() {
      this.$router.push("/SystemSettings/Blankpage");
    },

    generate() {
      axios.post("api/Component", this.componentSettings).then(response => {
        if (response.data.status) {
          this.allComponents = response.data.rows;
        }
      });
    },

    manage(table, controller) {
      this.$router.push("/ComponentsManagement/info?table=" + table + "&id=" + controller);

      this.$store.commit("SET_COMPONENTS_activeCarouselItem", this.carouselActiveIndex);
    },

    checkRemovalProtection_bulk() {
      for (var i = 0; i < this.selected.length; i++) {
        if (Object.prototype.hasOwnProperty.call(this.selected[i], "protected") && this.selected[i].protected === "1") {
          this.protected = true;
        }
      }
    },

    deleteComponentBulk(length) {
      this.checkRemovalProtection_bulk();

      if (!this.protected) {
        this.$swal({
          title: "Component removal",
          text: "Are you sure you want to remove these  " + length + " components?",
          type: "warning",
          showCancelButton: true,
          confirmButtonText: "Remove",
          cancelButtonText: "Cancel",
          confirmButtonColor: "#546E7A",
          backdrop: "rgba(108, 122, 137, 0.8)"
        }).then(result => {
          if (result.value) {
            this.selected.forEach(function(item) {
              axios.get("sximo/components/deleteComponent/" + item.id);
            });

            this.$swal({
              title: "Removing",
              text: "Removing selected components, give it a few seconds...",
              type: "error",
              showCancelButton: false, // There won't be any cancel button
              showConfirmButton: false, // There won't be any confirm button
              allowOutsideClick: false,
              backdrop: "rgba(108, 122, 137, 0.8)"
            });
          }
        });
      } else {
        this.$swal({
          title: "Component removal",
          text: "This component is protected against accidental removal.",
          confirmButtonText: "Close",
          confirmButtonColor: "primary",
          backdrop: "rgba(108, 122, 137, 0.8)",
          imageUrl: `${this.uploadPath}/images/protect.svg`,
          imageHeight: 150
        });
      }
    },

    enableProtectionBulk(lenght) {
      this.$swal({
        title: "Protect against removal",
        text: "You will be protecting  " + lenght + " components.",
        type: "info",
        showCancelButton: true,
        confirmButtonText: "Go ahead",
        cancelButtonText: "Close",
        confirmButtonColor: "primary",
        backdrop: "rgba(108, 122, 137, 0.8)"
      }).then(result => {
        if (result.value) {
          // set new order values in each row item field "itemOrder"
          this.selected.forEach(item => {
            item.updated = moment().format("YYYY-MM-DD HH:mm:ss");
            item.protected = "1";
          });

          this.selected.forEach(item => {
            const save = {
              id: item.controller,
              data: item
            };

            axios.post("sximo/components/saveComponentBulk/" + item.controller, save).then(response => {
              if (response.data.status == "success") {
                this.bulk_action_executing = true;
                this.is_status = "primary ";
                this.is_icon = "thumb_up";
                this.is_message = "Selected components are now visible in the sidebar ";
                this.snackbar = true;
                this.selected = [];
              }
            });
          });
        }
      });
    },

    disableProtectionBulk(lenght) {
      this.$swal({
        title: "Disable removal protection",
        text: lenght + " components will lose its removal protection.",
        type: "question",
        showCancelButton: true,
        confirmButtonText: "Go ahead",
        cancelButtonText: "Close",
        confirmButtonColor: "primary",
        backdrop: "rgba(108, 122, 137, 0.8)"
      }).then(result => {
        if (result.value) {
          // set new order values in each row item field "itemOrder"
          this.selected.forEach(item => {
            item.updated = moment().format("YYYY-MM-DD HH:mm:ss");
            item.protected = "0";
          });

          this.selected.forEach(item => {
            const save = {
              id: item.controller,
              data: item
            };

            axios.post("sximo/components/saveComponentBulk/" + item.controller, save).then(response => {
              if (response.data.status == "success") {
                this.bulk_action_executing = true;
                this.is_status = "primary ";
                this.is_icon = "thumb_up";
                this.is_message = "Selected components are now visible in the sidebar ";
                this.snackbar = true;
                this.selected = [];
              }
            });
          });
        }
      });
    },

    sidebarBulkVisible(lenght) {
      this.$swal({
        title: "Sidebar visibility",
        text: "Set  " + lenght + " components as visible in the sidebar?",
        type: "question",
        showCancelButton: true,
        confirmButtonText: "Go ahead",
        cancelButtonText: "Close",
        confirmButtonColor: "primary",
        backdrop: "rgba(108, 122, 137, 0.8)"
      }).then(result => {
        if (result.value) {
          // set new order values in each row item field "itemOrder"
          this.selected.forEach(item => {
            item.updated = moment().format("YYYY-MM-DD HH:mm:ss");
            item.menu = "1";
          });

          this.selected.forEach(item => {
            const save = {
              id: item.controller,
              data: item
            };

            axios.post("sximo/components/saveComponentBulk/" + item.controller, save).then(response => {
              if (response.data.status == "success") {
                this.bulk_action_executing = true;
                this.is_status = "primary ";
                this.is_icon = "thumb_up";
                this.is_message = "Selected components are now visible in the sidebar ";
                this.snackbar = true;
                this.selected = [];
              }
            });
          });
        }
      });
    },

    sidebarBulkHidden(lenght) {
      this.$swal({
        title: "Sidebar visibility",
        text: "Hide   " + lenght + " components from the sidebar?",
        type: "question",
        showCancelButton: true,
        confirmButtonText: "Go ahead",
        cancelButtonText: "Close",
        confirmButtonColor: "primary",
        backdrop: "rgba(108, 122, 137, 0.8)"
      }).then(result => {
        if (result.value) {
          // set new order values in each row item field "itemOrder"
          this.selected.forEach(item => {
            item.updated = moment().format("YYYY-MM-DD HH:mm:ss");
            item.menu = "0";
          });

          this.selected.forEach(item => {
            const save = {
              id: item.controller,
              data: item
            };

            axios.post("sximo/components/saveComponentBulk/" + item.controller, save).then(response => {
              if (response.data.status == "success") {
                this.bulk_action_executing = true;
                this.is_status = "primary ";
                this.is_icon = "thumb_up";
                this.is_message = "Selected components are now visible in the sidebar ";
                this.snackbar = true;
                this.selected = [];
              }
            });
          });
        }
      });
    },

    checkRemovalProtection(item) {
      if (Object.prototype.hasOwnProperty.call(item, "protected") && item.protected == "0") {
        this.deleteComponent(item.id);
      } else {
        this.$swal({
          title: "Component removal",
          text: "This component is protected against accidental removal.",
          confirmButtonText: "Close",
          confirmButtonColor: "grey",
          backdrop: "rgba(108, 122, 137, 0.8)",
          imageUrl: `${this.uploadPath}/images/protect.svg`,
          imageHeight: 150,
          width: 500
        });
      }
    },

    deleteComponent(id) {
      this.$swal({
        title: "Component Removal ",
        text: "Are you sure you want to remove this component?",
        showCancelButton: true,
        confirmButtonText: "Remove",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#EF9A9A",
        backdrop: "rgba(108, 122, 137, 0.8)",
        imageUrl: `${this.uploadPath}/images/remove.svg`,
        imageHeight: 150,
        width: 500
      }).then(result => {
        if (result.value) {
          axios.get("sximo/components/deleteComponent/" + id).then(() => {
            this.$swal({
              title: "Removing",
              text: "Your component is being removed...",
              type: "error",
              showCancelButton: false, // There won't be any cancel button
              showConfirmButton: false, // There won't be any confirm button
              allowOutsideClick: false,
              backdrop: "rgba(108, 122, 137, 0.8)",
              timer: 3000,
              timerProgressBar: true,
              imageUrl: `${this.uploadPath}/images/remove.svg`,
              imageHeight: 150,
              width: 500
            });
            this.refreshGroupItems("created");
          });
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

.box {
  display: flex;
  flex-wrap: wrap;
}

::v-deep .v-list-item--link:before {
  background-color: unset;
}

.moving {
  zoom: 0.3;
}

.flip-list-move {
  transition: transform 0.5s;
}

.v-icon.on-hover {
  color: black;
  transition: color 0.3s ease-in-out;
}

.v-icon {
  color: lightgrey;
  transition: color 0.3s ease-in-out;
}

.background {
  background: rgba(255, 255, 255, 0.8) !important;
}

.drag {
  cursor: grab;
}

.drag:active {
  cursor: grabbing;
  transform: scale(0.99); /* Equal to scaleX(0.7) scaleY(0.7) */
}

.ghost {
  opacity: 0.5;
  background: rgb(160, 214, 216);
}
</style>
