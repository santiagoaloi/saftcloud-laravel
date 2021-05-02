import axios from "axios";

const moderation = {
  state: {
    publicProfile: [],
    publicPortfolio: [],
    moderating: false,
  },

  actions: {
    loadPublicPortfolio({ commit }, { post }) {
      console.log(post);

      axios
        .post("user/loadPublicPortfolio/" + post.id)

        .then((response) => {
          if (response.data.status == "success") {
            // alert('success')

            const payload = response.data.data;

            if (payload.operations != "") {
              payload.operations = JSON.parse(payload.operations);
            }

            if (payload.materials != "") {
              payload.materials = JSON.parse(payload.materials);
            }

            if (payload.images != "") {
              payload.images = JSON.parse(payload.images);
            }

            if (payload.profileImage != "") {
              payload.profileImage = JSON.parse(payload.profileImage);
            }

            commit("SET_publicPortfolio", payload);
          }
        });
    },

    loadPublicProfile({ commit }, { post }) {
      const data = { email: post.email };

      axios.post("user/loadPublicProfile/", data).then((response) => {
        if (response.data.status == "success") {
          commit("SET_publicProfile", response.data.data);
        }
      });
    },

    clearPublicData({ commit }) {
      commit("SET_clearPublicData");
    },

    enableModeration({ commit }) {
      commit("SET_enableModeration");
    },

    disableModeration({ commit }) {
      commit("SET_disableModeration");
    },
  },

  mutations: {
    SET_publicProfile(state, data) {
      state.publicProfile = data;
    },

    SET_clearPublicData(state) {
      state.publicProfile = {};
      state.publicPortfolio = {};
      state.moderating = false;
    },

    SET_publicPortfolio(state, data) {
      state.publicPortfolio = data;
    },

    SET_enableModeration(state) {
      state.moderating = true;
    },

    SET_disableModeration(state) {
      state.moderating = false;
    },
  },
};

export default moderation;
