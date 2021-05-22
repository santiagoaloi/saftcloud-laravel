import { store } from "@/store";

export default {
  loggedIn() {
    // If no token exists in VUEX, router understands that you aren't logged-in.
    let token = store.get("authentication@session.token");
    if (token != undefined) {
      return true;
    }
  }
};
