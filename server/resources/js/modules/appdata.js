import axios from "axios";

const appData = {
  state: {
    siteInfo: [],
    appConfig: [],
    activeUserRoleMenu: 0,
    activeUserRoleId: 0,
  },

  actions: {
    loadSiteInfo({ commit }) {
      axios.get("site/loadSiteSettings").then((response) => {
        commit("SET_siteInfo", response.data.data);
      });
    },

    loadAppConfig({ commit }) {
      axios.get("site/loadAppConfig").then((response) => {
        commit("SET_appConfig", response.data.data);
      });
    },
  },

  mutations: {
    SET_activeUserRoleMenu(state, data) {
      state.activeUserRoleMenu = data;
    },

    SET_activeUserRoleId(state, data) {
      state.activeUserRoleId = data;
    },

    SET_siteInfo(state, data) {
      state.siteInfo = data;
    },

    SET_appConfig(state, data) {
      state.appConfig = data;
    },
  },

  getters: {
    activeUserRoleMenu: (state) => {
      return state.activeUserRoleMenu;
    },

    activeUserRoleId: (state) => {
      return state.activeUserRoleId;
    },
  },
};

export default appData;
