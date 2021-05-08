import axios from "axios";

export default {
  computed: {
    computedDateFormattedMomentjs() {
      return this.dropdown_customer_vmodel.birthday
        ? moment(this.dropdown_customer_vmodel.birthday).format("YYYY-MM-DD")
        : "";
    },
    computedDateFormattedDatefns() {
      return this.dropdown_customer_vmodel.birthday
        ? format(this.dropdown_customer_vmodel.birthday, "YYYY-MM-DD")
        : "";
    },
  },

  methods: {
    getDropdownCustomers() {
      let post = {
        cashier_id: this.profile.uid,
      };
      axios
        .post(`${this.controller}/runPostFunction/getDropdownCustomers/`, post)
        .then((response) => {
          if (response.data.status === "Success") {
            this.dropdown_customers = response.data.rows;
            if (sessionStorage.getItem("customer_vmodel") == undefined) {
              this.dropdown_customer_vmodel = response.data.rows[0];
            }
          }
        });
    },

    getZones() {
      axios
        .get(`${this.controller}/runGetFunction/getZones/`)
        .then((response) => {
          if (response.data.status == "Success") {
            this.zoneDropdown = response.data.rows;
          }
        });
    },

    getDays() {
      axios
        .get(`${this.controller}/runGetFunction/getDays/`)
        .then((response) => {
          if (response.data.status == "Success") {
            this.dayDropdown = response.data.rows;
          }
        });
    },

    getSellers() {
      axios
        .get(`${this.controller}/runGetFunction/getSellers/`)
        .then((response) => {
          if (response.data.status === "Success") {
            this.dropdownSellers = response.data.rows;
          }
        });
    },

    refreshDropdownCustomerVmodel() {
      let post = {
        customer_id: this.dropdown_customer_vmodel.customer_id,
      };
      axios
        .post(
          `${this.controller}/runPostFunction/refreshDropdownCustomerVmodel/`,
          post
        )
        .then((response) => {
          if (response.data.status === "Success") {
            this.dropdown_customer_vmodel = response.data.rows;
            if (this.dropdown_customer_vmodel.customer_ctacte_id > 0) {
              this.lookupCcte();
            }
          }
        });
    },

    setCustomer() {
      sessionStorage.setItem(
        "customer_vmodel",
        JSON.stringify(this.dropdown_customer_vmodel)
      );
    },

    selectCustomer() {
      sessionStorage.setItem(
        "customer_vmodel",
        JSON.stringify(this.dropdown_customer_vmodel)
      );
      let post = {
        customer_id: this.dropdown_customer_vmodel.customer_id,
        transaction_id: this.temporalTransactionId,
      };
      axios
        .post(`${this.controller}/runPostFunction/selectCustomer/`, post)
        .then((response) => {
          if (response.data.status === "Success") {
            this.dropdown_customer_vmodel = response.data.rows;
          }
        });
    },

    lookupCcte() {
      let post = {
        customer_ctacte_id: this.dropdown_customer_vmodel.customer_ctacte_id,
      };
      axios
        .post(`${this.controller}/runPostFunction/lookupCcte/`, post)
        .then((response) => {
          if (response.data.status === "Success") {
            this.dropdownCtaCteVmodel = response.data.row;
            if (this.dropdownCtaCteVmodel !== null) {
              this.check_ccte_existence();
              this.check_user_selected();
            }
          }
        });
    },

    create_ctacte() {
      this.ccte_loading = true;
      let date_time_epoc =
        this.dropdown_customer_vmodel.customer_doc_number + "-" + Date.now();
      let post = {
        customer_nro_ctacte: date_time_epoc,
        customer_doc_number: this.dropdown_customer_vmodel.customer_doc_number,
        customer_ctacte_id: "",
      };
      axios
        .post(`${this.controller}/runPostFunction/create_ccte/`, post)
        .then((response) => {
          if (response.data.status == "Success") {
            this.is_status = "#57AEB1";
            this.is_icon = "done";
            this.is_message = "Cuenta corriente creada con exito.";
            this.snackbar = true;
            this.ccte_loading = false;
            this.ccte_creada = true;
            this.getDropdownCustomers();
          }
        });
    },

    updateCustomerInfo() {
      this.loading_update_user = true;
      let post = { data: this.dropdown_customer_vmodel };
      axios
        .post(`${this.controller}/runPostFunction/updateCustomerInfo/`, post)
        .then((response) => {
          if (response.data.status == "Success") {
            this.firstTimeOpen = false;
            this.dialogCustomer = false;
            this.enableCustomerInput = false;
            this.loading_update_user = false;
            this.getDropdownCustomers();
          }
        });
    },

    updateCcte() {
      let post = {
        customer_ctacte_id: this.dropdown_customer_vmodel.customer_ctacte_id,
        metododepago_cc: this.metododepago_cc,
      };
      axios.post(`${this.controller}/runPostFunction/updateCcte/`, post);
    },

    check_user_selected() {
      if (this.dropdown_customer_vmodel !== null) {
        if (this.dropdown_customer_vmodel.customerCtacteStatus != "activa") {
          let objIndex = this.metodosdepago.findIndex(
            (obj) => obj.value === "cuentacorriente"
          );
          this.metodosdepago[objIndex].disabled = true;
        }
      } else {
        let objIndex = this.metodosdepago.findIndex(
          (obj) => obj.value === "cuentacorriente"
        );
        this.metodosdepago[objIndex].disabled = false;
      }
      this.restaurar_saldo_used = false;
    },

    check_ccte_existence() {
      if (this.dropdown_customer_vmodel !== null) {
        if (this.dropdownCtaCteVmodel.customerCtacteStatus == "activa") {
          let objIndex = this.metodosdepago.findIndex(
            (obj) => obj.value === "cuentacorriente"
          );
          this.metodosdepago[objIndex].disabled = false;
        }
      } else {
        let objIndex = this.metodosdepago.findIndex(
          (obj) => obj.value === "cuentacorriente"
        );
        this.metodosdepago[objIndex].disabled = true;
      }
    },

    clear_user() {
      this.dropdown_customer_vmodel = this.dropdown_customers[0];
      this.dropdownCtaCteVmodel = null;
    },

    open_dialog_customer(status) {
      this.dialogCustomer = true;
      if (this.dropdown_customer_vmodel.birthday === "0000-00-00") {
        this.dropdown_customer_vmodel.birthday = null;
      }
      if (status === "new_user") {
        this.enableCustomerInput = true;
        this.new_user = true;
        this.dropdown_customer_vmodel = {
          customer_id: "0",
          state_id: "1",
          city_id: "16353",
          customer_doc_id: "96",
          customer_doc_number: "0",
          iva_condition_id: "5",
          customer_ctacte_id: 0,
        };
      } else {
        this.new_user = false;
      }
      this.getDropdownIvaCondition();
      this.getDropdownTipoDocumento();
      this.getDropdownStates();
      this.getDropdownCities();
      this.getSellers();
      this.getVisitDays();
    },

    closeCustomerDialog() {
      this.dialogCustomer = false;
      this.enableCustomerInput = false;
      this.new_user = false;
      this.clear_user();
    },

    // Filtro para el dropdown que limita la busqueda por nombre y codigo de barra de producto.
    customFilter(item, queryText) {
      const searchText = queryText.toLowerCase();
      const fields = [
        item.customer_name,
        item.customer_doc_number,
        item.customer_email,
      ];
      return fields.some(
        (f) => f != null && f.toLowerCase().includes(searchText)
      );
    },
  },
};
