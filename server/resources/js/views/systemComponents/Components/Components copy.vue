<template>
  <div>
    <baseLayoutCard transparent level="1">
      <components-appbar :parent-data="$data" />

      <v-row class="mb-0 pa-0" no-gutters>
        <v-col cols="12" sm="12" md="3">
          <baseLayoutCard level="2" style="overflow: auto; background: #f5f5f5">
            <v-text-field
              v-model="searchGroups"
              full-width
              hide-details
              rounded
              label="Search groups..."
              prepend-inner-icon="mdi-magnify"
              color="primary darken-2"
            />

            <v-list-item-group v-model="activeGroupItem" :mandatory="!first_boot">
              <v-list color="transparent" outlined>
                <v-list-item active-class="primary--text blue-grey lighten-4 " @click.stop="filterGroup('All', '1'), (search = '')">
                  <v-list-item-action>
                    <v-btn disabled icon class="black-text" color="grey darken-1">
                      <v-icon>mdi-folder</v-icon>
                    </v-btn>
                  </v-list-item-action>

                  <v-list-item-content>
                    <v-list-item-title>All</v-list-item-title>
                    <v-list-item-subtitle> Show all {{ count }} components. </v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
                <v-divider class="px-4 my-2" />

                <draggable
                  v-model="groups"
                  handle=".my-handle"
                  :delay="100"
                  :delay-on-touch-only="true"
                  :options="{ animation: 500 }"
                  ghost-class="ghost"
                  @change="updateGroup"
                >
                  <v-list-item
                    v-for="item in filteredGroups"
                    :key="item.group_id"
                    active-class="primary--text blue-grey lighten-4 "
                    :ripple="false"
                    class="item"
                    @click.native="filterGroup(item.folder, item.group_id), (search = '')"
                  >
                    <v-tooltip color="black" open-delay="450" nudge-bottom="5" max-width="250" close-delay="100" bottom>
                      <template v-slot:activator="{ on }">
                        <v-list-item-action v-on="on">
                          <v-hover v-slot:default="{ hover }">
                            <v-btn :disabled="item.name === 'All'" icon class="black-text" @click.stop="editGroup(item), (dialogGroup = true)">
                              <v-icon :class="hover ? 'on-hover' : ''">
                                {{ hover ? "mdi-pencil-outline" : "mdi-folder" }}
                              </v-icon>
                            </v-btn>
                          </v-hover>
                        </v-list-item-action>
                      </template>
                      <span>Edit group</span>
                    </v-tooltip>

                    <v-list-item-content>
                      <v-list-item-title>{{ item.name }}</v-list-item-title>
                      <v-list-item-subtitle v-if="item.total === '1'"> {{ item.total }} component </v-list-item-subtitle>
                      <v-list-item-subtitle v-if="item.total > '1'"> {{ item.total }} components </v-list-item-subtitle>
                      <v-list-item-subtitle v-if="item.total === '0' && item.name !== 'All'">
                        No components.
                      </v-list-item-subtitle>
                    </v-list-item-content>

                    <v-icon class="my-handle drag"> mdi-drag-vertical </v-icon>
                  </v-list-item>
                </draggable>
              </v-list>
            </v-list-item-group>
          </baseLayoutCard>
        </v-col>

        <v-col cols="12" sm="12" md="6">
          <!-- COMPONENTS TABLE VIEW -->
          <!-- <components-table :parent-data="$data" /> -->
          <!-- <v-row no-gutters>
            <v-col class="py-0" lg="8"> -->
          <!-- <v-fade-transition>
                <template v-if="!view_type && rows.length == 0 && !loadingRows">
                  <v-container
                    class="text-center fill-height"
                    style="height: calc(100vh - 270px)"
                  >
                    <v-row align="center" justify="center" class="fill-height">
                      <v-img
                        :src="`${uploadPath}/images/empty.svg`"
                        :max-width="500"
                      />
                    </v-row>
                    <v-row class="mt-8" align="center" justify="center">
                      Folder {{ last_search_filter | capitalize }} is empty.
                      <v-btn
                        :input-value="true"
                        text
                        rounded
                        depressed
                        class="mx-2"
                        @click.stop="dialogComponent = true"
                      >
                        Create new component
                      </v-btn>
                    </v-row>
                  </v-container>
                </template>
              </v-fade-transition> -->
          <base-loading style="background:#F5F5F5" v-if="!view_type && loadingRows" />

          <!-- COMPONENTS CAROUSEL VIEW -->
          <components-carousel v-else v-model="carouselActiveIndex" :parent-data="$data" />
        </v-col>

        <v-col cols="12" sm="12" md="3">
          <baseLayoutCard level="2" style="overflow: auto; background: #f5f5f5">
            <template v-if="rows.length >= 1 && !loadingRows">
              <v-card-title class="pb-4"> Created </v-card-title>
              <v-card-subtitle class="pb-1">
                {{ rows[carouselActiveIndex].created | momentDate }}
              </v-card-subtitle>
              <v-card-subtitle v-if="rows[carouselActiveIndex].created != ''" class="mt-n5">
                {{ rows[carouselActiveIndex].created | momentDateAgo }}
              </v-card-subtitle>

              <v-card-title class="pb-4 mt-n4"> Updated </v-card-title>
              <v-card-subtitle v-if="rows[carouselActiveIndex].updated != ''" class="pb-1">
                {{ rows[carouselActiveIndex].updated | momentDate }}
              </v-card-subtitle>
              <v-card-subtitle v-if="rows[carouselActiveIndex].updated != ''" class="mt-n5">
                {{ rows[carouselActiveIndex].updated | momentDateAgo }}
              </v-card-subtitle>
              <v-card-subtitle v-else class="pb-0"> Never </v-card-subtitle>

              <v-divider class="mx-4 mt-4" />

              <v-list class="ml-n2 mt-2 transparent">
                <v-list-item>
                  <v-list-item-avatar>
                    <v-icon :color="rows[carouselActiveIndex].global == '1' ? 'teal accent-4' : 'grey'">
                      mdi-earth
                    </v-icon>
                  </v-list-item-avatar>

                  <v-list-item-content>
                    <v-list-item-title>Global</v-list-item-title>
                    <v-list-item-subtitle v-if="rows[carouselActiveIndex].global == '1'">
                      Yes
                    </v-list-item-subtitle>
                    <v-list-item-subtitle v-else> No </v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>

                <v-list-item>
                  <v-list-item-avatar>
                    <v-icon :color="rows[carouselActiveIndex].protected == '1' ? 'teal accent-4' : 'grey'">
                      mdi-lock
                    </v-icon>
                  </v-list-item-avatar>

                  <v-list-item-content>
                    <v-list-item-title>
                      Removal protection
                    </v-list-item-title>
                    <v-list-item-subtitle v-if="rows[carouselActiveIndex].protected == '1'">
                      Enabled
                    </v-list-item-subtitle>
                    <v-list-item-subtitle v-else>
                      Disabled
                    </v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>

                <v-list-item>
                  <v-list-item-avatar>
                    <v-icon :color="rows[carouselActiveIndex].menu == '1' ? 'teal accent-4' : 'grey'">
                      mdi-menu
                    </v-icon>
                  </v-list-item-avatar>

                  <v-list-item-content>
                    <v-list-item-title>
                      Sidebar visibility
                    </v-list-item-title>
                    <v-list-item-subtitle v-if="rows[carouselActiveIndex].menu == '1'">
                      Visible
                    </v-list-item-subtitle>
                    <v-list-item-subtitle v-else>
                      Hidden
                    </v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>

                <v-list-item>
                  <v-list-item-avatar>
                    <v-icon :color="rows[carouselActiveIndex].log_context == '1' ? 'teal accent-4' : 'grey'">
                      mdi-database
                    </v-icon>
                  </v-list-item-avatar>

                  <v-list-item-content>
                    <v-list-item-title> Logs monitoring </v-list-item-title>
                    <v-list-item-subtitle v-if="rows[carouselActiveIndex].log_context == '1'">
                      Enabled
                    </v-list-item-subtitle>
                    <v-list-item-subtitle v-else>
                      Disabled
                    </v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
              </v-list>
            </template>
          </baseLayoutCard>
        </v-col>
      </v-row>
    </baseLayoutCard>

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

      icon: {
        icon: "",
        name: ""
      },

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

      headers: [
        { text: "Component", value: "title" },
        // { text: 'Controller', value: 'Controller' },
        { text: "Group", value: "folder" },
        // { text: 'protected', value: 'protected'},
        { text: "", value: "actions" }
      ],

      componentSettings: {
        prev_group_id: "",
        group_id: "1",
        parent_id: 0,
        controller: "",
        title: "",
        table: "",
        table_key: "",
        note: "",
        type: "",
        menu: false,
        owner: "",
        created: "",
        updated: ""
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

      snackbar: false,
      is_status: "",
      is_message: "",
      is_icon: "",

      groupComponent: ["No Parent"],

      items_type: [
        { value: "blank", text: " Blank Template" },
        { value: "crud", text: " Complete CRUD" },
        { value: "crud2", text: " Simple Table CRUD" },
        { value: "crud3", text: " Dropdown function CRUD" }
      ],

      nodata: store.state.baseUrl + "uploads/images/no-data.png"
    };
  },

  computed: {
    ...mapGetters(["GET_COMPONENTS_activeGroupItem", "GET_COMPONENTS_activeGroupId", "GET_COMPONENTS_activeCarouselItem", "GET_COMPONENTS_activeGroupFolder"]),

    group_id() {
      return store.state.loginData.group_id;
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

    carouselActiveIndex(val) {
      this.$store.commit("SET_COMPONENTS_activeCarouselItem", this.carouselActiveIndex);
    },

    groups() {
      if (this.dialogComponent && this.groups != null) {
        this.componentSettings.group_id = this.groups[this.groups.length - 1].group_id;
      }
    },

    search(val) {
      if (val === "") {
        this.filterGroup("All", "1");
      }
    }
  },

  mounted() {
    // if (!this.GET_COMPONENTS_activeGroupItem) {
    //   this.activeGroupFolder = "All";
    //   this.activeGroupItem = 0;
    // } else {
    //   this.activeGroupFolder = this.GET_COMPONENTS_activeGroupFolder;
    //   this.activeGroupItem = this.GET_COMPONENTS_activeGroupItem;
    //   this.activeGroupId = this.GET_COMPONENTS_activeGroupId;
    //   this.componentSettings.group_id = this.GET_COMPONENTS_activeGroupId;
    // }
    // if (!this.GET_COMPONENTS_activeCarouselItem) {
    //   this.carouselActiveIndex = 0;
    // } else {
    //   this.carouselActiveIndex = this.GET_COMPONENTS_activeCarouselItem;
    // }
    // this.componentSettings.parent_id = "No Parent";
    // this.componentSettings.type = "crud";
    // this.getComponents("boot");
    // this.getSidebarActiveItems();
  },

  methods: {
    ...mapActions(["logoutVuex"]),

    onMove({ relatedContext, draggedContext }) {
      const relatedElement = relatedContext.element;
      const draggedElement = draggedContext.element;
      return (!relatedElement || !relatedElement.fixed) && !draggedElement.fixed;
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

    // loads groups, tables and component count.
    getComponents(options, group_id) {
      this.loadingRows = true;

      if (this.first_boot) {
        this.loading_boot = true;
      }

      const searchfilter = "sximo/components/searchfilter/" + this.GET_COMPONENTS_activeGroupFolder;
      axios.get(searchfilter).then(response => {
        if (response.data.status == "success") {
          if (options === "refresh") {
            this.tables = response.data.tables;
            this.count = response.data.count;
          }

          if (options === "boot") {
            this.rows = response.data.data;
            this.groups = response.data.groups;
            this.tables = response.data.tables;
            this.count = response.data.count;
            this.loading_boot = false;
            this.first_boot = false;
          }

          if (options === "new_group") {
            this.groups = response.data.groups;
            this.count = response.data.count;

            this.$store.commit("SET_COMPONENTS_activeGroupId", this.groups[this.groups.length - 1].group_id);
            this.$store.commit("SET_COMPONENTS_activeGroupItem", this.groups.length - 1);

            this.activeGroupItem = this.groups.length - 1;
          }

          if (options === "reset") {
            this.rows = response.data.data;
            this.count = response.data.count;

            this.$store.commit("SET_COMPONENTS_activeGroupId", group_id);
            this.$store.commit("SET_COMPONENTS_activeGroupItem", this.activeGroupItem);

            this.componentSettings.group_id = group_id;
          }

          if (options === "created") {
            this.rows = response.data.data;
            this.count = response.data.count;
            this.carouselActiveIndex = this.rows.length - 1;
            this.componentSettings.group_id = group_id;
          }

          setTimeout(() => {
            this.loadingRows = false;
          }, 700);
        }
      });
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

    // Saves group data
    saveGroup() {
      if (this.group_settings.icon === "" || this.group_settings.icon === null || this.group_settings.icon === undefined) {
        this.group_settings.icon = "mdi-folder";
      }

      this.loading = true;
      const post = this.group_settings;

      axios.post("sximo/components/saveGroup", post).then(response => {
        if (response.data.status == "success") {
          this.snackbar = true;
          this.is_status = "primary ";
          this.is_icon = "done";
          this.is_message = "Group settings saved.";
          this.dialogGroup = false;
          this.val_errors_group = [];
          this.dialogGroup = false;
          this.loading = false;
          window.getApp.$emit("APP_RELOAD_MENU");
          this.getComponents("new_group");
        } else {
          this.val_errors_group = response.data.Validation_Errors;
          this.loading = false;
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
      this.componentSettings.controller = "";
      this.componentSettings.note = "";
      this.componentSettings.title = "";
      this.componentSettings.table_key = "";
      this.componentSettings.table = "";

      if (this.GET_COMPONENTS_activeGroupId) {
        this.componentSettings.group_id = this.activeGroupId;
      } else this.componentSettings.group_id = 1;
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
      this.$refs.dialogNewComponent.$refs.newComponentForm.validate().then(success => {
        if (success) {
          this.loading = true;

          this.componentSettings.prev_group_id = this.componentSettings.group_id;
          this.componentSettings.created = moment().format("YYYY-MM-DD HH:mm:ss");
          this.componentSettings.updated = moment().format("YYYY-MM-DD HH:mm:ss");
          this.componentSettings.owner = "Default";

          const post = this.componentSettings;

          axios
            .post("sximo/components/saveCreate", post)
            .then(response => {
              if (response.data.status == "success") {
                this.buildDynamicRoutes();
                this.val_errors_component = [];
                this.dialogComponent = false;

                this.$swal({
                  title: "Crafting component",
                  text: "Building... give it a few seconds.",
                  showCancelButton: false, // There won't be any cancel button
                  showConfirmButton: false, // There won't be any confirm button
                  allowOutsideClick: false,
                  backdrop: "rgba(108, 122, 137, 0.8)",
                  timer: 3000,
                  timerProgressBar: true,
                  imageUrl: `${this.uploadPath}/images/building.svg`,
                  imageHeight: 150
                });

                this.loading = false;
                this.close();
                this.refreshGroupItems("created");
              } else {
                this.val_errors_component = response.data.Validation_Errors;
                this.loading = false;
                setTimeout(() => {
                  this.val_errors_component = [];
                }, 3000);
              }
            })
            .catch(() => {
              this.close();
              this.dialogComponent = false;
            });
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
