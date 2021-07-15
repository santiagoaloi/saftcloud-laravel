export default [
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
  component: () => import(/* webpackChunkName: 'public-homepage' */ "@/views/Public/Homepage/Index.vue")
 },

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
  component: () => import(/* webpackChunkName: 'signup' */ "@/views/Public/Signup/Signup.vue")
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
  component: () => import(/* webpackChunkName: 'signup-verify-account' */ "@/views/Public/Signup/VerifyAccount.vue")
 }
];
