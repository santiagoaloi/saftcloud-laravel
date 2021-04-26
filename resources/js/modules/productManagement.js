import axios from "axios";

const productManagement = {
  state: {
    products: [],
    quickSale: [],
  },

  actions: {
    resetPasswordVuex({ dispatch }, { encrypted }) {
      const post = { credentials: encrypted };
      return axios.post("user/resetPassword", post).then((response) => {
        if (response.data.status == "success") {
          return "success";
        }
      });
    },

    updateProfile({ commit }, { post }) {
      commit("SET_profile", post);
    },
  },

  mutations: {
    SET_products(state, data) {
      state.products = data;
    },
  },

  getters: {
    GET_products: (state) => {
      return state.products;
    },
  },
};

export default productManagement;
