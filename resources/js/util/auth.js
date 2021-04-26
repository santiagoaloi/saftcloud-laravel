import { store } from "@/store";
import axios from "axios";

export default {
  loggedIn() {
    if (!store.state.sessionData.login.token) return false;
    this.verifyToken();
    return true;
  },

  verifyToken() {
    const post = {
      username: store.state.sessionData.userProfile.username,
      token: store.state.sessionData.login.token,
    };

    // if token do exists in VUEX, then verify if it matches the user current token.
    return axios
      .post(store.state.baseUrl + "/user/verifyToken/", post)
      .then((response) => {
        if (response.data.status == "validToken") {
          return true;
        } else {
          return false;
        }
      });
  },
};
