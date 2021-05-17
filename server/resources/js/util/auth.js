import { store } from "@/store";

export default {
  loggedIn() {
    // If no token exists in VUEX, don't set the token bearer in header.
    let token = store.get("authentication@session.token");

    if (token != undefined) {
      return true;
    }
  }
};
