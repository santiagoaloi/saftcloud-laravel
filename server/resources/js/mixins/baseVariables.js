export default {
  name: "baseVariables",
  data() {
    return {
      duplicatedRecords: [],
      validateFields: [],
      enterSubmits: true,

      appBar: {
        search: "",
        loaders: {
          refreshing: false,
          booting: false,
          loading: false,
        },
        access: [],
        optionVariables: [],
        pagination: [],
        selected: [],
        icon: "",
        pageHeader: "",
        customView: false,
      },

      refreshing: false,

      booting: true,
      loading: false,
      selected: [],

      language: "English",
      dialogSelected: false,
      dialogFormInputs: false,

      /* From Menus */
      verticalMenu: "",
      menuPosition: "",
      formMenus: [],

      isNewItem: false,
      rowItemKey: "",

      /* Desktop Shortcut */
      desktop: "",
      desktop_access: [
        {
          username: "",
          x: 0,
          y: 0,
          context_menu_activator: false,
          loading: false,
          path: "",
          controller: "",
          icon: "",
          id: Date.now(),
        },
      ],

      componentSettings: {},

      // Data export
      selecteHeaders: {},

      /* Codeigniter  queries */
      query: [],
      query_save: [],
      query_delete: [],
      query_data: [],
      query_table: [],
      component: "",

      /* log data */
      log_insert: "",
      log_change: "",
      log_remove: "",
      logs: "",
      user: "",

      /* Dinamic Data API */
      pageHeader: "",
      primaryKey: null,
      headers: [],
      rows: [],
      formFields: [],
      rowItem: [],
      options: [],
      access: {
        is_add: 0,
        is_view: 0,
        is_edit: 0,
        is_remove: 0,
      },

      icon: "",
      breadCrumbs: "",
    };
  },

  watch: {
    refreshing: {
      handler: function (val, oldVal) {
        if (val != oldVal) {
          this.appBar.loaders.refreshing = this.refreshing;
        }
      },
      deep: true,
    },

    selected: {
      handler: function (val, oldVal) {
        if (val != oldVal) {
          this.appBar.selected = this.selected;
        }
      },
      deep: true,
    },
  },
};
