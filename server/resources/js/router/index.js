import Vue from "vue";
import Router from "vue-router";
import routes from "@/router/routes";
import auth from "@/util/auth";
import { store } from "@/store";

Vue.use(Router);

const router = new Router({
 base: "/",
 mode: "hash",
 linkActiveClass: "active",

 routes: routes
});

const waitForStorageToBeReady = async (to, from, next) => {
 if (to.matched.some(record => record.meta.layout === "secure_layout")) {
  if (auth.loggedIn()) {
   await store.restored;
   next();
  } else {
   await store.restored;
   next({ path: "/login" });
  }
 } else {
  next();
 }
};

router.beforeEach(waitForStorageToBeReady);

router.beforeResolve((to, from, next) => {
 // If the user is already logged in
 if (auth.loggedIn()) {
  if (to.matched.some(record => record.name === "login")) {
   // Redirect to the home page instead
   next({ path: "/components" });
  } else {
   // Continue to the login page
   next();
  }
 } else {
  next();
 }
});

export default router;
