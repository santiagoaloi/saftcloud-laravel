const appData = {
  state: {
    customerId: "",
    customerInvoiceNumber: "",
  },

  actions: {},

  mutations: {
    SET_customerId(state, data) {
      state.customerId = data;
    },
    SET_customerInvoiceNumber(state, data) {
      state.customerInvoiceNumber = data;
    },
  },

  getters: {
    customerId: (state) => {
      return state.customerId;
    },
    customerInvoiceNumber: (state) => {
      return state.customerInvoiceNumber;
    },
  },
};

export default appData;
