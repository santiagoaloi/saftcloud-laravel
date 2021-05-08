import axios from "axios";

const globalConfig = {
  state: {
    settings: [],
  },

  actions: {
    loadGlobalConfig({ commit }) {
      console.log();
      axios.get("site/GetGlobalConfig").the((response) => {
        commit("SET_globalConfig", response.data.data);
      });
    },
  },

  mutations: {
    SET_globalConfig(state, data) {
      state.settings = data;
    },
  },
};

export default globalConfig;
