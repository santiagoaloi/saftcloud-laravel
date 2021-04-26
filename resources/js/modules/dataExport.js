const dataExport = {
  state: {
    exportRows: [],
    exportHeaders: [],
    exportSelectedHeaders: {},
  },

  actions: {},

  mutations: {
    SET_EXPORT_ROWS(state, data) {
      state.exportRows = data;
    },
    SET_EXPORT_HEADERS(state, data) {
      state.exportHeaders = data;
    },
    SET_EXPORT_SELECTED_HEADERS(state, data) {
      state.exportSelectedHeaders = data;
    },
  },

  getters: {
    GET_EXPORT_ROWS: (state) => {
      return state.exportRows;
    },
    GET_EXPORT_HEADERS: (state) => {
      return state.exportHeaders;
    },
  },
};

export default dataExport;
