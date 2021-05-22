import staticRoutes from "@/router/static";
import publicRoutes from "@/router/public";

export default [
  {
    path: "/",
    name: "initial",
    meta: { layout: "public_layout" },
    redirect: {
      path: "/homepage",
      meta: {
        layout: "public_layout"
      }
    }
  },

  ...staticRoutes,
  ...publicRoutes
];
