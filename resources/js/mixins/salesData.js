export default {
  data() {
    return {
      interval: false,

      productoPesable: "",
      barcode: "",
      comprobanteTipo: "",
      dialogComment: false,
      payment_status_id: 1,
      discountItem: {},
      isEditDiscount: false,
      currentDiscount: null,
      screenHeight: 0,
      pricesPromotion: "",
      dropdownPricesPromotion: [],
      filteredRules: [],
      productRules: [],

      productDiscount: 0,
      first_time_added: "",

      last_nrofe: "",
      selectedRule: "",

      removeRoundedProp: false,
      dropDownProductsKey: 100,

      assign_customer_button: false,
      firstTimeOpen: false,

      dropdown_factura_limited: [
        { id: "4", tipocbte: "6", doctipo: "B", descripcion: "FACTURA B" },
        {
          id: "5",
          tipocbte: "7",
          doctipo: "NDB",
          descripcion: "NOTA CREDITO B",
        },
        {
          id: "6",
          tipocbte: "8",
          doctipo: "NCB",
          descripcion: "NOTA CREDITO B",
        },
        {
          id: "1002",
          tipocbte: "1002",
          doctipo: "P",
          descripcion: "PRESUPUESTO",
        },
      ],

      salesOrderRows: [],
      temporalTransactionId: "",
      generatedTransactionId: "",

      detail: "",
      publicComment: "",
      privateComment: "",

      AlicIva: [],
      BaseImp_total: 0,
      Importe_total_iva: 0,
      product_added_id: "",
      qty: 1,

      new_user: false,
      today: new Date().toISOString().slice(0, 10),
      ccte_loading: false,
      ccte_creada: false,

      cambiopositivo: true,
      saldonegativo: false,
      saldopositivo: false,

      disable_ccte_saldo: false,
      loading_update_user: false,
      saldo_original: 0,
      restaurar_saldo_used: false,
      block_payment_methods: false,

      enableCustomerInput: false,

      dialogCheckout: false,
      dialogCustomer: false,
      dialogDescuent: false,
      discountProduct: {},

      dropdown_ccard_value: {
        ccard_id: "1",
        ccard_name: "1",
        ccard_value: "1.00",
      },
      dropdown_ccard: [],
      dropdownTipoDocumento: [],
      dropdownIvaCondition: [],
      dropdownStates: [],
      dropdownCities: [],
      dropdownFactura: [],
      dropdownSellers: [],
      dropdownVisitDays: [],

      visitDayVmodel: {},
      sellersVmodel: {},

      dropdownProducts: [],

      dropdown_customers: [],
      dropdown_customer_vmodel: {},
      dropdownCtaCteVmodel: null,

      loading_pagar: false,
      checkbox_fe: false,

      mpago: ["efectivo"],
      metododepago_efectivo: 0,
      metododepago_td: 0,
      metododepago_tc: 0,
      metododepago_cc: 0,
      metodosdepago: [
        {
          value: "efectivo",
          text: "Efectivo",
          description: "Pago en efectivo",
          icon: "mdi-cash",
          disabled: false,
        },
        {
          value: "tarjetadebito",
          text: "Tarjeta de debito",
          description: "Pago por tarjeta de debito",
          icon: "mdi-credit-card-outline",
          disabled: false,
        },
        {
          value: "tarjetacredito",
          text: "Tarjeta de credito",
          description: "Pago por tarjeta de credito",
          icon: "mdi-credit-card-outline",
          disabled: false,
        },
        {
          value: "cuentacorriente",
          text: "Cuenta corriente",
          description: "Pago por cuenta corriente",
          icon: "mdi-receipt",
          disabled: true,
        },
      ],

      /* Custom Headers */
      selectedHeaders: [],

      headersMap: {
        chk: { text: "", value: "selected", sortable: false },
        product_name: {
          text: "Producto",
          value: "product_name",
          align: "left",
          sortable: false,
        },
        qty: {
          text: "Unidades",
          value: "qty",
          align: "center",
          sortable: false,
          width: "5%",
        },
        price: {
          text: "Precio",
          value: "price",
          align: "center",
          sortable: false,
        },
        amount: {
          text: "Total",
          value: "amount",
          align: "center",
          sortable: false,
        },
        actions: {
          text: "Accion",
          value: "actions",
          align: "left",
          sortable: false,
        },
      },

      headersMobile: {
        chk: { text: "", value: "selected", sortable: false },
        product_name: {
          text: "Producto",
          value: "product_name",
          sortable: false,
        },
        actions: {
          text: "Accion",
          value: "actions",
          align: "left",
          sortable: false,
        },
        qty: {
          text: "Unidades",
          value: "qty",
          align: "center",
          sortable: false,
        },
      },
      /* Finish Custom Headers */

      hideheaders: true,
      hideactions: true,
      display_empty_message: false,

      /* APPBAR */
      selected: [],
      pagination: {},
      loading: false,
      APIloading: false,
      custom_view: false,
      REFRESHloading: false,
      dateSelect: false,
      dateSelectToday: false,
      dateToday: "",
      dateFrom: "",
      dateUntil: "",
      menu: false,
      modal: false,
      search: "",
      hideIsAdd: true,
      isTableSwitchView: false,
      customButtonAdd: false,
      customButtonPrice: false,
      menu1: "",

      nodata: "uploads/images/no-products.png",
    };
  },
};
