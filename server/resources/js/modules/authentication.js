import axios from "axios";
import router from "@/router";
import moment from "moment";

const sessionData = {
  state: {
    login: [],
    userProfile: [],
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

    verifyCredentials({ dispatch }, { encrypted }) {
      const post = { credentials: encrypted };
      return axios.post("user/verifyUser", post).then((response) => {
        if (response.data.resetPassword == "1") {
          return "resetPassword";
        } else {
          if (response.data.authentication == "second_factor") {
            window.getApp.$emit("APP_SHOW_SPINNER");

            // this.secondFactor = true;
            // this.loading = false
            // console.log('second_factor')
            return true;
          }

          if (response.data.authentication == "no_second_factor") {
            window.getApp.$emit("APP_SHOW_SPINNER");

            console.log("no_second_factor");

            // this.secondFactor = false;

            const credentials = {
              credentials: encrypted,
              last_login: moment().format("LLL"),
              attempts: 0,
              second_factor_token: 0,
              new_password: "",
            };

            dispatch("loginVuex", { credentials });

            return true;
          }
        }

        if (response.data.status == "Authentication error") {
          console.log("Authentication error");

          const color = "teal accent-4";
          const icon = "mdi-account-alert-outline";
          const message = "Your account or password was incorrect.";
          window.getApp.$emit("APP_SHOW_SNACKBAR", color, icon, message);
          window.getApp.$emit("APP_END_LOADING");

          return false;
        }

        if (response.data.authentication == "inactive") {
          console.log("Inactive account error");

          const color = "teal accent-4";
          const icon = "mdi-account-alert-outline";
          const message =
            "Your account is inactive, contact support for mode details.";
          window.getApp.$emit("APP_SHOW_SNACKBAR", color, icon, message);
          window.getApp.$emit("APP_END_LOADING");

          return false;
        }

        if (response.data.status == "inexistent account") {
          console.log("Inexistent account error");

          const color = "red lighten-1";
          const icon = "mdi-account-alert-outline";
          const message = "Your account or password is incorrect.";
          window.getApp.$emit("APP_SHOW_SNACKBAR", color, icon, message);
          window.getApp.$emit("APP_END_LOADING");

          return false;
        }
      });
    },

    updateProfile({ commit }, { post }) {
      commit("SET_profile", post);
    },

    loginVuex({ commit, dispatch }, { credentials }) {
      axios.post("user/postLogin", credentials).then((response) => {
        if (response.data.status == "error") {
          // color, icon, message
          window.getApp.$emit(
            "APP_SHOW_SNACKBAR",
            "red lighten-2",
            "info",
            "Invalid authentication credentials."
          );
          console.log("loginVuex error");
        }

        if (response.data.status == "loginVuex token_error") {
          console.log("token error");

          // color, icon, message
          window.getApp.$emit(
            "APP_SHOW_SNACKBAR",
            "red lighten-2",
            "info",
            "Invalid authentication token."
          );
          console.log("loginVuex error");
        }

        if (response.data.status == "success") {
          // console.log('success');

          // sessionStorage.setItem('login_welcome_message', '1')

          const authData = {
            loggred_in: true,
            token: response.data.token,
            group_id: response.data.config.group_id,
            group_name: response.data.config.group_name,
          };

          if (response.data.config.group_id == 200) {
            console.log("public user");
            const post = response.data.config;
            dispatch("loadPublicPortfolio", { post });
          }

          const axiosDefaults = require("axios/lib/defaults");
          // axiosDefaults.baseURL = store.state.baseUrl
          axiosDefaults.headers = {
            "Content-Type": "application/x-www-form-urlencoded",
            Authorization: "Bearer " + response.data.token,
          };

          const post = response.data.config;

          // if (profile.profileData != '') {
          // 	profile.profileData = JSON.parse(profile.profileData)
          // }

          commit("SET_authState", authData);
          commit("SET_profile", post);

          router.push("/profile/info");
        }
      });
    },

    saveProfile({ commit, rootState }, { post, options }) {
      const data = post;

      axios.post("user/saveProfile/" + options.type, data).then((response) => {
        if (response.data.status == "success") {
          if (!rootState.publicData.moderating) {
            const post = response.data.config;
            commit("SET_profile", post);
            console.log("admin profile reloaded.");
          }

          if (rootState.publicData.moderating) {
            const post = response.data.config;
            commit("SET_publicProfile", post);
            console.log("public profile reloaded.");
          }

          // color, icon, message
          if (options.snackbar != false) {
            window.getApp.$emit(
              "APP_SHOW_SNACKBAR",
              "grey darken-1",
              "mdi-information-variant",
              "Inställningar sparade."
            );
          }
          console.log("Saved");
          window.getApp.$emit("APP_PROFILE_SAVE_LOADING", false);
        } else {
          // color, icon, message
          window.getApp.$emit(
            "APP_SHOW_SNACKBAR",
            "grey darken-1",
            "mdi-information-variant",
            "ett fel uppstod"
          );
          window.getApp.$emit("APP_PROFILE_SAVE_LOADING", false);

          console.log("Error saving...");
        }
      });
    },

    saveProfileAvatar({ commit, dispatch, rootState }, { post, options }) {
      const data = post;

      axios
        .post("user/saveProfileAvatar/" + options.type, data)
        .then((response) => {
          if (response.data.status == "success") {
            if (!rootState.publicData.moderating) {
              const profile = response.data.config;
              commit("SET_profile", profile);
            } else {
              const post = response.data.config;
              dispatch("loadPublicProfile", { post });
            }

            // color, icon, message
            if (options.snackbar != false) {
              window.getApp.$emit(
                "APP_SHOW_SNACKBAR",
                "grey darken-1",
                "mdi-information-variant",
                "Inställningar sparade."
              );
            }
            console.log("Saved");
          } else {
            // color, icon, message
            window.getApp.$emit(
              "APP_SHOW_SNACKBAR",
              "grey darken-1",
              "mdi-information-variant",
              "ett fel uppstod"
            );
            console.log("Error saving...");
          }
        });
    },

    saveProfileBackground({ commit, dispatch, rootState }, { post, options }) {
      const data = post;

      axios
        .post("user/saveProfileBackground/" + options.type, data)
        .then((response) => {
          if (response.data.status == "success") {
            if (!rootState.publicData.moderating) {
              const profile = response.data.config;
              commit("SET_profile", profile);
            } else {
              const post = response.data.config;
              dispatch("loadPublicProfile", { post });
            }

            // color, icon, message
            if (options.snackbar != false) {
              window.getApp.$emit(
                "APP_SHOW_SNACKBAR",
                "grey darken-1",
                "mdi-information-variant",
                "Inställningar sparade."
              );
            }
            console.log("Saved");
          } else {
            // color, icon, message
            window.getApp.$emit(
              "APP_SHOW_SNACKBAR",
              "grey darken-1",
              "mdi-information-variant",
              "ett fel uppstod"
            );
            console.log("Error saving...");
          }
        });
    },

    logoutVuex({ commit }) {
      sessionStorage.clear();
      commit("SET_logout");
      router.push("/");
    },
  },

  mutations: {
    SET_profile(state, data) {
      state.userProfile = data;
    },

    SET_authState(state, data) {
      state.login = data;
    },

    SET_logout(state) {
      state.login = {};
      state.userProfile = {};
    },
  },
};

export default sessionData;
