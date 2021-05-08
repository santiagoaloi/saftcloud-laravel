import axios from "axios";
import warningSound from "@/assets/sounds/warning.mp3";

export default {
  name: "BaseFunctions",

  computed: {
    emptyRows() {
      if (this.rows.length == 0) {
        return true;
      }
      return false;
    },
  },

  mounted() {
    var audio = new Audio();
    audio.preload = "auto";

    this.callApi();
  },

  methods: {
    exportData() {
      this.exportRows();
      this.exportHeaders();
    },

    exportRows() {
      this.$store.commit(
        "SET_EXPORT_ROWS",
        this.$refs.defaultTable.$refs.dataTable.$children[0].filteredItems
      );
    },

    exportHeaders() {
      const headers = this.headers.filter(
        (header) => header.value != "actions"
      );
      this.$store.commit("SET_EXPORT_HEADERS", headers);
    },

    defaultValue() {
      return true;
    },

    disabledFunction(functionName) {
      if (functionName != "") {
        return this[functionName]();
      }
    },

    dumpRowsToFunction(functionName, rows) {
      try {
        this[functionName](rows);
      } catch (e) {
        this.$swal({
          title: "Function not found",
          html: ` We couldn't find the function "${functionName}" </br> The results can't be loaded.`,
          confirmButtonText: "Close",
          confirmButtonColor: "grey",
          backdrop: "rgba(108, 122, 137, 0.8)",
          animation: false,
          icon: "error",
          width: 500,
        });
      }
    },

    bindFunction(functionName) {
      try {
        this[functionName]();
      } catch (e) {
        this.$swal({
          title: "Function not found",
          text: ` We couldn't find the function "${functionName}"`,
          confirmButtonText: "Close",
          confirmButtonColor: "grey",
          backdrop: "rgba(108, 122, 137, 0.8)",
          animation: false,
          icon: "error",
          width: 500,
        });
      }
    },

    bindIfStatement(functionName) {
      try {
        return this[functionName]();
      } catch (e) {
        this.$swal({
          title: "Function not found",
          text: ` We couldn't find the function "${functionName}"`,
          confirmButtonText: "Close",
          confirmButtonColor: "grey",
          backdrop: "rgba(108, 122, 137, 0.8)",
          animation: false,
          icon: "error",
          width: 500,
        });
      }
    },

    inputFunction(functionName, params) {
      try {
        if (functionName != "") {
          this[functionName](params);
        }
      } catch (e) {
        this.$swal({
          title: "Function not found",
          text: ` We couldn't find the function "${functionName}"`,
          confirmButtonText: "Close",
          confirmButtonColor: "grey",
          backdrop: "rgba(108, 122, 137, 0.8)",
          animation: false,
          icon: "error",
          width: 500,
        });
      }
    },

    changeFunction(functionName, params) {
      try {
        if (functionName != "") {
          this[functionName](params);
        }
      } catch (e) {
        this.$swal({
          title: "Function not found",
          text: ` We couldn't find the function "${functionName}"`,
          confirmButtonText: "Close",
          confirmButtonColor: "grey",
          backdrop: "rgba(108, 122, 137, 0.8)",
          animation: false,
          icon: "error",
          width: 500,
        });
      }
    },

    focusFunction(functionName, params) {
      try {
        if (functionName != "") {
          this[functionName](params);
        }
      } catch (e) {
        this.$swal({
          title: "Function not found",
          text: ` We couldn't find the function "${functionName}"`,
          confirmButtonText: "Close",
          confirmButtonColor: "grey",
          backdrop: "rgba(108, 122, 137, 0.8)",
          animation: false,
          icon: "error",
          width: 500,
        });
      }
    },

    blurFunction(functionName, fieldValue, fieldName) {
      try {
        if (functionName != "") {
          this[functionName](fieldValue, fieldName);
        }
      } catch (e) {
        this.$swal({
          title: "Function not found",
          text: ` We couldn't find the function "${functionName}"`,
          confirmButtonText: "Close",
          confirmButtonColor: "grey",
          backdrop: "rgba(108, 122, 137, 0.8)",
          animation: false,
          icon: "error",
          width: 500,
        });
      }
    },

    formFieldSelectSlotFunction(functionName) {
      try {
        if (functionName != "") {
          this[functionName]();
        }
      } catch (e) {
        this.$swal({
          title: "Function not found",
          text: ` We couldn't find the function "${functionName}"`,
          confirmButtonText: "Close",
          confirmButtonColor: "grey",
          backdrop: "rgba(108, 122, 137, 0.8)",
          animation: false,
          icon: "error",
          width: 500,
        });
      }
    },

    refreshOptions() {
      axios.get(this.controller).then((response) => {
        if (response.data.status == "success") {
          this.options = response.data.data.options;
        }
      });
    },

    dumpRows(rows) {},

    callApi() {
      axios.get(`${this.controller}/runGetFunction/index`).then((response) => {
        if (response.data.status == "Success") {
          this.componentSettings = response.data.data.componentConfig;

          this.access = response.data.access;
          this.pageHeader = response.data.data.title;
          this.primaryKey = response.data.data.key;

          if (this.componentSettings.dumpResultsInFunction.active) {
            this.dumpRowsToFunction(
              this.componentSettings.dumpResultsInFunction.function,
              response.data.data.rows
            );
          } else {
            this.rows = response.data.data.rows;
          }

          this.formFields = response.data.data.formFields;
          this.rowItem = response.data.data.models;
          this.options = response.data.data.options;

          this.headers.unshift(...response.data.data.headers);

          this.detailItem = response.data.data.details;

          this.APIloading = false;

          /* Shortcut creation data */
          this.desktop = response.data.desktop;
          this.desktop_access[0].icon = response.data.icon;
          this.desktop_access[0].title = response.data.title;
          this.desktop_access[0].path = response.data.path;
          this.desktop_access[0].username = this.profile.uname;
          this.desktop_access[0].controller = response.data.controller;

          this.icon = response.data.icon;

          this.appBar.access = response.data.access;
          this.appBar.pagination = response.data.data.setting;
          this.appBar.pageHeader = response.data.data.title;
          this.appBar.optionVariables = response.data.data.appBarOptions;

          this.post = {
            ids: this.rowItemKey,
            key: this.primaryKey,
            log_insert: this.log_insert,
            log_change: this.log_change,
            context: this.component,
            table: this.query_table,
            user: this.user,
            action_task: "save",
            data: "",
          };

          this.getVerticalMenuStatus();
          this.getMenuOrientation();
          this.getComponentFormMenu();

          window.getApp.$emit("APP_HIDE_SPINNER");

          this.booting = false;

          this.headers.push({text: "Actions", value: "actions", sortable: false});
        }
      });
    },

    async checkRecordDuplication(
      rowItemKeyValue,
      primaryKeyColumn,
      table,
      fieldName,
      fieldValue
    ) {
      const post = {
        rowItemKeyValue: rowItemKeyValue,
        primaryKeyColumn: primaryKeyColumn,
        table: table,
        fieldName: fieldName,
        fieldValue: fieldValue,
      };
      return axios
        .post(`site/checkRecordDuplication/`, post)
        .then((response) => {
          return response.data.status;
        });
    },

    async checkRecordDuplicationInternal(
      rowItemKeyValue,
      primaryKeyColumn,
      table,
      fieldName,
      fieldValue
    ) {
      const post = {
        rowItemKeyValue: rowItemKeyValue,
        primaryKeyColumn: primaryKeyColumn,
        table: table,
        fieldName: fieldName,
        fieldValue: fieldValue,
      };
      return axios
        .post(`site/checkRecordDuplication/`, post)
        .then((response) => {
          if (response.data.status) {
            this.duplicatedRecords.push(response.data.field);
          }
        });
    },

    saveItem() {
      this.duplicatedRecords = [];
      this.validateFields = [];
      let counter = 0;

      for (var field in this.formFields) {
        counter++;
        if (this.formFields[field].params.validation.unique) {
          this.validateFields.push({
            name: field,
            value: this.rowItem[field],
            id: this.rowItem[this.primaryKey],
          });
        }
      }

      if (counter == Object.keys(this.formFields).length) {
        let counterValidations = 0;
        this.validateFields.forEach((field) => {
          counterValidations++;
          this.checkRecordDuplicationInternal(
            field.id,
            this.primaryKey,
            this.query_table,
            field.name,
            field.value
          );
        });

        setTimeout(() => {
          if (counterValidations == this.validateFields.length) {
            this.$refs.baseCrudDialog.$refs.baseFormInputs.$refs.formValidation
              .validate()
              .then((success) => {
                if (success) {
                  if (this.duplicatedRecords.length == 0) {
                    this.loading = true;
                    const post = {
                      ids: this.rowItemKey,
                      key: this.primaryKey,
                      log_insert: this.log_insert,
                      log_change: this.log_change,
                      context: this.component,
                      table: this.query_table,
                      user: this.user,
                      action_task: "save",
                      data: this.rowItem,
                    };

                    axios.post(this.controller, post).then((response) => {
                      if (response.data.status == "success") {
                        this.loading = false;
                        this.close();
                        this.refreshRows();
                        this.rowItem = {};
                      } else {
                        this.loading = false;
                      }
                    });
                  }
                }
              });
          }
        }, 500);
      }
    },

    refreshRows() {
      this.refreshing = true;
      let post = {
        itemsTable: this.itemsTable,
      };
      return axios
        .post(`${this.controller}/runPostFunction/refreshRows/`, post)
        .then((response) => {
          if (response.data.status == "Success") {
            this.rows = response.data.data.rows;
            this.refreshing = false;
          }
        });
    },

    close() {
      this.dialogFormInputs = false;
      this.rowItem = {};
    },

    addItem() {
      this.isNewItem = true;
      this.rowItemKey = "";
      this.dialogFormInputs = true;
      this.selectedMenuTab = 0;

      // Sets the default field value for Input parameters option values.
      for (var field in this.formFields) {
        this.rowItem[field] = this.formFields[
          field
        ].params.inputParametersDefault;
      }
    },

    editItem(item) {
      this.duplicatedRecords = [];
      this.selectedMenuTab = 0;
      this.dialogFormInputs = true;
      this.isNewItem = false;
      this.rowIndex = this.rows.indexOf(item);
      this.rowItem = Object.assign({}, item);
      this.rowItemView = Object.assign({}, item);
      this.rowItemKey = item[this.primaryKey];
      this.post.ids = item[this.primaryKey];
    },

    deleteItem(item) {
      this.rowIndex = this.rows.indexOf(item);
      this.rowItem = Object.assign({}, item);
      this.rowItemKey = item[this.primaryKey];

      const post = {
        ids: this.rowItemKey,
        action_task: "delete",
      };

      this.$swal({
        width: 450,
        title: "Remove record",
        html:
          "Do you really intend to remove this record?" +
          "<br>" +
          "This operation cannot be undone.",
        type: "question",
        showCancelButton: true,
        confirmButtonText: "Remove",
        cancelButtonText: "Cancel",
        confirmButtonColor: "teal",
      }).then((result) => {
        if (result.value) {
          axios
            .post(`${this.controller}/runPostFunction/index/`, post)
            .then((response) => {
              this.query_delete = response.data.query;

              window.getApp.$emit(
                "APP_SHOW_SNACKBAR",
                "grey darken-1",
                "mdi-information-variant",
                "record removed"
              );
              this.refreshRows();
            });
        }
      });
      var audio = new Audio(warningSound);
      audio.play();
    },

    deleteItemBulk(lenght) {
      this.$swal({
        title: "Remove multiple items",
        text: "Are you sure you want to delete these  " + lenght + " items?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Go ahead",
        cancelButtonText: "Close",
        confirmButtonColor: "#e57373",
      }).then((result) => {
        if (result.value) {
          this.selected
            .forEach((item) => {
              const post = {
                ids: item[this.primaryKey],
                action_task: "delete",
              };

              axios
                .post(`${this.controller}/runPostFunction/index/`, post)
                .then((response) => {
                  if (response.data.status == "Success") {
                    this.bulk_action_executing = true;
                    this.query_delete = response.data.query;
                    this.is_status = "#e57373";
                    this.is_icon = "delete";
                    this.is_message = lenght + " Items removed";
                    this.snackbar = true;
                    this.selected = [];
                  }
                });
            })

            .then(() => {
              this.refreshRows();
            });
        }
      });
    },

    getVerticalMenuStatus() {
      axios
        .post("sximo/components/getVerticalMenuStatus/" + this.component)
        .then((response) => {
          this.verticalMenu = response.data[0].vertical_menu;
        });
    },

    getMenuOrientation() {
      axios
        .post("sximo/components/getMenuOrientation/" + this.component)
        .then((response) => {
          this.menuPosition = response.data[0].menuOrientation;
        });
    },

    getComponentFormMenu() {
      axios
        .post("sximo/components/getComponentFormMenu/" + this.component)
        .then((response) => {
          if (response.data.status == "success") {
            const payload = response.data[0];

            if (payload != null) {
              if (payload.menus != "") {
                payload.menuData = JSON.parse(payload.menuData);
              }
              this.formMenus = payload.menuData;
            }
          }
        });
    },

    showDataTable() {
      this.dialogDataTable = true;
    },

    configure() {
      const url =
        "/secure/manage/config?table=" +
        this.query_table +
        "&id=" +
        this.component;
      this.$router.push(url);
    },

    createDesktopShortcut() {
      const post = {
        data: this.desktop_access,
        username: this.profile.uname,
      };

      axios
        .post(`${this.controller}/runPostFunction/createDesktopShortcut/`, post)
        .then((response) => {
          if (response.data.status == "Success") {
            this.is_icon = "done";
            this.is_status = "#00B985";
            this.is_message = " shortcut added to desktop.";
            this.snackbar = true;
          } else {
            this.is_status = "#00B985";
            this.is_message = response.data.message;
            this.snackbar = true;
          }
        });
    },

    saveCustomView() {
      const save = {
        id: this.component,
        data: this.pagination,
      };

      axios
        .post(
          "sximo/components/saveInfo_customView/" +
            this.component +
            "/" +
            this.desktop +
            "/" +
            this.pageHeader,
          save
        )
        .then((response) => {
          if (response.data.status == "success") {
            this.is_message = "Table view setting saved.";
            this.is_icon = "done";
            this.is_status = "#00B985";
            this.snackbar = true;
          }
        });
    },

    pickFile(e) {
      console.log();
      const ref = e.target.name;
      var el = document.getElementById("upl-" + ref);
      el.click();
    },

    onFilePicked(e) {
      const files = e.target.files;
      const html_id = e.target.name;
      console.log(e);

      if (files[0] !== undefined) {
        const imageName = files[0].name;
        const imageType = files[0].type;
        if (imageName.lastIndexOf(".") <= 0) {
          return;
        }
        const fr = new FileReader();
        fr.readAsDataURL(files[0]);
        fr.addEventListener("load", () => {
          this.rowItem[html_id] = files[0];
          this.rowItem[html_id] = {
            url: fr.result,
            ext: imageType,
          };
        });
      }
    },
  },
};
