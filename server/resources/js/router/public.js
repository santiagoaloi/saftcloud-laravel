export default [
 // {
 //   path: "/elementsPreview",
 //   name: "elementsPreview",
 //   alias: "elements preview",
 //   meta: {
 //     layout: "public_layout",
 //     editable: false,
 //     spinner: false,
 //     alias: "elements preview",
 //   },
 //   component: () =>
 //     import(
 //       /* webpackChunkName: 'DefaultHomepage' */ "@/views/Public/ElementsPreview/preview.vue"
 //     ),
 // },

 {
  path: "/login",
  name: "login",
  meta: {
   layout: "login_layout"
  },
  transition: "fade",
  component: () => import(/* webpackChunkName: 'login-page' */ "@/views/Login/Index.vue")
 },
 {
  path: "/homepage",
  name: "homepage",
  alias: "Homepage",
  meta: {
   layout: "public_layout",
   editable: true,
   spinner: false,
   alias: "Homepage"
  },
  component: () => import(/* webpackChunkName: 'DefaultHomepage' */ "@/views/Public/Homepage/Index.vue")
 },

 // {
 //   path: "/pub_aktuellt",
 //   name: "pub_aktuellt",
 //   alias: "Aktuellt",
 //   meta: {
 //     layout: "public_layout",
 //     editable: true,
 //     spinner: false,
 //     alias: "Aktuellt",
 //   },
 //   component: () =>
 //     import(
 //       /* webpackChunkName: 'Aktuellt' */ "@/views/Public/Aktuellt/Aktuellt.vue"
 //     ),
 // },

 // {
 //   path: "/aktuelltArticle",
 //   name: "aktuelltdrilldown",
 //   alias: "Aktuellt Drilldown",
 //   meta: {
 //     layout: "public_layout",
 //     editable: false,
 //     spinner: true,
 //     alias: "Aktuellt Drilldown",
 //   },
 //   component: () =>
 //     import(
 //       /* webpackChunkName: 'aktuelltdrilldown' */ "@/views/Public/Aktuellt/Drilldown.vue"
 //     ),
 // },

 // {
 //   path: "/medlem",
 //   name: "medlem",
 //   alias: "Medlem",
 //   meta: {
 //     layout: "public_layout",
 //     editable: true,
 //     spinner: true,
 //     alias: "Medlem",
 //   },
 //   component: () =>
 //     import(
 //       /* webpackChunkName: 'medlem' */ "@/views/Public/Medlem/Medlem.vue"
 //     ),
 // },

 // {
 //   path: "/press",
 //   name: "press",
 //   alias: "Press",
 //   props: true,
 //   meta: {
 //     layout: "public_layout",
 //     editable: true,
 //     spinner: true,
 //     alias: "Press",
 //   },
 //   component: () =>
 //     import(
 //       /* webpackChunkName: 'medlem' */ "@/views/Public/Press/Press.vue"
 //     ),
 // },

 // {
 //   path: "/om",
 //   name: "om",
 //   alias: "Om oss",
 //   meta: {
 //     layout: "public_layout",
 //     editable: true,
 //     spinner: true,
 //     alias: "Om oss",
 //   },
 //   component: () =>
 //     import(
 //       /* webpackChunkName: 'medlem' */ "@/views/Public/Om/Om.vue"
 //     ),
 // },

 // {
 //   path: "/kontakt",
 //   name: "kontakt",
 //   alias: "Kontakt",
 //   meta: {
 //     layout: "public_layout",
 //     editable: true,
 //     spinner: true,
 //     alias: "Kontakt",
 //   },
 //   component: () =>
 //     import(
 //       /* webpackChunkName: 'medlem' */ "@/views/Public/Kontakt/Kontakt.vue"
 //     ),
 // },

 // {
 //   path: "/english",
 //   name: "English",
 //   alias: "English",
 //   meta: {
 //     layout: "public_layout",
 //     editable: true,
 //     spinner: true,
 //     alias: "English",
 //   },
 //   component: () =>
 //     import(
 //       /* webpackChunkName: 'medlem' */ "@/views/Public/English/English.vue"
 //     ),
 // },

 // {
 //   path: "/portfolio",
 //   props: true,
 //   name: "portfolio",
 //   alias: "Portfolio",
 //   meta: {
 //     layout: "public_layout",
 //     editable: false,
 //     spinner: true,
 //     alias: "Portfolio",
 //   },
 //   component: () =>
 //     import(
 //       /* webpackChunkName: 'portfolio' */ "@/views/Public/Portfolio/Portfolio.vue"
 //     ),
 // },

 {
  path: "/signup",
  props: true,
  name: "signup",
  alias: "Signup",
  meta: {
   layout: "public_layout",
   editable: false,
   spinner: true,
   alias: "Signup"
  },
  component: () => import(/* webpackChunkName: 'Signup' */ "@/views/Public/Signup/Signup.vue")
 },
 {
  path: "/verifyAccount",
  props: true,
  name: "verifyAccount",
  alias: "VerifyAccount",
  meta: {
   layout: "public_layout",
   editable: false,
   spinner: true,
   alias: "VerifyAccount"
  },
  component: () => import(/* webpackChunkName: 'Signup' */ "@/views/Public/Signup/VerifyAccount.vue")
 }

 // {
 //   path: "/profiles",
 //   name: "profiles",
 //   alias: "Portfolio Drilldown",
 //   meta: {
 //     layout: "public_layout",
 //     editable: false,
 //     spinner: true,
 //     alias: "Portfolio Drilldown",
 //   },
 //   component: () =>
 //     import(
 //       /* webpackChunkName: 'portfoliotdrilldown' */ "@/views/Public/Portfolio/Drilldown.vue"
 //     ),
 // },
];
