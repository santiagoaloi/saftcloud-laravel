import Vue from "vue";
import Router from "vue-router";
import routes from "@/router/routes";
import auth from "@/util/auth";

//Removes the error of duplicate routes.
const originalPush = Router.prototype.push;
Router.prototype.push = function push(location) {
 return originalPush.call(this, location).catch(err => err);
};

Vue.use(Router);

const router = new Router({
 base: "/",
 mode: "hash",
 linkActiveClass: "active",

 routes: routes
});

router.beforeEach((to, from, next) => {
 if (to.matched.some(record => record.meta.layout === "secure_layout")) {
  if (auth.loggedIn()) {
   next();
  } else {
   next({ path: "/login" });
  }
 } else {
  next();
 }
});

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
