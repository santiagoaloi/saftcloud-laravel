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
      // component: () => import(/* webpackChunkName: 'DefaultHomepage' */ '@/views/publicComponents/homepage/Index.vue'),
    }
  },

  ...staticRoutes,
  ...publicRoutes
];
