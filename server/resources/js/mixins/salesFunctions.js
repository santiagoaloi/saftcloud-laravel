import axios from "axios";
// import LongPress from "vue-directive-long-press";

export default {
  created() {
    this.headers = Object.values(this.headersMap);
    this.selectedHeaders = this.headers;

    // Add barcode scan listener and pass the callback function
    this.$barcodeScanner.init(this.onBarcodeScanned);
  },

  destroyed() {
    // Remove listener when component is destroyed
    this.$barcodeScanner.destroy();
  },

  mounted() {
    sessionStorage.setItem("type", this.controller);
    this.comprobanteTipo = sessionStorage.getItem("comprobanteTipo");

    /// NEW PRICE LIST PROTOTIPE
    this.getPricesRules();
    this.callApi();
    this.$watch(
      () => {
        return this.$refs.refDropDownRounded.isMenuActive;
      },
      (val) => {
        this.removeRoundedProp = !this.removeRoundedProp;
      }
    );
  },

  updated() {
    if (this.dialogCheckout) {
      this.color_saldo_ccte();
    }
    this.itemSelected = "";

    if (this.salesOrderRows.length === 0) {
      this.hideheaders = true;
      this.hideactions = true;
    } else {
      this.hideheaders = false;
      this.hideactions = false;
    }
  },

  // directives: {
  //   "long-press": LongPress,
  // },

  watch: {
    dropdown_customers: {
      immediate: false,
      handler(newVal, oldVal) {
        let oldLength = oldVal.length;
        let newLength = newVal.length;
        if (oldLength != newLength && this.firstTimeOpen) {
          this.dropdown_customer_vmodel = Object.assign(
            {},
            this.dropdown_customers[this.dropdown_customers.length - 1]
          );
        }
      },
    },

    // gives focus to a field when value changes.
    dialogCheckout(val) {
      if (!val) return;
      requestAnimationFrame(() => {
        this.$refs.mpago_efectivo.$el.focus();
      });
    },
  },

  computed: {
    showHeaders() {
      return this.headers.filter((s) => this.selectedHeaders.includes(s));
    },

    cambionegativo: function () {
      let status = true;
      let consult = this.cambio;
      if (this.cambio < 0) {
        status = true;
      } else {
        status = false;
      }
      return status;
    },

    subTotalPrice: function () {
      let sum = 0;
      let result = this.salesOrderRows.reduce(
        (sum, item) => sum + +item.price * +item.qty,
        0
      );
      let total = +result;
      return total;
    },

    total_unidades: function () {
      let sum = 0;
      return this.salesOrderRows.reduce((sum, item) => sum + +item.qty, 0);
    },

    ccard_total: function () {
      return +this.metododepago_tc * this.dropdown_ccard_value.ccard_value;
    },

    ccard_interes: function () {
      return +this.ccard_total - this.metododepago_tc;
    },

    ccard_interes_baseImp: function () {
      return +this.ccard_interes / 1.21;
    },

    ccard_interes_iva: function () {
      return +this.ccard_interes - this.ccard_interes_baseImp;
    },

    pagototal: function () {
      return (
        +this.metododepago_efectivo +
        this.metododepago_td +
        this.metododepago_tc +
        this.metododepago_cc +
        this.ccard_interes
      );
    },

    totalprice: function () {
      return +this.subTotalPrice + this.ccard_interes;
    },

    cambio: function () {
      return +this.pagototal - this.totalprice;
    },
  },

  methods: {
    selectItems(item) {
      let result = this.selected.filter(
        (p) => p.transaction_id === item.transaction_id
      );
      if (result.length === 0) {
        this.selected.push(item);
      } else {
        this.selected.splice(item.transaction_id.index, 1);
      }
    },

    getSelected(item) {
      if (this.selected.includes(item.transaction_id)) {
        return "v-data-table__selected";
      }
    },

    unFocus() {
      requestAnimationFrame(() => {
        document.getElementById("focusOut").focus();
      });
    },

    // Create callback function to receive barcode when the scanner is already done
    onBarcodeScanned(barcode) {
      this.unFocus();
      axios
        .get(this.controller + "/" + "onBarcodeScanned" + "/" + barcode)
        .then((response) => {
          if (response.data.status === "Success") {
            this.itemSelected = response.data.rows;
            if (response.data.rows.incremental_type == 4) {
              this.productoPesable = response.data.qty;
            }
            this.product_exists();
          } else {
            this.$swal({
              title: "Producto inexistente",
              text:
                "El producto con el codigo " +
                response.data.barcode +
                " no existe.",
              type: "warning",
              confirmButtonText: "Continuar",
              confirmButtonColor: "#e57373",
            });
          }
        });
    },

    refresh_sales_order_temp() {
      this.loading = true;
      let post = {
        itemsTable: this.itemsTable,
        temporalTransactionId: this.temporalTransactionId,
      };
      axios
        .post(
          `${this.controller}/runPostFunction/refresh_sales_order_temp/`,
          post
        )
        .then((response) => {
          if (response.data.status == "Success") {
            this.salesOrderRows = response.data.rows;
            this.loading = false;
          }
        });
    },

    /// //////////////////////////////////////////////////////////////////////////////////////////////
    /// ////////// ******** FUNCINOES PARA INSERTAR UN PRODUCTO NUEVO EN EL CARRITO ********* ////////
    /// //////////////////////////////////////////////////////////////////////////////////////////////

    product_exists() {
      let result = this.salesOrderRows.filter(
        (p) => p.product_id === this.itemSelected.product_id
      );
      if (result.length === 0) {
        this.push_new_product();
        if (this.$vuetify.breakpoint.smAndDown) {
          this.dropDownProductsKey++;
        }
      } else {
        let CartRows = this.salesOrderRows;
        for (let i = 0, length = CartRows.length; i < length; i++) {
          if (CartRows[i].product_id === this.itemSelected.product_id) {
            CartRows[i].qty = +CartRows[i].qty + +this.qty;
            let post = {
              itemsTable: this.itemsTable,
              transaction_id: this.temporalTransactionId,
              product_id: CartRows[i].product_id,
              first_time_added: 0,
              price: CartRows[i].price,
              qty: CartRows[i].qty,
            };
            axios
              .post(
                `${this.controller}/runPostFunction/insertUpdateProduct/`,
                post
              )
              .then((response) => {
                if (response.data.status === "Success") {
                  if (this.$vuetify.breakpoint.smAndDown) {
                    this.dropDownProductsKey++;
                  }
                }
              });
          }
        }
      }
    },

    push_new_product() {
      this.itemSelected.cashier = this.profile.uid;
      let last_transaction_id;
      if (this.salesOrderRows.length === 0) {
        last_transaction_id = 1;
      } else {
        last_transaction_id = +this.salesOrderRows[0].transaction_id + 1;
      }
      let qty = "";
      if (this.itemSelected.incremental_type == 4) {
        qty = this.productoPesable;
      } else {
        qty = 1;
      }
      let post = {
        itemsTable: this.itemsTable,
        transaction_id: this.temporalTransactionId,
        first_time_added: 1,
        product_id: this.itemSelected.product_id,
        cashier: this.profile.uid,
        cost_net: this.itemSelected.cost_net,
        cost_untaxed: this.itemSelected.cost_untaxed,
        price: this.itemSelected.price,
        qty: qty,
        id_iva: this.itemSelected.id_iva,
        can_have_promotion: this.itemSelected.can_have_promotion,
        incremental_type: this.itemSelected.incremental_type,
        has_discount: 0,
        is_discount: 0,
        discount_id: "",
        products_prices_rules_id: "",
        original_amount: this.itemSelected.price,
      };
      let postFrontend = {
        can_have_promotion: this.itemSelected.can_have_promotion,
        cashier: this.profile.uid,
        cost_net: this.itemSelected.cost_net,
        cost_untaxed: this.itemSelected.cost_untaxed,
        discount_id: "",
        has_discount: 0,
        id_iva: this.itemSelected.id_iva,
        incremental_type: this.itemSelected.incremental_type,
        transaction_id: this.temporalTransactionId,
        is_discount: 0,
        original_amount: this.itemSelected.price,
        price: this.itemSelected.price,
        product_brand: this.itemSelected.product_brand,
        product_id: this.itemSelected.product_id,
        product_name: this.itemSelected.product_name,
        products_prices_rules_id: "",
        qty: qty,
        qty_o: 0,
        quantity: this.itemSelected.quantity,
        tax_value: this.itemSelected.tax_value,
        transaction_id: last_transaction_id,
        unimed_name_abr: this.itemSelected.unimed_name_abr,
      };
      this.salesOrderRows.unshift({ ...postFrontend });
      axios
        .post(`${this.controller}/runPostFunction/insertUpdateProduct/`, post)
        .then((response) => {
          if (response.data.status === "Success") {
            // this.salesOrderRows = response.data.rows
          } else {
            this.$swal({
              title: "Producto inexistente",
              text:
                "El producto con el codigo " +
                response.data.barcode +
                " no existe.",
              type: "warning",
              confirmButtonText: "Continuar",
              confirmButtonColor: "#e57373",
            });
          }
        });
    },

    // A DEFINIR - POR AHORA OBSOLETA
    customFunctionAdd() {
      let last_transaction_id = "";
      if (this.salesOrderRows.length === 0) {
        last_transaction_id = "";
      } else {
        last_transaction_id = +this.salesOrderRows[0].transaction_id + 1;
      }
      let temp_product = {
        product_id: moment().format("hhmmssSSSS"),
        transaction_id: +last_transaction_id,
      };
      this.salesOrderRows.push(temp_product);
      let post = {
        itemsTable: this.itemsTable,
        transaction_id: this.temporalTransactionId,
        first_time_added: 1,
        product_id: temp_product.product_id,
        ids: temp_product.transaction_id,
        key: this.primaryIndex,
        cashier: this.profile.uid,
        cost_net: 0,
        qty: 1,
        quantity: 1,
        unimed_id: 7,
        price: 0,
        id_iva: 5,
        impneto: 0,
        incremental_type: 2,
        can_have_promotion: 0,
        is_discount: 0,
        discount_id: "",
        products_prices_rules_id: "",
        original_amount: 0,
      };
      axios
        .post(`${this.controller}/runPostFunction/insertUpdateProduct/`, post)
        .then((response) => {
          if (response.data.status === "Success") {
            this.salesOrderRows = response.data.rows;
          }
        });
    },

    /// ////////////////////////////////////////////////////////////////////////////////////////////////////
    /// ////////// ******** FIN FUNCIONES PARA INSERTAR UN PRODUCTO NUEVO EN EL CARRITO ****** ////////////
    /// //////////////////////////////////////////////////////////////////////////////////////////////////

    /// ////////////////////////////////////////////////////////////////////////////////////////////////////
    /// /////////// ******* COMIENZO FUNCIONES PARA MODIFICAR PRECIO Y CANTIDADES ********* ///////////////
    /// //////////////////////////////////////////////////////////////////////////////////////////////////

    // agrega unidades a un item manualmente
    modifyAmount(item) {
      let post = {
        itemsTable: this.itemsTable,
        transaction_id: this.temporalTransactionId,
        product_id: item.product_id,
        first_time_added: 0,
        price: item.price,
        qty: item.qty,
      };
      axios.post(
        `${this.controller}/runPostFunction/insertUpdateProduct/`,
        post
      );
    },

    modifyWeight(item) {
      let post = {
        itemsTable: this.itemsTable,
        transaction_id: this.temporalTransactionId,
        product_id: item.product_id,
        first_time_added: 0,
        price: item.price,
        qty: item.qty,
      };
      axios.post(
        `${this.controller}/runPostFunction/insertUpdateProduct/`,
        post
      );
    },

    modifyDynamicPrice(item) {
      let post = {
        itemsTable: this.itemsTable,
        transaction_id: this.temporalTransactionId,
        product_id: item.product_id,
        first_time_added: 0,
        price: item.price,
        qty: item.qty,
      };
      axios.post(
        `${this.controller}/runPostFunction/insertUpdateProduct/`,
        post
      );
    },

    increaseAmount(item) {
      let post = {
        itemsTable: this.itemsTable,
        transaction_id: this.temporalTransactionId,
        product_id: item.product_id,
        first_time_added: 0,
        price: item.price,
        qty: item.qty,
      };
      axios.post(
        `${this.controller}/runPostFunction/insertUpdateProduct/`,
        post
      );
    },

    increaseWeight(item) {
      let post = {
        itemsTable: this.itemsTable,
        transaction_id: this.temporalTransactionId,
        product_id: item.product_id,
        first_time_added: 0,
        price: item.price,
        qty: item.qty,
      };
      axios.post(
        `${this.controller}/runPostFunction/insertUpdateProduct/`,
        post
      );
    },

    // reduce unidades a un item
    decreaseAmount(item) {
      let post = {
        itemsTable: this.itemsTable,
        transaction_id: this.temporalTransactionId,
        product_id: item.product_id,
        first_time_added: 0,
        price: item.price,
        qty: item.qty,
      };
      axios.post(
        `${this.controller}/runPostFunction/insertUpdateProduct/`,
        post
      );
    },

    // reduce peso a un item
    decreaseWeight(item) {
      let post = {
        itemsTable: this.itemsTable,
        transaction_id: this.temporalTransactionId,
        product_id: item.product_id,
        first_time_added: 0,
        price: item.price,
        qty: item.qty,
      };
      axios.post(
        `${this.controller}/runPostFunction/insertUpdateProduct/`,
        post
      );
    },

    decreaseA(item) {
      if (item.qty > 1) {
        item.qty--;
        if (!this.interval) {
          this.interval = setInterval(() => item.qty--, 300);
        }
      }
    },

    increaseA(item) {
      if (item.qty < 999.999) {
        item.qty++;
        if (!this.interval) {
          this.interval = setInterval(() => item.qty++, 300);
        }
      }
    },

    decreaseW(item) {
      if (item.qty > 0.1) {
        item.qty = +item.qty - 0.1;
        if (!this.interval) {
          this.interval = setInterval(() => (item.qty = +item.qty - 0.1), 300);
        }
      }
    },

    increaseW(item) {
      if (item.qty < 999.999) {
        item.qty = +item.qty + 0.1;
        if (!this.interval) {
          this.interval = setInterval(() => (item.qty = +item.qty + 0.1), 300);
        }
      }
    },

    stopHold() {
      clearInterval(this.interval);
      this.interval = false;
    },

    /// ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /// //////////////// ******* FIN FUNCIONES PARA MODIFICAR PRECIO Y CANTIDADES ********* //////////////////
    /// /////////////////////////////////////////////////////////////////////////////////////////////////////

    /// ////////////////////////////////////////////////////////////////////////////////////////////////////
    /// /////////////////////// ******* COMIENZO PROCESO DESCUENTO ********* //////////////////////////////
    /// //////////////////////////////////////////////////////////////////////////////////////////////////

    customFunctionDesc(item, mode) {
      this.rowItem = item;
      this.dialogDescuent = true;
      var result = this.salesOrderRows.filter(
        (product) => product.discount_id === item.product_id
      );
      if (result.length === 0) {
        this.discountProduct = Object.assign({}, item);
      } else {
        this.discountProduct = Object.assign({}, result[0]);
      }

      if (mode === "edit") {
        this.isEditDiscount = true;
        this.discountProduct.price = this.rowItem.price * this.rowItem.qty;
        this.calculateDesc();
        this.discountProduct.first_time_added = 0;
      } else {
        this.discountProduct.price = item.price * item.qty;

        this.discountProduct.discount_id = item.product_id;

        let last_transaction_id = +this.salesOrderRows[0].transaction_id + 1;
        this.discountProduct.first_time_added = 1;
        this.discountProduct.original_amount = item.price;
      }
    },

    calculateDesc() {
      var found = this.dropdownPricesPromotion.filter(
        (discount) => discount.groupID === this.currentDiscount
      );
      if (found.length > 0) {
        this.productDiscount =
          -this.discountProduct.price +
          +this.discountProduct.price * +found[0].multiplicator;
        return this.productDiscount;
      }
    },

    insertDesc() {
      this.discountProduct.price = this.productDiscount;
      let last_transaction_id = "";
      if (this.salesOrderRows.length === 0) {
        last_transaction_id = "";
      } else {
        last_transaction_id = +this.salesOrderRows[0].transaction_id + 1;
      }
      let post = {
        itemsTable: this.itemsTable,
        sales_transaction_id: this.temporalTransactionId,
        first_time_added: this.discountProduct.first_time_added,
        product_id: this.discountProduct.product_id,
        transaction_id: this.discountProduct.transaction_id,
        cashier: this.profile.uid,
        cost_net: 0,
        cost_untaxed: 0,
        price: this.discountProduct.price,
        qty: 1,
        id_iva: this.discountProduct.id_iva,
        can_have_promotion: 0,
        incremental_type: this.discountProduct.incremental_type,
        has_discount: 0,
        is_discount: 1,
        discount_id: this.discountProduct.discount_id,
        products_prices_rules_id: this.discountProduct.products_prices_rules_id,
        original_amount: this.discountProduct.original_amount,
      };
      let postFrontend = {
        can_have_promotion: 0,
        cashier: this.profile.uid,
        cost_net: 0,
        cost_untaxed: 0,
        discount_id: "",
        has_discount: 0,
        id_iva: this.discountProduct.id_iva,
        incremental_type: this.discountProduct.incremental_type,
        transaction_id: this.temporalTransactionId,
        is_discount: 1,
        original_amount: this.discountProduct.original_amount,
        price: this.discountProduct.price,
        product_brand: this.discountProduct.product_brand,
        product_id: this.discountProduct.product_id,
        product_name: this.discountProduct.product_name,
        products_prices_rules_id: "",
        qty: 1,
        quantity: this.discountProduct.quantity,
        tax_value: this.discountProduct.tax_value,
        transaction_id: last_transaction_id,
        unimed_name_abr: this.discountProduct.unimed_name_abr,
      };
      this.salesOrderRows.unshift({ ...postFrontend });
      axios
        .post(`${this.controller}/runPostFunction/insertDiscount/`, post)
        .then((response) => {
          if (response.data.status === "Success") {
            this.discountProduct = {};
            this.productDiscount = 0;
            this.currentDiscount = "";
            this.dialogDescuent = false;
            this.rowItem = {};
            this.salesOrderRows = response.data.rows;
          }
        });
    },

    deleteDesc(item) {
      this.refresh_sales_order_temp();
      item.loading = "1";
      let post = {
        itemsTable: this.itemsTable,
        sales_transaction_id: this.temporalTransactionId,
        transaction_id: item.transaction_id,
        discount_id: item.discount_id,
      };
      axios
        .post(`${this.controller}/runPostFunction/deleteDesc/`, post)
        .then((response) => {
          this.refresh_sales_order_temp();
          item.loading = "0";
        });
    },

    deleteItem(item) {
      this.refresh_sales_order_temp();
      var result = this.salesOrderRows.filter(
        (product) => product.discount_id === item.product_id
      );
      if (result.length > 0) {
        this.discountProduct = Object.assign({}, result[0]);
        this.deleteDesc(this.discountProduct);
      }
      item.loading = "1";
      let post = {
        itemsTable: this.itemsTable,
        transaction_id: this.temporalTransactionId,
        product_id: item.product_id,
        qty_o: item.qty_o,
      };
      axios
        .post(`${this.controller}/runPostFunction/deleteItem/`, post)
        .then((response) => {
          this.refresh_sales_order_temp();
          item.loading = "0";
        });
    },

    /// ////////////////////////////////////////////////////////////////////////////////////////////////////
    /// ///////////////////////// ******* FIN PROCESO DESCUENTO ********* /////////////////////////////////
    /// //////////////////////////////////////////////////////////////////////////////////////////////////

    /// ///////////////////////////////////////////////////////////////////////////////////////////////////
    /// /////// ******** COMIENZO DE FUNCIONES PARA OBTENER OBJETOS DE LAS TABLAS ********* //////////////
    /// /////////////////////////////////////////////////////////////////////////////////////////////////

    getPricesRules() {
      axios
        .get(`${this.controller}/runGetFunction/getPricesRules/`)
        .then((response) => {
          if (response.data.status === "Success") {
            this.dropdownPricesPromotion = response.data.data;
          }
        });
    },

    getPaymentOptions() {
      axios
        .get(`${this.controller}/runGetFunction/getPaymentOptions/`)
        .then((response) => {
          if (response.data.status === "Success") {
            this.metodosdepago = response.data.rows;
          }
        });
    },

    getDropdownCcardInteres() {
      axios
        .get(`${this.controller}/runGetFunction/getDropdownCcardInteres/`)
        .then((response) => {
          if (response.data.status === "Success") {
            this.dropdown_ccard = response.data.rows;
          }
        });
    },

    getDropdownProducts() {
      axios
        .get(`${this.controller}/runGetFunction/getDropdownProducts/`)
        .then((response) => {
          if (response.data.status === "Success") {
            this.dropdownProducts = response.data.rows;
          }
        });
    },

    getDropdownTipoComprobante() {
      axios
        .get(`${this.controller}/runGetFunction/getDropdownTipoComprobante/`)
        .then((response) => {
          if (response.data.status === "Success") {
            this.dropdownFactura = response.data.rows;
          }
        });
    },

    getDropdownIvaCondition() {
      axios
        .get(`${this.controller}/runGetFunction/getDropdownIvaCondition/`)
        .then((response) => {
          if (response.data.status === "Success") {
            this.dropdownIvaCondition = response.data.rows;
          }
        });
    },

    getDropdownTipoDocumento() {
      axios
        .get(`${this.controller}/runGetFunction/getDropdownTipoDocumento/`)
        .then((response) => {
          if (response.data.status === "Success") {
            this.dropdownTipoDocumento = response.data.rows;
          }
        });
    },

    getDropdownStates() {
      axios
        .get(`${this.controller}/runGetFunction/getDropdownStates/`)
        .then((response) => {
          if (response.data.status === "Success") {
            this.dropdownStates = response.data.rows;
          }
        });
    },

    getDropdownCities() {
      axios
        .get(`${this.controller}/runGetFunction/getDropdownCities/`)
        .then((response) => {
          if (response.data.status == "Success") {
            this.dropdownCities = response.data.rows;
          }
        });
    },

    getVisitDays() {
      axios
        .get(`${this.controller}/runGetFunction/getVisitDays/`)
        .then((response) => {
          if (response.data.status == "Success") {
            this.dropdownVisitDays = response.data.rows;
          }
        });
    },

    /// //////////////////////////////////////////////////////////////////////////////////////////////
    /// //////************* COMIENZO PROCESO DE COBRO ******************** //////////////////////////
    /// ////////////////////////////////////////////////////////////////////////////////////////////
    process_sale() {
      this.loading_pagar = true;
      if (this.dropdown_customer_vmodel.customer_id == null) {
        this.validation_errors = true;
        this.validation_message = "Seleccione un cliente.";
        this.loading_pagar = false;
      } else if (this.controller == "budgets") {
        this.salesProcess();
      } else if (this.mpago.length < 1) {
        this.validation_errors = true;
        this.validation_message = "Seleccione un metodo de pago.";
        this.loading_pagar = false;
      } else {
        if (this.checkbox_fe) {
          if (+this.pagototal < this.totalprice) {
            this.validation_errors = true;
            let restoPositivo = Math.abs(this.cambio);
            this.validation_message =
              "El pago efectuado es insuficiente, restan $" +
              restoPositivo.toFixed(2) +
              " pesos.";
            this.loading_pagar = false;
          } else if (
            this.totalprice >= 15000 &&
            this.dropdown_customer_vmodel.customer_doc_id == "99"
          ) {
            this.validation_errors = true;
            this.validation_message =
              "Para montos mayores a $15.000, es obligatorio usar una cuenta de cliente.";
            this.assign_customer_button = true;
            this.loading_pagar = false;
          } else if (this.dropdownCtaCteVmodel !== null) {
            if (
              this.saldo_original + this.metododepago_cc >
              +this.dropdownCtaCteVmodel.credit_limit
            ) {
              this.validation_errors = true;
              this.validation_message =
                "El pago con cuenta corriente excede  el limite permitido de " +
                this.dropdownCtaCteVmodel.credit_limit +
                " pesos.";
              this.loading_pagar = false;
            } else {
              this.salesProcess();
            }
          } else {
            this.salesProcess();
          }
        } else {
          if (this.cambio < 0) {
            this.validation_errors = true;
            let restoPositivo = Math.abs(this.cambio);
            this.validation_message =
              "El pago efectuado es insuficiente, restan " +
              restoPositivo +
              " pesos.";
            this.loading_pagar = false;
          } else if (
            this.totalprice >= 15000 &&
            this.dropdown_customer_vmodel.customer_doc_id === 99
          ) {
            this.validation_errors = true;
            this.validation_message =
              "Para montos mayores a $15.000, es obligatorio usar una cuenta de cliente.";
            this.assign_customer_button = true;
            this.loading_pagar = false;
          } else if (this.dropdownCtaCteVmodel !== null) {
            if (
              -(
                +this.dropdownCtaCteVmodel.customer_ctacte_saldo -
                +this.metododepago_cc
              ) > +this.dropdownCtaCteVmodel.credit_limit
            ) {
              this.validation_errors = true;
              this.validation_message =
                "El pago con cuenta corriente excede  el limite permitido de " +
                this.dropdownCtaCteVmodel.credit_limit +
                " pesos.";
              this.loading_pagar = false;
            } else {
              this.salesProcess();
            }
          } else {
            this.salesProcess();
          }
        }
      }
    },

    getAfipNextNroComp() {
      let post = {
        company: this.GET_DEFAULT_COMPANY,
      };
      axios
        .post(`${this.controller}/runPostFunction/getAfipNextNroComp/`, post)
        .then((response) => {
          if (response.data.status == "Success") {
            this.last_nrofe = response.data.last_nrofe;
          }
        });
    },

    // 3 -
    salesProcess() {
      let post = {
        invoiceData: {
          cashier: this.profile.uid,
          seller: this.profile.uid,
          customer_id: this.dropdown_customer_vmodel.customer_id,
          impneto: this.BaseImp_total,
          impiva: this.Importe_total_iva,
          totalprice: this.totalprice,
          metododepago_efectivo: +this.metododepago_efectivo,
          metododepago_td: +this.metododepago_td,
          metododepago_tc: +this.metododepago_tc + +this.ccard_interes,
          metododepago_cc: +this.metododepago_cc,
          tipocbte: this.dropdownFacturaVmodel.tipocbte,
          detail: this.detail,
          publicComment: this.publicComment,
          privateComment: this.privateComment,
          cuotas: this.dropdown_ccard_value.ccard_name,
          customer_doc_number: this.dropdown_customer_vmodel
            .customer_doc_number,
          customer_doc_id: this.dropdown_customer_vmodel.customer_doc_id,
          array_iva: this.AlicIva,
        },
        globalConfig: this.settings,
        company: this.GET_DEFAULT_COMPANY,
        transaction_id: this.temporalTransactionId,
        tipoProceso: sessionStorage.getItem("type"),
      };
      axios
        .post(`${this.controller}/runPostFunction/salesProcess/`, post)
        .then((response) => {
          if (response.data.status === "Success") {
            this.generatedTransactionId = response.data.transaction_id;
            this.SalesOrder();
          } else {
            this.$swal({
              title: "No se pudo facturar",
              text: "El documento no pudo ser procesado.",
              confirmButtonText: "Intentar nuevamente",
              confirmButtonColor: "grey",
              backdrop: "rgba(108, 122, 137, 0.8)",
              animation: false,
              icon: "error",
              width: 500,
            });
            this.loading_pagar = false;
          }
        });
    },

    // 4 -
    SalesOrder() {
      let post = {
        salesOrderRows: this.salesOrderRows,
        sales_transaction_id: this.generatedTransactionId,
        tipoProceso: sessionStorage.getItem("type"),
      };
      axios
        .post(`${this.controller}/runPostFunction/salesOrder/`, post)
        .then((response) => {
          if (response.data.status === "Success") {
            if (this.metododepago_cc > 0) {
              this.updateCcte();
            }
            this.inputCashReg();
          } else {
            this.$swal({
              title: "Error",
              text: `Se facturo pero hubo un error en el proceso `,
              confirmButtonText: "Reportar error",
              confirmButtonColor: "grey",
              backdrop: "rgba(108, 122, 137, 0.8)",
              animation: false,
              icon: "error",
              width: 500,
            });
          }
        });
    },

    inputCashReg() {
      let post = {
        cashier: this.profile.uid,
        metododepago_cc: this.metododepago_cc,
        metododepago_tc: this.metododepago_tc,
        metododepago_td: this.metododepago_td,
        metododepago_efectivo: this.metododepago_efectivo,
      };
      axios
        .post(`${this.controller}/runPostFunction/inputCashReg/`, post)
        .then((response) => {
          if (response.data.status === "Success") {
            if (this.controller != "budgetsdetails") {
              this.clearAllCart();
            }

            sessionStorage.removeItem("customer_vmodel");
            sessionStorage.setItem(
              "sales_transaction_id",
              this.generatedTransactionId
            );
            this.$router.push("/ventas/generatequote");
            this.loading_pagar = false;
          }
        });
    },

    /// //////////////////////////////////////////////////////////////////////////////////////////////
    /// ///////////************* FIN PROCESO DE COBRO ******************** //////////////////////////
    /// ////////////////////////////////////////////////////////////////////////////////////////////

    /// //////////////////////////////////////////////////////////////////////////////////////////////
    /// //////************* COMIENZO CALCULO DE IVA ******************** ////////////////////////////
    /// ////////////////////////////////////////////////////////////////////////////////////////////

    get_iva_totals() {
      let sum_BaseImp = _.sumBy(this.AlicIva, function (salesOrderRows) {
        return +salesOrderRows.BaseImp;
      });
      this.BaseImp_total = +sum_BaseImp + +this.ccard_interes_baseImp;

      let sum_Importe = _.sumBy(this.AlicIva, function (salesOrderRows) {
        return +salesOrderRows.Importe;
      });
      this.Importe_total_iva = +sum_Importe + +this.ccard_interes_iva;
    },

    build_iva() {
      const arr = this.salesOrderRows;
      const filtered = arr.reduce(
        (a, o) => (
          o.id_iva === "5" &&
            a.push({
              price_iva: o.price * o.qty - (o.price / 1.21) * o.qty,
              id_iva: o.id_iva,
              impneto: (o.price / 1.21) * o.qty,
            }),
          a
        ),
        []
      );

      const price_iva = filtered.reduce((sum, currentValue) => {
        return sum + +currentValue.price_iva;
      }, 0);

      const impneto = filtered.reduce((sum, currentValue) => {
        return sum + +currentValue.impneto;
      }, 0);

      const filtered_4 = arr.reduce(
        (a, o) => (
          o.id_iva === "4" &&
            a.push({
              price_iva: o.price * o.qty - (o.price / 1.105) * o.qty,
              id_iva: o.id_iva,
              impneto: (o.price / 1.105) * o.qty,
            }),
          a
        ),
        []
      );

      const price_iva_4 = filtered_4.reduce((sum, currentValue) => {
        return sum + +currentValue.price_iva;
      }, 0);

      const impneto_4 = filtered_4.reduce((sum, currentValue) => {
        return sum + +currentValue.impneto;
      }, 0);

      const filtered_3 = arr.reduce(
        (a, o) => (
          o.id_iva === "3" &&
            a.push({
              price_iva: o.price * o.qty - (o.price / 1) * o.qty,
              id_iva: o.id_iva,
              impneto: (o.price / 1) * o.qty,
            }),
          a
        ),
        []
      );

      const price_iva_3 = filtered_3.reduce((sum, currentValue) => {
        return sum + +currentValue.price_iva;
      }, 0);

      const impneto_3 = filtered_3.reduce((sum, currentValue) => {
        return sum + +currentValue.impneto;
      }, 0);

      this.AlicIva = new Array();

      if (impneto > 0) {
        this.AlicIva.push({
          Id: "5",
          BaseImp: (+impneto + +this.ccard_interes_baseImp).toFixed(2),
          Importe: (+price_iva + +this.ccard_interes_iva).toFixed(2),
        });
      } else if (impneto == 0 && this.ccard_interes > 0) {
        this.AlicIva.push({
          Id: "5",
          BaseImp: +this.ccard_interes_baseImp.toFixed(2),
          Importe: +this.ccard_interes_iva.toFixed(2),
        });
      }
      if (impneto_4 > 0) {
        this.AlicIva.push({
          Id: "4",
          BaseImp: impneto_4.toFixed(2),
          Importe: price_iva_4.toFixed(2),
        });
      }
      if (impneto_3 > 0) {
        this.AlicIva.push({
          Id: "3",
          BaseImp: impneto_3.toFixed(2),
          Importe: price_iva_3.toFixed(2),
        });
      }
    },

    /// //////////////////////////////////////////////////////////////////////////////////////////////
    /// ///////////************* FIN CALCULO DE IVA ******************** ////////////////////////////
    /// ////////////////////////////////////////////////////////////////////////////////////////////

    /// ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /// ////////// ******* COMIENZO FUNCIONES DEL dialogCheckout PARA REALIZAR EL COBRO ******** /////////////
    /// /////////////////////////////////////////////////////////////////////////////////////////////////////

    cobrar() {
      this.dialogCheckout = true;
      this.firstTimeOpen = true;
      this.getDropdownCcardInteres();
      this.build_iva();
      this.get_iva_totals();
      this.getDropdownTipoComprobante();
      this.getDropdownTipoDocumento();
    },

    focus_field(item) {
      if (item.value === "efectivo") {
        requestAnimationFrame(() => {
          this.$refs.mpago_efectivo.$el.focus();
        });
      }
      if (item.value === "tarjetadebito") {
        requestAnimationFrame(() => {
          this.$refs.mpago_td.$el.focus();
        });
      }
      if (item.value === "tarjetacredito") {
        requestAnimationFrame(() => {
          this.$refs.mpago_tc.$el.focus();
        });
      }
      if (item.value === "cuentacorriente") {
        requestAnimationFrame(() => {
          this.$refs.mpago_cc.$el.focus();
        });
      }
    },

    pay_all_button_reset(opcion_pago) {
      if (opcion_pago === "efectivo") {
        this.metododepago_efectivo = 0;
      }
      if (opcion_pago === "tarjetadebito") {
        this.metododepago_td = 0;
      }
      if (opcion_pago === "tarjetacredito") {
        this.metododepago_tc = 0;
        this.dropdown_ccard_value.ccard_value = "1.00";
      }
      if (opcion_pago === "cuentacorriente") {
        this.metododepago_cc = 0;
        this.restaurar_saldo();
      }
    },

    pay_all_current_change(opcion_pago) {
      if (opcion_pago === "efectivo") {
        this.metododepago_efectivo = Math.abs(this.cambio); // Convierte a numero positivo
      }
      if (opcion_pago === "tarjetadebito") {
        this.metododepago_td = Math.abs(this.cambio); // Convierte a numero positivo
      }
      if (opcion_pago === "tarjetacredito") {
        this.metododepago_tc = Math.abs(this.cambio); // Convierte a numero positivo
      }
      if (opcion_pago === "cuentacorriente") {
        this.metododepago_cc = Math.abs(this.cambio); // Convierte a numero positivo
        this.saldo_original = this.dropdownCtaCteVmodel.customer_ctacte_saldo;
        this.dropdownCtaCteVmodel.customer_ctacte_saldo = +(
          this.dropdownCtaCteVmodel.customer_ctacte_saldo - this.metododepago_cc
        );
      }
    },

    ocultar_opcion_pago(opcion_pago) {
      if (opcion_pago === "efectivo") {
        this.mpago.splice(this.mpago.indexOf("efectivo"), 1);
        this.metododepago_efectivo = 0;
      }
      if (opcion_pago === "tarjetadebito") {
        this.mpago.splice(this.mpago.indexOf("tarjetadebito"), 1);
        this.metododepago_td = 0;
      }
      if (opcion_pago === "tarjetacredito") {
        this.mpago.splice(this.mpago.indexOf("tarjetacredito"), 1);
        this.metododepago_tc = 0;
        this.dropdown_ccard_value.ccard_value = "1.00";
      }
      if (opcion_pago === "cuentacorriente") {
        this.mpago.splice(this.mpago.indexOf("cuentacorriente"), 1);
        this.metododepago_cc = 0;
        this.restaurar_saldo();
      }
    },

    cargar_ccte() {
      this.metododepago_cc = this.metododepago_cc - this.cambio;
      // this.cambio =  0
      this.block_payment_methods = true;
      this.mpago.push("cuentacorriente");
      // this.dropdown_customer_vmodel.customer_ctacte_saldo = this.saldo_original -  this.metododepago_cc
    },

    updateCcte() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          let post = {
            customer_ctacte_id: parseFloat(
              this.dropdown_customer_vmodel.customer_ctacte_id
            ),
            customer_ctacte_saldo: this.metododepago_cc,
          };
          axios.post(`${this.controller}/runPostFunction/updateCcte/`, post);
        }
      });
    },

    usarSaldo() {
      this.saldo_original = +this.dropdownCtaCteVmodel.customer_ctacte_saldo;
      let calcular_diferencia =
        +(+this.dropdownCtaCteVmodel.customer_ctacte_saldo) + this.cambio;
      this.metododepago_cc =
        +(+this.dropdownCtaCteVmodel.customer_ctacte_saldo) -
        calcular_diferencia;

      this.restaurar_saldo_used = true;
      this.disable_ccte_saldo = true;
      this.dropdownCtaCteVmodel.customer_ctacte_saldo =
        +(+this.dropdownCtaCteVmodel.customer_ctacte_saldo) -
        this.metododepago_cc;
      this.mpago.push("cuentacorriente");
    },

    restaurar_saldo() {
      this.dropdownCtaCteVmodel.customer_ctacte_saldo = this.saldo_original;
      this.restaurar_saldo_used = false;
      this.metododepago_cc = 0;
      this.disable_ccte_saldo = false;
    },

    color_saldo_ccte() {
      if (this.dropdownCtaCteVmodel !== null) {
        let saldo = +this.dropdownCtaCteVmodel.customer_ctacte_saldo;
        if (saldo < 0) {
          this.saldonegativo = true;
          this.saldopositivo = false;
        } else {
          this.saldopositivo = true;
          this.saldonegativo = false;
        }
      }
    },

    closeCheckout() {
      this.dialogCheckout = false;
      this.firstTimeOpen = false;
      this.reset_pagar();
    },

    closeDialogComment() {
      this.dialogComment = false;
    },

    reset_pagar() {
      this.metododepago_efectivo = 0;
      this.metododepago_td = 0;
      this.metododepago_tc = 0;
      this.metododepago_cc = 0;
      this.block_payment_methods = false;
      this.validation_errors = false;
      this.enableCustomerInput = false;
      this.restaurar_saldo_used = false;
      this.loading_pagar = false;
      this.dropdown_ccard_value.ccard_value = 1.0;
      this.checkbox_fe = false;
      this.dropdownFacturaVmodel = {
        id: "1002",
        tipocbte: "1002",
        doctipo: "P",
        descripcion: "PRESUPUESTO",
      };
      this.clear_user();
      this.mpago = ["efectivo"];
      setTimeout(() => {
        this.$refs.mpago_efectivo.$el.focus();
      }, 500);
    },

    reset_user_select() {
      this.mpago = ["efectivo"];
      this.metododepago_efectivo = 0;
      this.metododepago_td = 0;
      this.metododepago_tc = 0;
      this.metododepago_cc = 0;
      this.block_payment_methods = false;
      this.validation_errors = false;
      this.enableCustomerInput = false;
      this.restaurar_saldo_used = false;
      this.dropdown_ccard_value.ccard_value = "1.00";
      this.getDropdownCustomers();
    },

    removeOptionChips(item) {
      const index = this.mpago.indexOf(item.value);

      if (index >= 0) this.mpago.splice(index, 1);
      if (item.value === "efectivo") {
        this.metododepago_efectivo = 0;
      }
      if (item.value === "tarjetadebito") {
        this.metododepago_td = 0;
      }
      if (item.value === "tarjetacredito") {
        this.metododepago_tc = 0;
        this.dropdown_ccard_value = "1.00";
      }
      if (item.value === "cuentacorriente") {
        this.dropdownCtaCteVmodel.customer_ctacte_saldo = this.saldo_original;
        this.metododepago_cc = 0;
      }
    },

    updateDropdownFacturaVmodel() {
      this.getAfipNextNroComp();
      this.dropdownFacturaVmodel = {
        id: "4",
        tipocbte: "6",
        doctipo: "B",
        descripcion: "FACTURA B",
      };
    },
    updateDropdownFacturaVmodel2() {
      this.dropdownFacturaVmodel = {
        id: "1002",
        tipocbte: "1002",
        doctipo: "P",
        descripcion: "PRESUPUESTO",
      };
    },

    columnTable() {
      let post = {
        columnTable: this.columnTable,
      };
      axios
        .post(`${this.controller}/runPostFunction/columnTable/`, post)
        .then((response) => {
          let lala = response.data.data;
          console.log(lala);
        });
    },

    /// ///////////////////////////////////////////////////////////////////////////////////////////////////////
    /// //////////// ******* FIN FUNCIONES DEL dialogCheckout PARA REALIZAR EL COBRO ******** ////////////////
    /// /////////////////////////////////////////////////////////////////////////////////////////////////////

    // SYSTEM FUNCTIONS //////////////////////////////////////////////////////
    /// ///////////////////////////////////////////////////////////////////////
    /// ///////////////////////////////////////////////////////////////////////
    /// ///////////////////////////////////////////////////////////////////////
    /// ///////////////////////////////////////////////////////////////////////

    callApi() {
      this.APIloading = true;
      axios.get(`${this.controller}/runGetFunction/index`).then((response) => {
        if (response.data.status == "Success") {
          /* Shortcut creation data */
          this.desktop_access[0].icon = response.data.icon;
          this.desktop_access[0].title = response.data.title;
          this.desktop_access[0].path = response.data.path;
          this.desktop_access[0].controller = response.data.controller;
          this.desktop_access[0].username = this.profile.uname;

          /* Codeigniter  queries */
          this.query = response.data.query;
          this.query_table = response.data.table;
          this.component = response.data.component;

          this.desktop = response.data.desktop;
          this.access = response.data.access;
          this.pageHeader = response.data.data.title;
          this.primaryIndex = response.data.data.key;

          this.forms = response.data.data.forms;
          this.rowItem = response.data.data.models;
          this.options = response.data.data.options;

          this.detailItem = response.data.data.details;
          this.pagination = response.data.data.setting;

          this.APIloading = false;
          this.display_empty_message = true;

          this.getDropdownProducts();
          window.getApp.$emit("APP_HIDE_SPINNER");
        }
      });
    },

    dates(from, until) {
      this.dateFrom = from;
      this.dateUntil = until;
    },

    datesToday(from, until) {
      this.dateToday = from;
      this.dateUntil = until;
    },

    customFunctionPrice() {},

    dateFilter() {},

    deleteItemBulk(length) {
      this.refresh_sales_order_temp();
      this.$swal({
        title: "Quitar todos los elementos",
        text: "Seguro desea quitar estos " + length + " productos?",
        type: "warning",
        showCancelButton: true,
        showCancelButton: true,
        confirmButtonText: "Continuar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#e57373",
      }).then((result) => {
        if (result.value) {
          let post = {
            salesOrderRows: this.selected,
          };
          axios
            .post(`${this.controller}/runPostFunction/deleteItemBulk/`, post)
            .then((response) => {
              if (response.data.status === "Success") {
                this.query_delete = response.data.query;
                this.is_status = "#e57373";
                this.is_icon = "delete";
                this.is_message = length + " productos removidos.";
                this.snackbar = true;
                this.selected = [];
                this.refresh_sales_order_temp();
              }
            });
        }
      });
    },

    deleteAll(length) {
      this.$swal({
        title: "Vaciar lista de productos",
        html:
          "Estas seguro que queres vaciar esta lista? <br>" +
          "Contiene " +
          length +
          " productos.",
        type: "error",
        showCancelButton: true,
        showCancelButton: true,
        confirmButtonText: "Continuar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#e57373",
      }).then((result) => {
        if (result.value) {
          this.clearCart();
          this.is_status = "#e57373";
          this.is_icon = "delete";
          this.is_message = "Productos elminiados";
          this.snackbar = true;
        }
      });
    },

    clearCart() {
      this.refresh_sales_order_temp();
      setTimeout(() => {
        let post = {
          itemsTable: this.itemsTable,
          temporalTransactionId: this.temporalTransactionId,
          salesOrderRows: this.salesOrderRows,
        };
        axios
          .post(`${this.controller}/runPostFunction/clearCart/`, post)
          .then((response) => {
            if (response.data.status === "Success") {
              this.refresh_sales_order_temp();
            }
          });
      }, 200);
    },

    clearAllCart() {
      let post = {
        itemsTable: this.itemsTable,
        temporalTransactionId: this.temporalTransactionId,
      };
      axios.post(`${this.controller}/runPostFunction/clearCart/`, post);
    },
  },
};
