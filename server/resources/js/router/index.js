import Vue from "vue";
import Router from "vue-router";
import routes from "@/router/routes";
import auth from "@/util/auth";
import { store } from "@/store";

//Removes the error of duplicate routes.
const originalPush = Router.prototype.push;
Router.prototype.push = function push(location) {
  return originalPush.call(this, location).catch((err) => err);
};

Vue.use(Router);

const router = new Router({
  base: "/",
  mode: "hash",
  linkActiveClass: "active",

  routes: routes,

  scrollBehavior() {
    return new Promise((resolve, reject) => {
      setTimeout(() => {
        resolve({ x: 0, y: 0 });
      }, 200);
    });
  },
});

// router.beforeEach((to, from, next) => {
//   if (to.matched.some((record) => record.meta.layout === "secure_layout")) {
//     if (auth.loggedIn()) {
//       auth.verifyToken().then((response) => {
//         if (!response) {
//           store.dispatch("logoutVuex");
//           next({ path: "/login" });
//         } else {
//           next();
//         }
//       });
//     } else {
//       next({ path: "/login" });
//     }
//   } else {
//     if (to.matched.some((record) => record.meta.layout === "login_layout")) {
//       if (auth.loggedIn()) {
//         auth.verifyToken().then((response) => {
//           if (response) {
//             next();
//           } else {
//             store.dispatch("logoutVuex");
//           }
//         });
//       } else {
//         next();
//       }
//     } else {
//       next();
//     }
//   }
// });

// router.beforeResolve((to, from, next) => {
//   // If the user is already logged in
//   if (auth.loggedIn()) {
//     if (to.matched.some((record) => record.name === "login")) {
//       // Redirect to the home page instead
//       next({ path: "/desktop" });
//     } else {
//       // Continue to the login page
//       next();
//     }
//   } else {
//     next();
//   }
// });

export default router;