/*eslint-disable*/
import Vue from "vue";
import Vuex from "vuex";

// VUEX survive app refresh
import createPersistedState from "vuex-persistedstate";

// This is the first change of the file.

// Encrypted Localstorage
import SecureLS from "secure-ls";
// import dataExport from "@/modules/dataExport";
// import componentsState from "@/modules/componentsState";
// import appData from "@/modules/appdata";
// import customerData from "@/modules/customerdata";
// import sessionData from "@/modules/authentication";
// import publicData from "@/modules/publicProfile";
// import elements from "@/modules/elementParams";
// import productManagement from "@/modules/productManagement";

const ls = new SecureLS({ isCompression: false });

// const getBaseUrl = () => {
//   if (process.env.NODE_ENV === "development") {
//     return "https://testsajtkhvc.se/server/";
//   } else if (process.env.NODE_ENV === "local") {
//     return "http://localhost/saft425/console/server/";
//   } else if (process.env.NODE_ENV === "production") {v
//     return "https://testsajtkhvc.se/server/";
//   }
//   return "https://testsajtkhvc.se/server/";
// };

Vue.use(Vuex);
export const store = new Vuex.Store({
  state: {
    // baseUrl: getBaseUrl(),
    baseUrl: "http://localhost/saft420/console/server/",
    rooms: [],
  },

  actions: {
    changeRooms({ commit }, { rooms }) {
      console.log("rooms changed.");
      commit("SET_rooms", rooms);
    },
  },

  mutations: {
    SET_rooms(state, data) {
      state.rooms = data;
    },
  },

  // Sync localstorage with Vuex
  plugins: [
    createPersistedState({
      storage: {
        getItem: (key) => ls.get(key),
        setItem: (key, value) => ls.set(key, value),
        removeItem: (key) => ls.remove(key),
      },
      paths: [
        "appData",
        "rooms",
        "sessionData",
        "publicData",
        "componentsState",
        "elements.previewing",
        "elements.workspace",
        "elements.workspaceAlias",
        "elements.workspaceType",
      ],
    }),
  ],

  modules: {
    // dataExport,
    // componentsState,
    // appData,
    // customerData,
    // sessionData,
    // publicData,
    // elements,
    // productManagement,
  },
});
